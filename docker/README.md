# Run the project with Docker

Install Docker Desktop and start it. Run these commands from the project root.

## First-time setup

For a fresh local installation (do not run the initialization commands on an existing database):

```powershell
docker compose -f docker/compose.yaml build
docker compose -f docker/compose.yaml run --rm app composer install
docker compose -f docker/compose.yaml run --rm app sh -c "cp -n .env.example .env && touch database/database.sqlite"
docker compose -f docker/compose.yaml run --rm app php artisan key:generate
docker compose -f docker/compose.yaml run --rm app php artisan migrate --seed
docker compose -f docker/compose.yaml run --rm node npm ci
docker compose -f docker/compose.yaml run --rm node npm run build
```

The demo login is `dono@arizonapetcare.test` with password `senha12345`.

## Start and stop

```powershell
docker compose -f docker/compose.yaml up -d app
docker compose -f docker/compose.yaml down
```

Open <http://localhost:8000>. The SQLite database remains in `database/database.sqlite`. Rebuild frontend assets after changing CSS or JavaScript with the final command from the setup section.
