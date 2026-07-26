# SERENZER — BRANDBOOK v1

**Source :** `serenzer.css v2.1` (DEV)  
**Mise à jour :** mai 2026  
**Usage :** instructions de design pour Claude / référence équipe  
**Règle absolue :** ce document est la **source de vérité** pour toute interface Serenzer (web, app, email, social, print).

---

## 1. IDENTITÉ

### Ce que Serenzer EST

Serenzer est un **assistant personnel IA** pour structurer ses idées, organiser ses projets et garder ses informations accessibles. L'interface est un **espace conversationnel calme et premium**, mobile-first, qui respecte le rythme de l'utilisateur.

### Ce que Serenzer N'EST PAS

- Pas une plateforme de bien-être / santé mentale (positionnement public fonctionnel uniquement)
- Pas un outil flashy, gamifié de manière agressive, ou basé sur la pression
- Pas un produit minimaliste froid : Serenzer est **chaleureux**, **organique**, **mesuré**

### Principes de design

| Principe | Application |
|---|---|
| **Calme** | Couleurs naturelles, pas de saturé, animations douces (≤300ms) |
| **Clarté** | Hiérarchie typographique nette, espacements généreux, un seul focus par écran |
| **Respect** | Pas d'incitations agressives, l'utilisateur valide chaque action proposée |
| **Continuité** | Le contexte est conservé visuellement (avatars, bulles, identité fixe) |
| **Multilingue par défaut** | 22 langues, RTL pris en compte, jamais d'icône-texte non traduisible |

---

## 2. LOGO

### Variantes officielles (fichiers existants)

| Fichier | Usage |
|---|---|
| `/static/serenzer_wave.png` | Logo principal (sidebar, header, mobile menu) |
| `/static/img/serenzer-button.png` | Bouton circulaire (avatar chat central, app icon-like) |
| `/static/img/emails/serenzer_logo_cercle.png` | Logo cercle pour emails (80px de large) |

### Concept

Une **vague stylisée** (symbole de fluidité, sérénité, conversation) inscrite ou flottant sur un cadre. Toujours présentée avec ou sans le mot "Serenzer" en wordmark Fraunces.

### Règles d'usage

**TOUJOURS :**
- Espacement de garde minimum : hauteur du "S" tout autour
- Taille minimum web : 24px de hauteur
- Taille minimum print : 12mm
- Wordmark à droite du symbole, aligné optiquement (pas géométriquement)

**JAMAIS :**
- Étirer, déformer, rotationner
- Ajouter ombre portée, contour, effet
- Utiliser sur fond saturé ou photo non floutée
- Recolorer le wordmark dans une autre couleur que `--color-encre-douce` ou blanc

---

## 3. PALETTE OFFICIELLE

### Les 8 couleurs nommées (source de vérité)

| Token CSS | Hex | Nom français | Usage principal |
|---|---|---|---|
| `--color-lin-calme` | `#F8F6F2` | Lin calme | Fond principal de l'app |
| `--color-cendre-tiede` | `#4E4A46` | Cendre tiède | Texte secondaire |
| `--color-argile-clair` | `#EFE9DF` | Argile clair | Bordures, état actif, btn secondary |
| `--color-pierre-pale` | `#D9D4CC` | Pierre pâle | Surfaces neutres, avatars vides |
| `--color-sauge-douce` | `#8FA89B` | Sauge douce | **Accent principal**, boutons primary, état actif |
| `--color-sable-chaud` | `#D1B38B` | Sable chaud | Warning, accent chaleureux |
| `--color-mousse-legere` | `#A6C3B3` | Mousse légère | Accent secondaire |
| `--color-encre-douce` | `#2F3A3F` | Encre douce | Texte principal |

### Couleurs sémantiques

