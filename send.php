<?php
/**
 * Serenzer — Traitement du formulaire de contact
 *
 * Envoi via SMTP Google (smtp.gmail.com:587, TLS) avec PHPMailer.
 *
 * Pré-requis :
 *   1. Installer PHPMailer  :  composer require phpmailer/phpmailer
 *      (ou inclure manuellement les fichiers de la lib PHPMailer)
 *   2. Créer un fichier .env à la racine (ou dans un dossier privé hors-public)
 *      contenant les clés ci-dessous.
 *
 * Exemple de .env :
 *   SMTP_HOST=smtp.gmail.com
 *   SMTP_PORT=587
 *   SMTP_USER=contact@serenzer.com
 *   SMTP_PASS=xxxxxxxxxxxxxxxx          ; mot de passe d'application Google (16 caractères)
 *   MAIL_FROM=contact@serenzer.com
 *   MAIL_FROM_NAME=Serenzer
 *   MAIL_TO=contact@serenzer.com
 *
 * Le formulaire envoie les champs : prenom, email, sujet, message
 * (cf. Contact.html — méthode POST, action="send.php")
 */

declare(strict_types=1);

// ----------------------------------------------------------------------------
// 1. Petit chargeur .env (sans dépendance Composer pour cette partie)
// ----------------------------------------------------------------------------
function load_env(string $path): void {
    if (!is_readable($path)) {
        return;
    }
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#' || $line[0] === ';') {
            continue;
        }
        if (!str_contains($line, '=')) {
            continue;
        }
        [$key, $value] = array_map('trim', explode('=', $line, 2));
        // retirer guillemets éventuels
        if (strlen($value) >= 2
            && (($value[0] === '"' && substr($value, -1) === '"')
             || ($value[0] === "'" && substr($value, -1) === "'"))) {
            $value = substr($value, 1, -1);
        }
        if ($key !== '' && getenv($key) === false) {
            putenv("$key=$value");
            $_ENV[$key] = $value;
        }
    }
}

// .env attendu à la racine du projet (1 niveau au-dessus du dossier public, idéalement)
load_env(__DIR__ . '/.env');
load_env(__DIR__ . '/../.env');
// fallback : .env dans un dossier privé "../private/.env"
load_env(__DIR__ . '/../private/.env');

// ----------------------------------------------------------------------------
// 2. Helpers
// ----------------------------------------------------------------------------
function env(string $key, ?string $default = null): ?string {
    $v = getenv($key);
    if ($v === false || $v === '') {
        return $default;
    }
    return $v;
}

function clean(string $s): string {
    return trim(strip_tags($s));
}

function json_response(int $code, array $payload): void {
    http_response_code($code);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($payload, JSON_UNESCAPED_UNICODE);
    exit;
}

function safe_lang(): string {
    $sup = ['fr','en','de','it','es','nl','pt','da','sv','no','pl','ru','tr','ar','he','hi','ja','ko','zh'];
    $l = strtolower(trim((string)($_POST['lang'] ?? '')));
    return in_array($l, $sup, true) ? $l : 'fr';
}

function html_redirect(string $status, string $code): void {
    // Redirection vers le Contact.html de la langue d'origine, avec un CODE
    // (le libelle est traduit cote client depuis i18n.js)
    $url = '/' . safe_lang() . '/Contact.html?status=' . urlencode($status)
         . '&code=' . urlencode($code);
    header('Location: ' . $url, true, 303);
    exit;
}

// Détection si la requête attend du JSON (fetch) ou une redirection (form classique)
function wants_json(): bool {
    $accept = $_SERVER['HTTP_ACCEPT'] ?? '';
    $xhr    = $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '';
    return str_contains($accept, 'application/json')
        || strtolower($xhr) === 'xmlhttprequest';
}

function fail(string $reason, int $http = 400, string $log = ''): void {
    if ($log !== '') { error_log('[Serenzer/send.php] ' . $log); }
    if (wants_json()) {
        json_response($http, ['ok' => false, 'code' => $reason]);
    }
    html_redirect('error', $reason);
}

function ok(string $reason = 'sent'): void {
    if (wants_json()) {
        json_response(200, ['ok' => true, 'code' => $reason]);
    }
    html_redirect('success', $reason);
}

// ----------------------------------------------------------------------------
// 3. Validation de la requête
// ----------------------------------------------------------------------------
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    fail('server', 405, 'method not allowed');
}

// Anti-spam basique : honeypot (champ caché que les bots remplissent)
if (!empty($_POST['website'] ?? '')) {
    // On répond OK silencieusement pour ne pas alerter le bot
    ok('sent');
}

$prenom  = clean((string)($_POST['prenom']  ?? ''));
$email   = clean((string)($_POST['email']   ?? ''));
$sujet   = clean((string)($_POST['sujet']   ?? ''));
$message = clean((string)($_POST['message'] ?? ''));

if ($prenom === '' || $email === '' || $sujet === '' || $message === '') {
    fail('required', 422);
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    fail('email', 422);
}
if (mb_strlen($prenom)  > 100)   fail('toolong', 422);
if (mb_strlen($sujet)   > 200)   fail('toolong', 422);
if (mb_strlen($message) > 5000)  fail('toolong', 422);

