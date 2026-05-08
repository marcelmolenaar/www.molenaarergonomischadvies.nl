# www.molenaarergonomischadvies.nl

WordPress-site met custom theme voor Molenaar Ergonomisch Advies.

## Stack

- WordPress op PHP 8.3 + Apache
- MariaDB 11
- phpMyAdmin (dev)
- Docker Compose

## Eerste keer opstarten

```bash
cp .env.example .env       # pas wachtwoorden aan in .env
docker compose up -d
```

Vervolgens in de browser:

- **Site / WP install:** <http://localhost:8181>
- **phpMyAdmin:** <http://localhost:8182>

### WordPress-setup (eenmalig, ~2 min)

1. Doorloop de WP install-wizard (taal, sitenaam, admin-account).
2. Ga naar *Weergave → Thema's* en activeer **Molenaar Ergonomisch Advies**.
3. **Klaar.** De theme-activatie maakt automatisch het volgende aan:
   - 4 pages: *Home*, *Diensten*, *Over*, *Contact* — met de teksten van Ellen
   - Hoofdmenu met deze 4 items, gekoppeld aan de "primary"-locatie
   - Front page → *Home*
   - Pretty permalinks (`/diensten/` etc.)

Wil Ellen een tekst aanpassen? Inloggen op `/wp-admin/`, *Pagina's* → bewerken.

## Structuur

```
.
├── docker-compose.yml
├── .env.example
├── content/                 # bron-teksten in markdown (referentie)
│   ├── over.md
│   ├── diensten.md
│   └── contact.md
├── theme/                   # custom theme — versionbeheerd
│   ├── style.css            # mobile-first CSS, ~150 regels
│   ├── theme.json           # block editor color palette
│   ├── functions.php        # theme setup + auto-seed van pages/menu
│   ├── header.php / footer.php
│   ├── front-page.php       # homepage met hero + dienst-tegels + over-teaser
│   ├── page.php             # generieke fallback
│   ├── page-diensten.php    # 9 diensten met sticky inhoudsopgave
│   ├── page-over.php        # 2-koloms layout met portretfoto
│   ├── page-contact.php     # contactgegevens-kaart
│   ├── index.php            # 404-fallback
│   ├── inc/
│   │   ├── seed.php         # content voor de 4 pages (eenmalig bij activatie)
│   │   └── services.php     # diensten-array voor homepage-tegels
│   └── assets/images/
│       ├── logo.svg         # full logo (cirkel + woordmerk)
│       ├── logo-mark.svg    # alleen M-cirkel (favicon, klein gebruik)
│       └── ellen.jpg        # portretfoto
└── uploads/                 # WP uploads (niet versiebeheerd)
```

WordPress-core en de database draaien in Docker-volumes (`wp_core`, `db_data`). Alleen `theme/` en `content/` staan onder versiebeheer.

## Theme aanpassen

| Wat | Waar |
|-----|------|
| Kleuren | CSS custom properties bovenaan `theme/style.css` (`--c-purple`, `--c-magenta`, …) |
| Diensten op homepage | `theme/inc/services.php` (titel + 1-regel teaser per dienst) |
| Pages-content | WP-admin (Pagina's) — of voor een fresh install: `theme/inc/seed.php` |
| Menu-items | WP-admin (*Weergave → Menu's*) |
| Logo | `theme/assets/images/logo.svg` (`logo-mark.svg` voor de favicon) |
| Contactgegevens | `MOLENAAR_CONTACT`-constante in `theme/functions.php` |

Wijzigingen in `theme/` zijn direct zichtbaar (bind-mount, geen rebuild).

## Stoppen / opruimen

```bash
docker compose down              # containers stoppen
docker compose down -v           # ook volumes (DB + WP-core) wissen — fresh install
```

Een fresh install doorloopt de WP-installer opnieuw. Theme-activatie seedt opnieuw de pages.
