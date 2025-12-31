# Rock AG Crew-Management

## Setup

### Lokales Setup:
1. `.env`-Datei erstellen: `cp .env.example .env`

2. Ggf. Werte in `.env` anpassen. User ID und Group ID können mit `id -u` bzw. `id -g` herausgefunden werden.

3. Services starten: 
    ```
    docker compose -f compose.dev.yaml up -d
    ```
4. Dependencies installieren und Vite starten:
    ```
    docker compose -f compose.dev.yaml exec workspace bash
    composer install
    npm install
    npm run dev
    ```
5. DB-Migrations installieren
    ```
    docker compose -f compose.dev.yaml exec workspace php artisan migrate
    ```
6. Die App sollte jetzt unter [http://localhost](http://localhost) erreichbar sein

## Wichtige Befehle

### In den Workspace-Container wechseln

In diesem Container laufen Compose, Node, NPM, etc. Alle Artisan-Befehle müssen in diesem Container ausgeführt werden.

```
docker compose -f compose.dev.yaml exec workspace bash
```

## Credits

Based on [https://github.com/dockersamples/laravel-docker-examples](https://github.com/dockersamples/laravel-docker-examples)