```css
--color-background: var(--color-lin-calme);          /* #F8F6F2 */
--color-surface: #FFFFFF;
--color-text-primary: var(--color-encre-douce);      /* #2F3A3F */
--color-text-secondary: var(--color-cendre-tiede);   /* #4E4A46 */
--color-text-muted: #9A958F;
--color-text-light: #B5B0A8;
--color-accent: var(--color-sauge-douce);            /* #8FA89B */
--color-accent-hover: #7A9587;
--color-accent-light: rgba(143, 168, 155, 0.15);
--color-border: var(--color-argile-clair);           /* #EFE9DF */
--color-border-light: #F0EBE3;
--color-success: var(--color-sauge-douce);           /* #8FA89B */
--color-warning: var(--color-sable-chaud);           /* #D1B38B */
--color-error: #C97B7B;                              /* rose poudré */
```

### Règles d'usage

**TOUJOURS :**
- Utiliser les variables CSS (`var(--color-xxx)`), JAMAIS l'hex en dur
- Réserver `--color-accent` (sauge) aux actions principales et états actifs
- Combiner texte sur fond avec contraste WCAG AA minimum (4.5:1 pour body, 3:1 pour large text)

**JAMAIS :**
- Introduire une nouvelle couleur sans la nommer dans les tokens
- Utiliser le rouge vif (`#dc3545`, `#c0392b`) en dehors des actions destructives explicites (logout, delete)
- Utiliser un dégradé saturé : Serenzer est **plat et naturel**, pas glossy
- Mélanger les paradigmes (la palette `#32717b` teal des emails legacy est **dépréciée** — utiliser sauge douce)

---

## 4. TYPOGRAPHIE

### Polices officielles

```css
--font-display: 'Fraunces', Georgia, serif;     /* Titres, logo, accents */
--font-body: 'Inter', -apple-system, sans-serif; /* Texte courant, UI */
```

**Import (à inclure dans `<head>`) :**
```html
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
```

### Échelle typographique

| Token | Taille | Usage |
|---|---|---|
| `--text-xs` | 11px | Métadonnées, captions |
| `--text-sm` | 13px | Sous-titres, labels |
| `--text-base` | 15px | Body courant |
| `--text-md` | 17px | Card titles, emphases |
| `--text-lg` | 20px | Logo, headers |
| `--text-xl` | 24px | Page titles |
| `--text-2xl` | 28px | Hero titles |

### Hauteurs de ligne

```css
--leading-tight: 1.3;     /* Titres */
--leading-normal: 1.5;    /* Body */
--leading-relaxed: 1.65;  /* Bulles de chat, textes longs */
```

### Hiérarchie type

```css
/* Hero / Page title */
font-family: var(--font-display);    /* Fraunces */
font-size: var(--text-xl);            /* 24px */
font-weight: 500;
letter-spacing: -0.01em;

/* Card title */
font-family: var(--font-display);    /* Fraunces */
font-size: var(--text-md);            /* 17px */
font-weight: 500;

/* Body */
font-family: var(--font-body);       /* Inter */
font-size: var(--text-base);          /* 15px */
font-weight: 400;
line-height: 1.5;

/* Logo wordmark */
font-family: var(--font-display);    /* Fraunces */
font-size: var(--text-lg);            /* 20px */
font-weight: 500;
letter-spacing: -0.01em;
```

### Règles

- **Fraunces** : exclusivement pour les titres, logos, citations rares. Jamais pour des paragraphes ou des labels.
- **Inter** : tout le reste. Poids 400 (normal), 500 (medium, le plus utilisé), 600 (semibold pour emphase).
- **Pas de poids 700+** : Serenzer ne crie jamais.
- Sur Fraunces, toujours `letter-spacing: -0.01em` minimum (correction optique).

---

## 5. ESPACEMENTS & LAYOUT

### Échelle (base 4px)

```css
--space-xs: 4px;      --space-sm: 8px;      --space-md: 12px;
--space-lg: 16px;     --space-xl: 20px;     --space-2xl: 24px;
--space-3xl: 32px;    --space-4xl: 40px;    --space-5xl: 48px;
```

### Rayons de bordure

```css
--radius-xs: 4px;       /* coin "pointu" des bulles */
--radius-sm: 8px;       /* badges, petits éléments */
--radius-md: 12px;      /* inputs, list-items */
--radius-lg: 16px;      /* cards, btn standard */
--radius-xl: 20px;      /* bulles de message */
--radius-2xl: 24px;
--radius-full: 9999px;  /* avatars, badges pill */
```

