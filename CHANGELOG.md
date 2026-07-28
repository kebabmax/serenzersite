# Journal des modifications — serenzer.com

Documentation de l'ensemble des travaux effectués sur le site vitrine `serenzer.com` (branche `dev`), en deux temps : un premier cahier des charges QA (14 points) puis un second cahier des charges de contenu/navigation.

**Périmètre** : `index.html`, `pricing.html`, `team.html`, `faq.html`, `Contact.html`, `i18n.js`. Ne concerne pas `apps.serenzer.com` (application produit).

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

## 5. Hors périmètre / en attente (rappel)

- Icônes de l'illustration (différé)
- Mention bêta (annulée, sauf intro FAQ)
- Intégration calendrier (en attente de support d'autres fournisseurs de messagerie)
- Réduction de l'abonnement annuel de 34% à ~16% (en mémoire, cahier des charges séparé à venir)
- Sélecteur de langue pour les pages légales `apps.serenzer.com` (hors périmètre vitrine)
- Message d'accueil « coach » dans le mockup chat

## 6. À vérifier avant mise en production définitive

- Responsive à 320px / 375px / 768px sur les nouvelles sections (carte Rituels et Challenges, lien RGPD, footer 3 colonnes).
- Vérification Search Console post-déploiement (indexation, hreflang/canonical) sur les pages modifiées, notamment `faq.html` nouvellement créée par langue.
