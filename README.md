# www.molenaarergonomischadvies.nl

WordPress-site met custom theme voor Molenaar Ergonomisch Advies.

## Stack

- WordPress op PHP 8.3 + Apache
- MariaDB 11
- phpMyAdmin (dev)
- Docker Compose

## Eerste keer opstarten (lokale dev)

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
   - CPT "Nieuws" met 2 voorbeeldartikelen
   - Hoofdmenu met de items, gekoppeld aan de "primary"-locatie
   - Front page → *Home*
   - Pretty permalinks (`/diensten/`, `/nieuws/{slug}/` etc.)

Wil Ellen een tekst aanpassen? Inloggen op `/wp-admin/`, *Pagina's* → bewerken. Nieuwsberichten via *Nieuws → Nieuw bericht*.

## Structuur

De repo-structuur **spiegelt de WordPress-structuur**, zodat de productieserver simpelweg een `git checkout` van deze repo is — `git pull` ververst dan automatisch de theme-bestanden.

```
.
├── docker-compose.yml
├── .env.example
├── content/                                 # bron-teksten in markdown (referentie)
│   ├── over.md
│   ├── diensten.md
│   ├── contact.md
│   ├── nieuws-beweegcultuur.md
│   └── nieuws-zitten-roken.md
├── wp-content/
│   └── themes/
│       └── molenaar/                        # custom theme — versionbeheerd
│           ├── style.css                    # mobile-first CSS
│           ├── theme.json                   # block editor color palette
│           ├── functions.php                # theme setup + auto-seed + CPT Nieuws
│           ├── header.php / footer.php
│           ├── front-page.php               # homepage met hero + dienst-tegels
│           ├── page.php                     # generieke fallback
│           ├── page-{diensten,over,contact}.php
│           ├── archive-nieuws.php           # nieuws-archief
│           ├── single-nieuws.php            # individueel nieuwsbericht
│           ├── index.php                    # 404-fallback
│           ├── inc/
│           │   ├── seed.php                 # content voor de pages
│           │   ├── seed-posts.php           # content voor de nieuwsberichten
│           │   ├── services.php             # diensten-array voor homepage
│           │   └── icons.php                # Lucide-stijl icons
│           ├── assets/images/
│           │   ├── logo.svg
│           │   ├── logo-mark.svg            # favicon
│           │   └── ellen.jpg                # portretfoto
│           └── tools/
│               ├── run-seed.php             # CLI: handmatig de seed draaien
│               └── verify.php               # CLI: DB-state check
└── uploads/                                 # WP uploads (gitignored, lokale dev)
```

WordPress-core en de database draaien in Docker-volumes (`wp_core`, `db_data`). Alleen `wp-content/themes/molenaar/` en `content/` staan onder versiebeheer.

## Productie-deploy (Ubuntu VPS)

Op de VPS is `public_html` een directe git-checkout van deze repo. WP core staat in `.gitignore` zodat `git pull` alleen de theme-bestanden ververst.

**Eenmalige setup** (in `/var/www/molenaarergonomischadvies.nl/public_html`):

```bash
cd /var/www/molenaarergonomischadvies.nl/public_html
sudo git init -b master
sudo git remote add origin https://github.com/marcelmolenaar/www.molenaarergonomischadvies.nl.git
sudo git fetch origin
sudo git checkout -f master
sudo chown -R www-data:www-data wp-content/themes/molenaar
```

**Toekomstige updates** — na `git push` lokaal:

```bash
ssh transip
cd /var/www/molenaarergonomischadvies.nl/public_html
sudo git pull
```

Direct live, geen verdere actie nodig.

## Theme aanpassen

| Wat | Waar |
|-----|------|
| Kleuren | CSS custom properties bovenaan `wp-content/themes/molenaar/style.css` |
| Diensten op homepage | `wp-content/themes/molenaar/inc/services.php` |
| Pages-content | WP-admin → Pagina's |
| Nieuwsberichten | WP-admin → Nieuws → Nieuw bericht |
| Menu-items | WP-admin → Weergave → Menu's |
| Logo | `wp-content/themes/molenaar/assets/images/logo.svg` |
| Contactgegevens | `MOLENAAR_CONTACT`-constante in `wp-content/themes/molenaar/functions.php` |

Wijzigingen in `wp-content/themes/molenaar/` zijn direct zichtbaar (bind-mount, geen rebuild). Op productie: na `git pull` direct live.

## Stoppen / opruimen (lokaal)

```bash
docker compose down              # containers stoppen
docker compose down -v           # ook volumes (DB + WP-core) wissen — fresh install
```