### Ombres

```css
--shadow-sm: 0 1px 3px rgba(47, 58, 63, 0.04);    /* cards */
--shadow-md: 0 2px 8px rgba(47, 58, 63, 0.06);    /* input chat */
--shadow-lg: 0 4px 16px rgba(47, 58, 63, 0.08);   /* dropdowns */
--shadow-xl: 0 8px 24px rgba(47, 58, 63, 0.1);    /* modales */
--shadow-accent: 0 4px 12px rgba(143, 168, 155, 0.35); /* btn central chat */
```

### Layout

```css
--header-height: 60px;
--nav-height: 75px;          /* bottom-nav mobile */
--sidebar-width: 240px;       /* desktop */
--max-width-mobile: 480px;    /* container app mobile */
--safe-area-bottom: env(safe-area-inset-bottom, 0px);  /* iOS notch */
```

**Mobile-first :** la base est mobile (max 480px), la sidebar et le header desktop apparaissent à `min-width: 769px`.

### Transitions

```css
--transition-fast: 100ms ease;     /* hover quick */
--transition-normal: 150ms ease;   /* défaut */
--transition-slow: 250ms ease;     /* changements de layout */
```

**Règle :** ne jamais dépasser 300ms pour une micro-interaction. Serenzer est calme, pas lent.

---

## 6. ICONOGRAPHIE

### Convention SVG (officielle)

Toutes les icônes UI sont des **SVG inline**, jamais des images, jamais des icon fonts.

```html
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
  <!-- paths -->
</svg>
```

### Tailles standardisées

| Contexte | Taille |
|---|---|
| Header buttons | 20px |
| List-item icons | 22px |
| Bottom-nav icons | 24px |
| Bottom-nav center button | 26px (rempli, pas tracé) |
| Suggestion icons | 14px (sur fond accent rempli 22px) |

### Règles

**TOUJOURS :**
- `stroke="currentColor"` pour hériter de la couleur du parent
- `stroke-width="1.5"` (default), `2` uniquement pour mobile-nav, `2.5` uniquement pour icônes blanches sur fond accent
- `fill="none"` pour les icônes tracées
- Coins arrondis (`stroke-linecap="round"`)

**JAMAIS :**
- Couleur en dur dans le SVG
- Stroke épais (3+) qui casse le ton calme
- Icône remplie ET tracée mélangées dans la même surface visuelle
- **Aucun emoji nulle part dans l'interface** — règle absolue de Serenzer

### Sources autorisées

Pas de lib externe imposée. Le projet utilise des SVG custom inspirés de **Heroicons** et **Lucide** (style outline 1.5). Si nouvelle icône nécessaire, suivre exactement ces conventions.

---

## 7. COMPOSANTS

### 7.1 Boutons

```css
.btn {
  display: inline-flex; align-items: center; justify-content: center;
  gap: var(--space-sm);
  padding: var(--space-md) var(--space-xl);   /* 12px 20px */
  font-size: var(--text-base);                 /* 15px */
  font-weight: 500;
  border-radius: var(--radius-lg);             /* 16px */
  transition: all var(--transition-normal);
}

.btn--primary   { background: var(--color-accent); color: white; }
.btn--secondary { background: var(--color-argile-clair); color: var(--color-text-primary); }
.btn--ghost     { background: transparent; color: var(--color-text-secondary); }

.btn--lg   { padding: var(--space-lg) var(--space-2xl); font-size: var(--text-md); }
.btn--sm   { padding: var(--space-sm) var(--space-lg);  font-size: var(--text-sm); }
.btn--full { width: 100%; }

.btn:hover     /* primary→accent-hover, secondary→pierre-pale, ghost→argile-clair */
.btn:disabled  { opacity: 0.5; cursor: not-allowed; }
.btn:active    { transform: scale(0.98); }   /* feedback tactile */
```

**Règles :**
- 1 seul `.btn--primary` visible par écran (focus)
- `.btn--secondary` pour actions équivalentes ou alternatives
- `.btn--ghost` pour actions tertiaires (annuler, en savoir plus)
- Toujours associer un verbe d'action ("Créer", "Continuer"), pas une formulation passive

