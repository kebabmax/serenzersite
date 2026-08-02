# Journal des modifications — serenzer.com

Documentation de l'ensemble des travaux effectués sur le site vitrine `serenzer.com` (branche `dev`), en deux temps : un premier cahier des charges QA (14 points) puis un second cahier des charges de contenu/navigation.

**Périmètre** : `index.html`, `pricing.html`, `team.html`, `faq.html`, `Contact.html`, `i18n.js`. Ne concerne pas `apps.serenzer.com` (application produit).

**Auteur** : toutes les modifications documentées dans ce journal ont été réalisées par Sam.

**Pipeline de déploiement** : les fichiers ci-dessus sont des **sources** éditées dans ce dépôt Git. Le script `gen_site.js` (sur le serveur zouljore, dans `/root/gen_site.js`, **hors dépôt Git**) génère à partir de ces sources + `i18n.js` les 80 fichiers statiques (19 langues × 4 pages + racine FR) dans `/root/gen_out`, avec injection des balises SEO/hreflang/canonical et du bandeau de consentement. Cycle de déploiement standard :

```bash
cp -r /home/serenzer/public_html /home/serenzer/backups/public_html_$(date +%Y%m%d_%H%M%S)
git checkout -- . && git pull origin dev
node /root/gen_site.js
rsync -av --exclude='.git' /root/gen_out/ /home/serenzer/public_html/
```

---

## 1. Cahier des charges initial (14 points QA)

| # | Point | Traitement |
|---|---|---|
| 1 | Mention « Scout » | Supprimée entièrement (texte + illustration + CSS), 19 langues |
| 2 | Illustration conversation structurée | « Étape proposée » → « Piste de réflexion » |
| 3 | Icônes de l'illustration | Différé (hors périmètre, confirmé) |
| 4 | Tableau « repères » (Projet/Relation/Tâches/Notes) | Retiré, non conforme à l'app |
| 5 | « Vos projets » | Terminologie « projet » → « Organisation » sur tout le site |
| 6 | « Trois espaces » | Reformulé pour ne plus impliquer d'espaces dédiés fictifs |
| 7 | Nav Tarif / Fonctionnalités-Fonctionnement | Séparateur visuel + renommage (obsolète depuis simplification nav, voir §2) |
| 8 | Titre principal | Nouvelle formulation |
| 9 | Langue des pages légales | Langue active transmise via `?lang=` vers `apps.serenzer.com` |
| 10 | Onglet FAQ | Ajouté (devenu page séparée `faq.html`, voir §2) |
| 11 | Drapeaux du sélecteur de langue | Déjà conforme (aucun drapeau) |
| 12 | Mention « bêta » | Annulé (confirmé), sauf intro bêta de la FAQ |
| 13 | Copy « conversation structurée » | Nouveau texte |
| 14 | Logo | Remplacé par le fichier officiel de la charte (`serenzer-logo-declinaisons_LOGO_HORIZONTAL.png`) |

Traductions faites dans les 19 langues (fr, en, de, it, es, nl, pt, da, sv, no, pl, ru, tr, ar, he, hi, ja, ko, zh) pour chaque texte modifié.

---

## 2. Évolutions de navigation et bugs corrigés en cours de route

Une partie de ces corrections a été faite dans cette session, une autre partie en parallèle par une autre session (mêmes objectifs, fusionné proprement dans `dev`).

- **Menu mobile (hamburger)** : la nav n'était pas du tout accessible sur mobile (liens simplement cachés sous le breakpoint desktop, sans alternative). Ajout d'un bouton hamburger + panneau déroulant sur `index.html`, `pricing.html`, `team.html`, `faq.html`.
- **Nav simplifiée** : passage de 5-6 liens (Fonctionnalités, Comment ça marche, Confiance, Langues, FAQ, Tarifs) à 4 liens harmonisés partout : **Accueil / À propos / Offres / FAQ**.
  - Accueil → haut de la page d'accueil
  - À propos → ancre `#features` sur la home (section « Comment Serenzer peut vous être utile au quotidien »)
  - Offres → `pricing.html`
  - FAQ → `faq.html` (page dédiée, plus une ancre)
