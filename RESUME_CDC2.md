# Résumé des travaux — Second cahier des charges serenzer.com

Document de synthèse de tout ce qui a été implémenté depuis le second cahier des charges (contenu + navigation) sur le site vitrine `serenzer.com`, branche Git `dev`. Écrit pour être transmis tel quel comme contexte à une autre session.

**Périmètre technique** : fichiers sources `index.html`, `pricing.html`, `team.html`, `faq.html`, `Contact.html`, `i18n.js` dans le dépôt Git. Le site statique livré en production (19 langues) est régénéré à partir de ces sources par `gen_site.js` (hors dépôt, sur le serveur).

---

## 1. Page d'accueil (`index.html`)

- **1.1 — Intro hero** : correction d'une répétition maladroite (« organiser vos Organisations » → « structurer votre organisation »).
- **1.2 — Bloc stats** : le chiffre « 12 » remplacé par l'icône cadenas (déjà utilisée dans la section « Données protégées »), libellé « Repères personnels » → « Données confidentielles ». Ajustements visuels ultérieurs : icône recolorée en couleur encre (au lieu de l'accent sauge) pour matcher les deux autres valeurs, et hauteur commune fixée sur les trois blocs pour un alignement parfait icône / texte / labels.
- **1.3 — Section « Comment Serenzer peut vous être utile au quotidien »** : nouvelle description mentionnant explicitement organisation, rituels et challenges.
- **1.4-1.6 — Réorganisation des sections** :
  - Section « Repères » supprimée, remplacée par une nouvelle section **« Rituels et Challenges »** avec mockup de carte « Rituels du jour » (statuts Fait / Reporter / Achevé, badge « Transformé en rituel »).
  - Les deux listes à puces (ex-Repères + Organisation) fusionnées en une liste unique de 5 éléments dans la section Organisation.
  - Section Philosophie (Idées / Interactions / Organisations) supprimée entièrement.
- **1.7 — Recherche « soutien moral »** : aucune occurrence restante sur le site ; déjà reformulé ailleurs en « une présence constante » / « à votre rythme ».
- **1.8 — Lien RGPD** : le sigle est désormais cliquable, traduit selon le sigle officiel local par langue (RGPD / GDPR / DSGVO / AVG / RODO…), avec un exposant UE/EU et un lien vers la page EUR-Lex correspondante (langue par langue, fallback anglais pour les langues hors UE).
- **1.9 — CTA final** : nouveau titre, description supprimée.
- **1.9 (bis) — Section « Un fonctionnement simple en quatre étapes »** :
  - Sous-titre de section supprimé.
  - Description sous chacune des 4 étapes supprimée.
  - Étape 3 : « Structurez » → « Parlez à votre coach ».
  - Étape 4 : « Suivez » → « Utilisez les outils ».
  - Titre de section et pastilles numérotées (1/2/3/4) inchangés.
  - Ajustements visuels ultérieurs : pastilles + titres centrés (au lieu d'alignés à gauche), titres passés en police Inter (corps de texte) au lieu de Fraunces (titres).

## 2. Navigation — header (toutes les pages)

Simplifiée à 4 liens harmonisés partout : **Accueil / À propos / Offres / FAQ**.
- Accueil → haut de la page d'accueil
- À propos → ancre `#features` sur la home (section « Comment Serenzer peut vous être utile au quotidien »), ne pointe plus vers `team.html`
- Offres → `pricing.html`
- FAQ → `faq.html` (page dédiée dans les 19 langues, plus une simple ancre)

## 3. Navigation — footer (toutes les pages)

- **Colonne Produit** : initialement Accueil / À propos / Langues / FAQ / Offres, puis **réduite sur demande à Accueil / FAQ / Offres** uniquement.
- **Colonne Société** : Se connecter, « Qui sommes-nous ? » (renommage d'« Équipe »). Le lien Contact a été retiré de cette colonne.
- **Colonne Légal** : inchangée.
- **Ligne de copyright** : restructurée sur une seule ligne, 3 éléments de même style visuel : copyright « © 2026 Serenzer Limited... » (gauche) · `apps.serenzer.com` (milieu) · « Une question ? Écrivez-nous. » vers `Contact.html` (droite, discret uniquement par sa position, pas par un style différent).

## 4. Page Offres (`pricing.html`)

Renommage complet « Tarifs » (ex-« Abonnements ») → **Offres** : label au-dessus du titre, H1 (« Des offres simples, sans surprise. »), meta title. Fait dans les 19 langues.

## 5. Page Équipe (`team.html`)

- Label au-dessus du titre : « L'histoire de Serenzer » → **« QUI SOMMES-NOUS »**.
- Titre : « Un projet de famille, pas un garage de la Silicon Valley. » → **« Un projet né autour d'une table familiale, pas dans un garage de la Silicon Valley. »**

---

## Règles transversales respectées

- Toute modification de texte traduite dans les **19 langues** (fr, en, de, it, es, nl, pt, da, sv, no, pl, ru, tr, ar, he, hi, ja, ko, zh) via `i18n.js`, avec adaptation culturelle par langue (pas de traduction littérale).
- Aucun tiret cadratin (—) introduit ; ponctuation standard (deux-points, virgules, « · ») utilisée à la place.
- Structure `data-i18n` / `data-i18n-html` préservée pour compatibilité avec le pipeline `gen_site.js`.
- Compatibilité mobile responsive conservée (menu burger, breakpoints existants non modifiés par ces changements de contenu).

## Points en attente / hors périmètre (rappel)

- Réduction de l'abonnement annuel de 34 % à ~16 % (en mémoire, cahier des charges séparé à venir).
- Intégration calendrier (en attente de support d'autres fournisseurs de messagerie).
- Sélecteur de langue pour les pages légales `apps.serenzer.com` (hors périmètre vitrine).
- Validation visuelle fine du responsive (320px / 375px / 768px) sur les toutes nouvelles sections (carte Rituels et Challenges, lien RGPD, footer 3 colonnes) — non testée en navigateur réel par l'agent, à confirmer visuellement.

## État Git

Toutes les modifications sont commitées et poussées sur la branche **`dev`** du dépôt `kebabmax/serenzersite`, dernier commit : `04734cd` (« Titres des étapes en Inter au lieu de Fraunces »).

Cycle de déploiement serveur (zouljore) :
```bash
cd /home/serenzer/public_html
cp -r /home/serenzer/public_html /home/serenzer/backups/public_html_$(date +%Y%m%d_%H%M%S)
git checkout -- . && git pull origin dev
node /root/gen_site.js
rsync -av --exclude='.git' /root/gen_out/ /home/serenzer/public_html/
```