### 7.2 Cards

```css
.card {
  background: var(--color-surface);            /* #FFFFFF */
  border-radius: var(--radius-lg);             /* 16px */
  padding: var(--space-xl);                    /* 20px */
  box-shadow: var(--shadow-sm);
}

.card--bordered {
  border: 1px solid var(--color-border-light);
  box-shadow: none;                            /* alternative sans ombre */
}

.card__title {
  font-family: var(--font-display);            /* Fraunces */
  font-size: var(--text-md);                   /* 17px */
  font-weight: 500;
}

.card__subtitle {
  font-size: var(--text-sm);
  color: var(--color-text-muted);
}
```

### 7.3 List-item

```css
.list-item {
  display: flex; align-items: center; gap: var(--space-lg);
  padding: var(--space-lg);
  background: var(--color-surface);
  border-radius: var(--radius-md);
  transition: background var(--transition-normal);
}

.list-item:hover { background: var(--color-lin-calme); }

.list-item__icon {
  width: 44px; height: 44px;
  border-radius: var(--radius-md);
  background: var(--color-accent-light);       /* sauge translucide 15% */
  color: var(--color-accent);
}
```

**Pattern :** icône colorée à gauche (44px) + titre/sous-titre + chevron à droite. C'est le pattern de listing standard de toute l'app.

### 7.4 Inputs

```css
.input {
  width: 100%;
  padding: var(--space-lg);                    /* 16px */
  background: var(--color-surface);
  border: 1px solid var(--color-border);
  border-radius: var(--radius-md);             /* 12px */
  color: var(--color-text-primary);
  transition: border-color var(--transition-normal);
}

.input:focus       { border-color: var(--color-accent); }   /* sauge */
.input::placeholder{ color: var(--color-text-muted); }

.input-label {
  font-size: var(--text-sm);
  font-weight: 500;
  color: var(--color-text-secondary);
  margin-bottom: var(--space-sm);
}

.textarea { resize: vertical; min-height: 100px; }
```

**Règle :** pas de border-bottom-only (style Material). Serenzer utilise des inputs encadrés complets avec radius 12px.

### 7.5 Badges

```css
.badge {
  display: inline-flex; align-items: center;
  padding: var(--space-xs) var(--space-md);    /* 4px 12px */
  font-size: var(--text-xs);                   /* 11px */
  font-weight: 500;
  border-radius: var(--radius-full);
  background: var(--color-accent-light);
  color: var(--color-accent);
}

.badge--success { background: rgba(143, 168, 155, 0.15); color: var(--color-success); }
.badge--warning { background: rgba(209, 179, 139, 0.20); color: var(--color-warning); }
.badge--error   { background: rgba(201, 123, 123, 0.15); color: var(--color-error); }
```

**Règle :** un badge dit un statut en 1 ou 2 mots. Jamais une phrase.

### 7.6 Avatars

| Contexte | Taille | Border |
|---|---|---|
| Header | 36px | aucune |
| Message chat | 44px | aucune |
| Mobile menu | 40px | 2px sauge |
| Bouton chat central | 52px | aucune (avec shadow-accent) |

Toujours `border-radius: var(--radius-full)` (cercle parfait).  
Fallback fond : `var(--color-pierre-pale)` ou `var(--color-argile-clair)`.

---

## 8. PATTERNS SIGNATURE

Ces 4 patterns sont **l'ADN visuel de Serenzer**. Ils doivent être préservés et étendus, jamais remplacés par des équivalents génériques.

### 8.1 Le bouton chat central (signature #1)

