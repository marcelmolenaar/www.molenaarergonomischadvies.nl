# www.molenaarergonomischadvies.nl

WordPress-site met custom theme voor Molenaar Ergonomisch Advies.

## Stack

- WordPress (laatste) op PHP 8.3 + Apache
- MariaDB 11
- phpMyAdmin (handig tijdens ontwikkeling)
- Docker Compose

## Eerste keer opstarten

```bash
cp .env.example .env
# pas wachtwoorden aan in .env
docker compose up -d
```

Vervolgens in de browser:

- Site / WP install: <http://localhost:8181>
- phpMyAdmin: <http://localhost:8182>

Tijdens de WordPress-installatiewizard kies je het theme **Molenaar Ergonomisch Advies** in *Weergave → Thema's*.

## Structuur

```
.
├── docker-compose.yml
├── .env.example          # voorbeeld credentials, kopieer naar .env
├── theme/                # custom theme — onder versiebeheer
│   ├── style.css
│   ├── functions.php
│   ├── index.php
│   ├── header.php
│   └── footer.php
└── uploads/              # WP uploads (niet versiebeheerd)
```

WordPress-core en de database draaien in Docker-volumes (`wp_core`, `db_data`) — die staan niet in git. Alleen het theme is versiebeheerd.

## Stoppen / opruimen

```bash
docker compose down              # containers stoppen
docker compose down -v           # ook volumes (DB + WP-core) wissen — fresh install
```

## Theme ontwikkelen

Wijzigingen in `theme/` zijn direct zichtbaar in de container (bind-mount). Geen rebuild nodig.