- **FAQ transformée en page dédiée** (`faq.html`, 19 langues) plutôt qu'une section ancrée sur la home.
- **Logo géant dans le header/footer** : bug de spécificité CSS (`.brand__mark--logo img` déclaré avant la règle générique `.brand__mark img`, donc écrasé par elle). Corrigé + `overflow:hidden` de sécurité. Ce bug provoquait aussi un effet de bord : le débordement visuel interceptait les clics destinés à la FAQ.
- **Scroll horizontal infini** : `overflow-x:hidden` ajouté sur `html,body` en filet de sécurité (attention : cette propriété peut casser `position:sticky`, d'où le point suivant).
- **Nav toujours visible** : passage de `position:sticky` à `position:fixed` (compensé par un `padding-top` sur `<main>`), pour garantir l'affichage permanent pendant le scroll.
- **Menu déroulant de langue** :
  - Passé en grille 2 colonnes (19 langues, sinon liste trop longue) avec largeur adaptative mobile.
  - Titre « Choisir la langue » ajouté en en-tête du menu pour ne pas le confondre avec l'onglet de nav « Langues ».
  - Déplacé dans le menu burger sur mobile (`.nav__right .lang-select{display:none}` par défaut, remis en `display:block`/`flex` au-delà du breakpoint desktop) pour éviter le chevauchement avec le logo sur petits écrans.
  - Regression corrigée : `overflow-x:auto` sur le menu donnait un `min-width` de 0 dans le layout flex, ce qui écrasait presque tous les liens de nav (fix : `flex-shrink:0`).
- **Favicon** : ajout de `<link rel="icon" href="/favicon.ico">` (absent auparavant, causait un flash de l'icône « globe » par défaut du navigateur).
- **Flash de langue au chargement** : le script de redirection (langue préférée → `/xx/`) était en bas de `<body>`, donc toute la page s'affichait en français avant de rediriger. Déplacé tout en haut de `<head>`, exécuté avant le premier rendu.
- **Tirets cadratins (—)** : retirés des titres/meta (`meta_title`, `hero_tag`, `f4_card_title`, etc.) dans les 19 langues, remplacés par « · ». Conservés uniquement dans la prose narrative (bios équipe) où l'usage est grammaticalement courant.
- **Renommage global** : « Abonnements » (ex-« Tarifs ») → **Offres**, sur nav, footer et page pricing.

---

## 3. Second cahier des charges (contenu + navigation)

### Page d'accueil (`index.html`)
- **1.1** Correction d'une répétition dans l'intro hero (« organiser vos Organisations » → « structurer votre organisation »).
- **1.2** Remplacement du chiffre « 12 » par l'icône cadenas (déjà utilisée pour « Données protégées ») ; libellé « Repères personnels » → « Données confidentielles ».
- **1.3** Nouvelle description sous le titre de section « Comment Serenzer peut vous être utile au quotidien ».
- **1.4-1.6** Réorganisation des sections :
  - Section « Repères » supprimée, remplacée par une nouvelle section **« Rituels et Challenges »** (mockup carte « Rituels du jour » avec statuts Fait/Reporter/Achevé et badge « Transformé en rituel »).
  - Listes à puces des sections Repères + Organisation fusionnées en une liste unique de 5 éléments dans la section Organisation.
  - Section Philosophie (Idées/Interactions/Organisations) supprimée entièrement.
- **1.7** Recherche de « soutien moral » ou formulations évoquant un accompagnement psychologique : aucune occurrence restante (déjà reformulé en « une présence constante » / « à votre rythme »).
- **1.8** Sigle RGPD rendu cliquable, traduit selon le sigle officiel local par langue (RGPD/GDPR/DSGVO/AVG/RODO…), avec exposant UE/EU et lien vers la page EUR-Lex correspondante.
- **1.9** Nouveau titre du bloc CTA final, description supprimée.
- **1.9 (bis)** Section « Un fonctionnement simple en quatre étapes » :
  - Sous-titre de section supprimé.
  - Description sous chacune des 4 étapes supprimée.
  - Étape 3 : « Structurez » → « Parlez à votre coach ».
  - Étape 4 : « Suivez » → « Utilisez les outils ».
  - Titre de section et pastilles numérotées (1/2/3/4) inchangés.

### Navigation (toutes pages)
- **2.** Header simplifié : Accueil / À propos / Offres / FAQ, avec les nouvelles destinations décrites ci-dessus.
- **3.** Footer restructuré :
  - Colonne Produit : Accueil, À propos, Langues, FAQ, Offres — puis réduite sur demande à **Accueil / FAQ / Offres** uniquement (À propos et Langues retirés de cette colonne).
  - Colonne Société : Se connecter, Qui sommes-nous ? (renommage d'Équipe). Contact retiré de cette colonne.
  - Ligne de copyright sur une seule ligne, 3 éléments de même style : copyright « © 2026 Serenzer Limited... » (gauche) · `apps.serenzer.com` (milieu) · « Une question ? Écrivez-nous. » vers `Contact.html` (droite, discret uniquement par sa position).

### Page Offres (`pricing.html`)
- **4.** Renommage complet « Tarifs » → « Offres » (label, H1, meta title), 19 langues.

### Page Équipe (`team.html`)
- **5.** Label « L'histoire de Serenzer » → « QUI SOMMES-NOUS » ; nouveau titre « Un projet né autour d'une table familiale, pas dans un garage de la Silicon Valley. »

---

## 4. Ajustements visuels post-déploiement

- **Bloc stats hero (icône cadenas / 24-7 / ∞)** : icône recolorée en `--color-encre-douce` (au lieu de l'accent sauge) pour matcher la couleur des deux autres valeurs, et hauteur commune (36px, flex `align-items:center`) fixée sur `.metric__value` pour que l'icône, les chiffres et les labels en dessous soient parfaitement alignés sur les 3 blocs.
- **Section « Un fonctionnement simple en quatre étapes »** : pastilles numérotées + titres centrés (`.step{align-items:center;text-align:center}`, auparavant alignés à gauche) ; titres des étapes passés en police Inter (`--font-body`) au lieu de Fraunces (`--font-display`).
- **Footer, colonne Produit** : réduite sur demande finale à **Accueil / FAQ / Offres** uniquement (voir §3, mise à jour).
- **`pricing.html`** : mention légale « TVA applicable » → « **Taxes applicables** » (formulation générique, sans nommer la TVA/IVA/MwSt/moms locale), traduite dans les **19 langues** (`pricing_vat_note`), mise en page inchangée.
- **`pricing.html` — tarifs annuels** : prix annuel Plus 79 € → **99,99 €** (soit 8,33 €/mois) et Premium 119 € → **149,99 €** (soit 12,50 €/mois) ; badge et mention d'économie annuelle **-34 %** → **-16 %** (`pricing_save_badge`, `pricing_save_34`, `pricing_plus_monthly_equiv`, `pricing_premium_monthly_equiv`), traduits dans les **19 langues**. Prix mensuels (9,99 €/14,99 €) et JSON-LD schema.org inchangés (hors périmètre, ne référencent que le prix mensuel).
- **`index.html` — mockup Organisations** : trait des lignes barrées (`.pstep--done .pstep__label`) harmonisé avec le style du mockup Rituels (`.rituals__item--done .rituals__label`) — suppression de `text-decoration-color:var(--color-pierre-pale)`, le trait hérite désormais de la couleur du texte muted, identique sur les deux mockups. CSS uniquement, aucune traduction concernée.

## 5. Audit de traduction (agent dédié)

Un agent a vérifié que les 5 pages (`index.html`, `pricing.html`, `team.html`, `faq.html`, `Contact.html`) sont bien traduites dans les 19 langues (clés `data-i18n`/`-html`/`-bullets`/`-tags` toutes présentes, non vides, cohérentes).

- **Bug bloquant trouvé et corrigé** : les clés `faq_title` et `faq_subtitle` (titre et sous-titre H1 de la page FAQ) étaient totalement absentes d'`i18n.js` — le texte français codé en dur dans `faq.html` restait donc affiché dans les 19 langues. Ajoutées et traduites.
- **Point vérifié non-bloquant** : `rit_item1_label` (« Sport · 30 min ») identique au français dans 7 langues (en, it, nl, da, sv, no, pl) — confirmé légitime, « Sport » étant un mot emprunté valide dans ces langues, pas un oubli de traduction.
- **RAS** : les 19 blocs de langue ont exactement les mêmes 210 clés chacun, aucune valeur vide, structure FAQ imbriquée (`faq.cats[].items[]`) cohérente sur toutes les langues, aucune clé orpheline côté HTML.

### 5bis. Audit culturel (9 agents dédiés, un par famille de langues) + audit clés orphelines

- **Tirets cadratins (règle stricte)** : 43 occurrences supprimées dans `i18n.js` (principalement dans les bios de l'équipe `team.html`), reformulées avec virgule/deux-points/parenthèses selon le contexte — EN (5), DA (5), HI (4), JA (4), RU (7), PL (5), NL (1), ZH (1), HE (3). FR, DE, IT, ES, PT, SV, NO, TR, AR, KO : RAS.
- **Bug de corruption de texte corrigé** : clé `team_lead1`, caractères chinois « 引搬(家) » insérés par erreur à la place du mot « déménagement » en **hébreu** et en **hindi** (probablement un résidu d'une traduction en lot antérieure). Corrigé dans les deux langues.
- **Erreurs grammaticales corrigées** (`mockup_ai_1` et clés associées) : accord de genre/nombre de « Organisation » selon la langue — DE (« ein »→« eine »), IT (élision « un'Organizzazione »), ES (« un »→« una »), PT (« um »→« uma »), DA/NO (« et »→« en »), SV (« ett…Organisationer »→« en…Organisation »), PL (déclinaison « Organizacjau »→« Organizacji »), RU (accusatif « Организация »→« Организацию »), TR (suffixe « Organizasyonyi »→« Organizasyonu »), EN (article « a »→« an »).
- **Incohérence de registre corrigée** : formulaire de contact (`Contact.html`) en **italien** et **espagnol** vouvoyait (voi/vostro, usted) alors que tout le reste du site en IT/ES tutoie — harmonisé en tutoiement partout, cohérent avec le reste du site.
- **Ton EN** : « realised »/« organise » (BrE) mélangés à « organize » (AmE) dans `team_lead1` → uniformisés en AmE ; formulation « point of honor » remplacée par « prioritize ».
- **Audit clés orphelines** : `pricing_feat_progress` confirmée totalement inutilisée, à supprimer si souhaité. `nav_features`, `nav_how`, `nav_languages`, `nav_trust`, `footer_legal_contact` ne sont plus référencées dans `index.html`/`pricing.html` sources actuels, mais restent présentes dans les dossiers `fr/`, `en/`, etc. (sortie générée committée par la session parallèle via des commits « regen: ») — non supprimées par prudence, à trancher lors d'un nettoyage dédié.
- **Incohérence FAQ identifiée (non corrigée)** : 2 réponses FAQ ont un lien cliquable (`linkLabel`/`linkHref`, vers la politique de confidentialité et la page tarifs) uniquement en FR ; absent dans les 18 autres langues. À traiter dans un prochain lot si souhaité.

### 5ter. Deuxième vague d'audits (rendu/polices, re-vérification traduction, liens) — 10 agents dédiés

- **Polices/rendu** : vérifié en direct (curl sur l'URL Google Fonts réelle) que l'API CSS2 de Google Fonts inclut déjà nativement les blocs Unicode latin-étendu et cyrillique (pas de risque de caractère manquant pour PL/TR/RU comme deux agents l'avaient d'abord suggéré à tort — faux positif corrigé après vérification). Fraunces/Inter ne couvrent pas ar/he/hi/ja/ko/zh : bascule automatique vers la police de repli système, comportement normal et sans caractère manquant.
- **RTL (arabe, hébreu) — lacune réelle corrigée** : `team.html` n'avait **aucune** règle CSS `[dir="rtl"]` (hero, portrait/pastilles décalées, bio dépliable non adaptées) ; ajoutées. `pricing.html` incomplet (curseur du toggle mensuel/annuel et compteur de fonctionnalités non adaptés en RTL) ; complété.
- **Bug de contenu majeur corrigé — désynchronisation `dual_card1`/`dual_card2`** : le FR avait été réécrit (« Une présence constante » / « À votre rythme », avec tags et description associées) mais les **18 autres langues** affichaient encore l'ancien contenu (« Clarity/Klarheit/... » « Organization/Organisation/... »), jamais mis à jour lors de la refonte FR. Traduit et resynchronisé dans les 19 langues (titres, descriptions, tags).
- **Bug factuel corrigé — « 20 langues » au lieu de 19** : la bio de Samuel (`m_samuel_line`/`m_samuel_bio`) annonçait 20 langues dans **18 langues sur 19** (seul le FR disait correctement 19). Corrigé partout.
- **ZH — doublon corrigé** : « 组织（Organisation）» (gloss redondante en français) à 3 endroits, incohérent avec le reste du bloc chinois qui utilise simplement « 组织 » ; supprimé.
- **NL — vouvoiement isolé corrigé** : `pricing_faq_*`, `pricing_cta_sub`, `cookie_text` vouvoyaient (« u », « uw ») alors que tout le reste du site NL tutoie (« je », « jouw ») ; harmonisé. Typo « gesprèk » → « gesprek » (2 occurrences).
- **Liens et boutons (agent dédié)** : aucun bouton mort, aucune ancre cassée, sélecteur de langue robuste. Le paramètre `?lang=fr` dans `Contact.html` (lien politique de confidentialité) a été vérifié : **faux positif**, c'est le comportement attendu du gabarit FR par défaut (`i18n.js` utilise bien `?lang=__LANG__` pour les 19 langues générées).
- **Re-vérification complète des 19 langues post-correction** : FR/RU/TR/AR/HE/HI/JA/KO/ZH confirmées RAS après la première vague de corrections. IT/ES confirmées RAS (tutoiement cohérent).

### 5quater. Dernier lot de corrections (points restants de §5ter) + simplification Git

- **SV** : `rit_item4_label` « 7-dagarsutmaning » (mot collé) → « 7-dagars utmaning ».
- **NO** : suppression de 2 caractères de soft-hyphen invisibles dans `m_raphael_bio` (« musikk­produsent » → « musikkprodusent », « Ny­generasjons » → « Nygenerasjons ») ; correction de casse `f1_desc` « organisasjonene » → « Organisasjonene » (cohérent avec le reste du bloc NO qui capitalise le terme produit).
- **FAQ — liens traduits dans les 18 langues manquantes** : les 2 réponses avec lien cliquable (politique de confidentialité, page tarifs), jusque-là présentes en FR uniquement, ont désormais leur `linkLabel` traduit et `linkHref` dans toutes les langues.
- **Liens de nav harmonisés** : `pricing.html` et `faq.html` utilisaient des liens absolus (`href="/"`, `href="/faq.html"`) qui, une fois générés dans les sous-dossiers de langue (`/en/pricing.html`, `/de/faq.html`, etc.), renvoyaient vers la racine FR par défaut au lieu de rester dans la langue courante — **vrai bug de navigation corrigé** en passant en liens relatifs (`href="./"`, `href="faq.html"`), cohérents avec `team.html`.
- **Nettoyage des 6 clés mortes** confirmées (`nav_features`, `nav_how`, `nav_languages`, `nav_trust`, `footer_legal_contact`, `pricing_feat_progress`) supprimées des 19 blocs de langue — sans risque, `gen_site.js` régénère entièrement les dossiers de langue à partir des sources à chaque déploiement.
- **Simplification du workflow Git** : suppression de la branche `claude/site-cahier-charges-qa0soi` (entièrement fusionnée dans `dev`, locale + tentative distante) et tentative de suppression de la branche distante `test-perm-check-2` (ancien instantané de test isolé). La branche `master` est conservée intentionnellement (un processus externe non identifié la met à jour automatiquement par merge depuis `dev`). **Note** : la suppression des branches distantes a été bloquée (erreur 403, identifiants Git en lecture/écriture seule sans droit de suppression) — à faire manuellement depuis l'interface GitHub.

## 6. Modifications en parallèle (autre session, fusionnées dans `dev`)

D'autres évolutions ont été faites par une session concurrente sur la branche `dev` et intégrées sans conflit :

- Sélecteur de langue mobile rendu repliable dans le menu burger (grille des 19 langues masquée par défaut, dépliable).
- Badge « Le plus populaire » du plan Plus traduit dans les 19 langues.
- Suppression de la ligne de séparation verticale entre Offres et FAQ dans la navbar.
- Renommage du lien de nav « À propos » en **« Fonctionnalités »**, avec surlignage actif dynamique selon la section visible sur l'accueil (scroll-spy).
- QA copy Accueil/Offres : espace insécable avant les deux-points, exemple de challenge ajouté, explication du concept « Organisations », harmonisation des CTA des offres.
- Audit de cohérence SEO : sitemap FAQ, JSON-LD et Open Graph manquants sur la page Offres, `llms.txt` mis à jour.
- Ajout du snippet Google Consent Mode v2 + Google Tag Manager (`GTM-MK96QMHK`) dans `team.html` et `faq.html`, aligné sur le mécanisme déjà présent ailleurs (bandeau cookies `srz-consent`).

## 6bis. Troisième vague d'audit (responsive, formulaire de contact, cookies, sources vs sortie générée)

- **Bug réel corrigé — breakpoint nav incohérent** : `pricing.html`/`faq.html` basculaient du menu burger à la nav desktop à `768px`, alors qu'`index.html`/`team.html` basculaient à `960px`. Entre 768 et 959px, la nav différait selon la page visitée. Harmonisé à `960px` partout.
- **Formulaire de contact (`Contact.html`) durci** : suppression de l'attribut `novalidate` qui désactivait toute validation HTML5 native malgré les champs `required`/`type="email"` (validation reposait uniquement sur `send.php`, hors dépôt) ; ajout de `maxlength` sur les 4 champs (cohérent avec le message `contact_form_toolong` déjà existant) ; ajout d'une désactivation du bouton d'envoi à la soumission pour éviter un double-envoi par double-clic.
- **Contact.html sans menu burger** : vérifié intentionnel (nav volontairement simplifiée, logo + lien retour uniquement), aucune action.
- **Bandeau cookies / GTM** : vérifié que le tag Google Tag Manager se charge selon le pattern standard « Google Consent Mode v2 » (statut de consentement transmis en amont, mode par défaut « denied »). Ce n'est pas un bug de code, mais la conformité RGPD réelle dépend de la configuration interne du conteneur GTM (quels tags attendent le consentement), invisible depuis ce dépôt — **point de vigilance à vérifier côté configuration GTM**, aucun correctif de code appliqué.
- **Dossiers de langue générés (`fr/`, `en/`, etc.)** : confirmé obsolètes (~4,5 jours de décalage avec les sources), avec divergences de contenu réelles. Comportement attendu : ces dossiers committés sont des instantanés écrasés à chaque déploiement (`gen_site.js` + rsync), aucune action nécessaire dans le dépôt.

## 6ter. Corrections issues d'un rapport externe (comparatif HE vs FR)

Un rapport externe comparant `/fr/` et `/he/` a signalé 10 « bugs » hébreu. Vérification de chacun un par un : la plupart n'étaient **pas spécifiques à l'hébreu** mais des enrichissements faits sur le FR à un moment donné, jamais propagés aux 18 autres langues (même schéma que la désynchronisation `dual_card1/2` déjà corrigée une fois auparavant).

- **Vrai bug HE corrigé** : accord de genre dans `m_maya_bio` (« הילד השני », masculin, suivi d'un verbe féminin) → « הילדה השנייה ».
- **5 contenus FR enrichis, jamais propagés, traduits dans les 18 autres langues** :
  - `m_raphael_bio` : clôture « Touche-à-tout, il produit aussi des chanteurs corses à ses heures perdues » — les 18 langues n'avaient que l'équivalent de « également producteur de musique ».
  - `m_maya_bio` : précision « à Montréal » absente des 18 langues.
  - `m_noe_bio` : précision « aujourd'hui étudiant aux Pays-Bas » absente des 18 langues.
  - `f4_desc` : version étendue (clause template/page libre + phrase sur la persistance/l'envoi par email) — les 18 langues n'avaient que la première moitié de la phrase.
  - `team_lead2` : à l'inverse, une clause redondante (déjà présente dans `team_lead1`) a été retirée du FR mais était encore présente dans 15 des 18 autres langues — retirée pour s'aligner sur le FR actuel.
- **Oubli de ma précédente correction complété** : lors de la resynchronisation `dual_card1`/`dual_card2` (voir §5ter), les descriptions (`dual_card1_desc`/`dual_card2_desc`) n'avaient pas été mises à jour pour TR, AR, HE, HI, JA, KO et ZH (seuls titres et tags l'avaient été) — complété.
- **Slogan footer retraduit** : `footer_tagline`/`contact_footer_tagline`, figé en anglais dans les 19 langues (voir §6, décision d'une session parallèle), a été retraduit par langue sur décision explicite de l'utilisateur.
- **Confirmé non-bug** : le lien RGPD pointant vers l'édition anglaise d'EUR-Lex pour l'hébreu est voulu — chaque langue pointe vers sa propre édition EUR-Lex, et les langues sans édition dédiée (HE, AR...) retombent légitimement sur `/EN/`.

## 7. Hors périmètre / en attente (rappel)

- Icônes de l'illustration (différé)
- Mention bêta (annulée, sauf intro FAQ)
- Intégration calendrier (en attente de support d'autres fournisseurs de messagerie)
- Sélecteur de langue pour les pages légales `apps.serenzer.com` (hors périmètre vitrine)
- Message d'accueil « coach » dans le mockup chat

## 8. À vérifier avant mise en production définitive

- Responsive à 320px / 375px / 768px sur les nouvelles sections (carte Rituels et Challenges, lien RGPD, footer 3 colonnes).
- Vérification Search Console post-déploiement (indexation, hreflang/canonical) sur les pages modifiées, notamment `faq.html` nouvellement créée par langue.