Bouton circulaire de **52px** au centre de la bottom-nav mobile, qui dépasse de la nav (`margin-top: -16px`). Fond `--color-accent` (sauge), avec **shadow-accent** (l'unique ombre colorée du système). Contient l'icône Serenzer (ou une vague stylisée).

```css
.nav-bottom__center-btn {
  width: 52px; height: 52px;
  border-radius: var(--radius-full);
  background: var(--color-accent);
  box-shadow: var(--shadow-accent);   /* 0 4px 12px rgba(143,168,155,0.35) */
}
.nav-bottom__center-btn:hover  { background: var(--color-accent-hover); transform: scale(1.02); }
.nav-bottom__center-btn:active { transform: scale(0.95); }
```

### 8.2 L'input chat pill (signature #2)

Champ de saisie en forme de pilule (`border-radius: 30px` — exception au token), avec icônes circulaires 36px de chaque côté (mic, send, attach), padding 6px, ombre `md`.

```css
.chat__input-container {
  background: var(--color-surface);
  border-radius: 30px;               /* exception assumée vs --radius-2xl */
  padding: 6px;
  box-shadow: var(--shadow-md);
  border: 1px solid var(--color-border-light);
  display: flex; align-items: center; gap: var(--space-sm);
}
```

### 8.3 Bulles de conversation asymétriques (signature #3)

Les bulles ont un **coin "pointu"** (`radius: 4px`) du côté avatar, créant une "queue" implicite sans triangle CSS.

```css
.message__bubble       { padding: 16px 20px; border-radius: var(--radius-xl); /* 20px */ }
.message--ai .message__bubble   { background: var(--color-surface); border: 1px solid var(--color-border-light); border-top-left-radius: var(--space-xs); /* 4px */ }
.message--user .message__bubble { background: var(--color-argile-clair); border-top-right-radius: var(--space-xs); /* 4px */ }
```

### 8.4 Bulle de suggestion contextuelle (signature #4)

Petite zone d'incitation discrète, fond `--color-lin-calme`, icône carrée sauge 22px avec coche blanche stroke 2.5, texte à droite.

```css
.message__suggestion {
  display: flex; align-items: flex-start; gap: var(--space-md);
  padding: var(--space-lg);
  background: var(--color-lin-calme);
  border-radius: var(--radius-lg);
}
.message__suggestion-icon {
  width: 22px; height: 22px;
  border-radius: var(--radius-sm);
  background: var(--color-accent);
  color: white;
}
```

---

## 9. ANIMATIONS STANDARDISÉES

```css
@keyframes messageIn {
  from { opacity: 0; transform: translateY(8px); }
  to   { opacity: 1; transform: translateY(0); }
}
/* usage : .message { animation: messageIn 0.3s ease; } */

@keyframes typingPulse {
  0%, 60%, 100% { opacity: 0.4; transform: scale(1); }
  30%           { opacity: 1;   transform: scale(1.1); }
}
/* usage : .message__typing-dot, durée 1.4s infinite, delays 0/0.2/0.4s */

@keyframes recordingPulse {
  0%, 100% { opacity: 1; }
  50%      { opacity: 0.5; }
}
/* usage : .chat__input-icon--recording, 1s infinite */
```

**Règles :**
- Toute apparition d'élément UI utilise `messageIn` ou variante (translateY 8px max, 0.3s max)
- Aucune animation continue ne dépasse 1.5s par cycle
- Pas de bounce, pas d'overshoot, pas de cubic-bezier exotique : `ease` standard suffit
- `prefers-reduced-motion`: respecter et désactiver les animations non-essentielles

---

## 10. VOIX & TON

### Style rédactionnel

| Caractéristique | Application |
|---|---|
| **Calme** | Phrases courtes, pas d'exclamation, pas d'urgence |
| **Clair** | Vocabulaire simple, pas de jargon, vouvoiement par défaut |
| **Premium** | Pas de familiarité forcée, pas d'humour potache |
| **Non-directif** | "Vous pouvez…", "Souhaitez-vous…", jamais "Vous devez…" |
| **Respectueux** | L'utilisateur valide toujours les actions proposées |

### Vocabulaire

**TOUJOURS préférer :**
- "organiser" plutôt que "transformer"
- "structurer" plutôt que "optimiser"
- "préparer" plutôt que "anticiper"
- "noter" plutôt que "enregistrer"
- "espace" plutôt que "plateforme"
- "assistant" plutôt que "coach" (positionnement public fonctionnel)

**JAMAIS utiliser** (positionnement public — landing, ads, store) :
- coach de vie / life coach
- santé mentale / mental health
- émotions, humeur, détresse
- bien-être, soutien moral
- transformation, changement durable
- "il vous connaît vraiment", "compagnon qui vous comprend"

> Note interne : le vocabulaire de coaching reste utilisé **dans les system prompts internes** pour la qualité de l'IA. Il est interdit en surface UI publique.

### Microcopie

| Action | À faire | À éviter |
|---|---|---|
| CTA principal | "Continuer", "Créer", "Enregistrer" | "Go !", "C'est parti !" |
| Confirmation | "C'est fait." | "Bravo !!! 🎉" |
| Erreur | "Quelque chose n'a pas fonctionné. Réessayer ?" | "Oups ! Erreur." |
| Vide | "Rien à afficher pour le moment." | "Vide… Ajoute du contenu !" |

---

## 11. APPLICATION PAR CONTEXTE

### Web app (apps.serenzer.com) — production

Charte officielle décrite ci-dessus. Mobile-first 480px, sidebar desktop 240px, fond `lin-calme`.

### Landing page (pré-Meta, public)

Même charte + **vocabulaire fonctionnel strict** (cf §10). Hero plus aéré (`space-5xl` minimum entre sections).

### Email transactionnel

⚠️ **Charte legacy** différente actuellement (teal `#32717b`, Poppins). À migrer progressivement vers la charte officielle. En attendant, ne pas réutiliser le `#32717b` ailleurs.

### Réseaux sociaux

Visuels carrés ou 4:5. Fond `lin-calme` ou `surface` blanc, accents sauge mesurés. Wordmark Fraunces. **Pas de filtre, pas d'effet, pas d'emoji.**

### Print

Mêmes couleurs (versions CMYK à dériver). Marges minimum 16mm. Logo minimum 12mm.

---

## 12. CHECKLIST DE CONTRÔLE QUALITÉ

Avant de livrer une interface, vérifier :

- [ ] Toutes les couleurs passent par `var(--color-*)`
- [ ] Aucune couleur hex en dur dans le CSS (sauf si justifiée et documentée)
- [ ] Fraunces uniquement sur titres ; Inter pour le reste
- [ ] Aucun emoji dans l'interface (texte, boutons, états)
- [ ] Tous les SVG sont inline, `stroke="currentColor"`, `stroke-width="1.5"`
- [ ] Espacements alignés sur la grille 4px (multiples de `--space-*`)
- [ ] `border-radius` toujours via `--radius-*` (sauf 30px du chat input)
- [ ] Animations ≤ 300ms, courbe `ease`
- [ ] `prefers-reduced-motion` pris en compte
- [ ] Mobile-first : tester d'abord à 360px de large
- [ ] Contraste WCAG AA minimum partout
- [ ] Vocabulaire conforme au §10 (en interface publique)
- [ ] RTL pris en compte (langues arabe, hébreu)

---

## ANNEXE — Prompt court pour Claude design

> **Tu produis une interface Serenzer. Applique strictement le brandbook v1 :**
> - Palette : 8 couleurs nommées (lin-calme, sauge-douce, encre-douce, argile-clair, pierre-pale, mousse-legere, sable-chaud, cendre-tiede). Toujours via `var(--color-*)`.
> - Typo : Fraunces (titres uniquement) + Inter (body). Poids 400/500/600 max.
> - Tokens : `--space-*` (4px base), `--radius-*` (16px par défaut), `--shadow-*` (sm/md/lg/xl/accent).
> - Composants : `.btn--primary/secondary/ghost`, `.card[--bordered]`, `.list-item`, `.input`, `.badge--success/warning/error`.
> - SVG inline, `stroke="currentColor"`, `stroke-width="1.5"`, `fill="none"`. Pas d'emoji.
> - Mobile-first 480px. Animations ≤ 300ms ease.
> - Ton : calme, clair, premium, non-directif. Vocabulaire fonctionnel strict en surface publique.

---

**Fin du document.**  
Pour toute évolution, mettre à jour `serenzer.css` puis régénérer ce brandbook.