// ----------------------------------------------------------------------------
// 4. Configuration SMTP
// ----------------------------------------------------------------------------
$smtpHost     = env('SMTP_HOST', 'smtp.gmail.com');
$smtpPort     = (int) env('SMTP_PORT', '587');
$smtpUser     = env('SMTP_USER');
$smtpPass     = env('SMTP_PASS');
$mailFrom     = env('MAIL_FROM',      $smtpUser ?? 'contact@serenzer.com');
$mailFromName = env('MAIL_FROM_NAME', 'Serenzer');
$mailTo       = env('MAIL_TO',        $smtpUser ?? 'contact@serenzer.com');

if (!$smtpUser || !$smtpPass) {
    error_log('[Serenzer/send.php] SMTP_USER ou SMTP_PASS manquant dans .env');
    fail('server', 500, 'SMTP not configured');
}

// ----------------------------------------------------------------------------
// 5. Chargement de PHPMailer
// ----------------------------------------------------------------------------
$autoloadCandidates = [
    __DIR__ . '/vendor/autoload.php',
    __DIR__ . '/../vendor/autoload.php',
];
$autoloadFound = false;
foreach ($autoloadCandidates as $auto) {
    if (is_readable($auto)) {
        require_once $auto;
        $autoloadFound = true;
        break;
    }
}
if (!$autoloadFound) {
    error_log('[Serenzer/send.php] vendor/autoload.php introuvable. Installez PHPMailer via composer.');
    fail('server', 500, 'PHPMailer missing');
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;
use PHPMailer\PHPMailer\SMTP;

// ----------------------------------------------------------------------------
// 6. Envoi du mail
// ----------------------------------------------------------------------------
$mail = new PHPMailer(true);

try {
    // Serveur
    $mail->isSMTP();
    $mail->Host       = $smtpHost;
    $mail->SMTPAuth   = true;
    $mail->Username   = $smtpUser;
    $mail->Password   = $smtpPass;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // TLS sur 587
    $mail->Port       = $smtpPort;
    $mail->CharSet    = 'UTF-8';
    $mail->Encoding   = 'base64';

    // Logs serveur uniquement (pas affichés à l'utilisateur)
    $mail->SMTPDebug  = SMTP::DEBUG_OFF;

    // Expéditeur / destinataire
    $mail->setFrom($mailFrom, $mailFromName);
    $mail->addAddress($mailTo);
    $mail->addReplyTo($email, $prenom);

    // Contenu
    $mail->isHTML(true);
    $mail->Subject = '[Contact Serenzer] ' . $sujet;

    $safePrenom  = htmlspecialchars($prenom,  ENT_QUOTES, 'UTF-8');
    $safeEmail   = htmlspecialchars($email,   ENT_QUOTES, 'UTF-8');
    $safeSujet   = htmlspecialchars($sujet,   ENT_QUOTES, 'UTF-8');
    $safeMessage = nl2br(htmlspecialchars($message, ENT_QUOTES, 'UTF-8'));

    $mail->Body = <<<HTML
<!doctype html>
<html lang="fr">
<head><meta charset="UTF-8"></head>
<body style="font-family: -apple-system, Segoe UI, Inter, sans-serif; color:#2F3A3F; background:#F8F6F2; padding:24px;">
  <div style="max-width:560px; margin:auto; background:#fff; border:1px solid #EFE9DF; border-radius:16px; padding:24px;">
    <h2 style="font-family: Georgia, serif; font-weight:500; color:#2F3A3F; margin:0 0 16px;">
      Nouveau message via le formulaire de contact
    </h2>
    <p style="margin:4px 0;"><strong>Prénom :</strong> {$safePrenom}</p>
    <p style="margin:4px 0;"><strong>Email :</strong> {$safeEmail}</p>
    <p style="margin:4px 0;"><strong>Sujet :</strong> {$safeSujet}</p>
    <hr style="border:none; border-top:1px solid #EFE9DF; margin:16px 0;">
    <p style="white-space:pre-wrap; line-height:1.6;">{$safeMessage}</p>
  </div>
  <p style="max-width:560px; margin:12px auto 0; font-size:12px; color:#9A958F;">
    Envoyé depuis serenzer.com — formulaire de contact public.
  </p>
</body>
</html>
HTML;

    $mail->AltBody =
        "Nouveau message via le formulaire de contact\n\n" .
        "Prénom : {$prenom}\n" .
        "Email : {$email}\n" .
        "Sujet : {$sujet}\n\n" .
        "Message :\n{$message}\n";

    $mail->send();

    ok('sent');

} catch (PHPMailerException $e) {
    error_log('[Serenzer/send.php] PHPMailer error: ' . $mail->ErrorInfo);
    fail('server', 500);
} catch (\Throwable $e) {
    error_log('[Serenzer/send.php] Unexpected error: ' . $e->getMessage());
    fail('server', 500);
}
