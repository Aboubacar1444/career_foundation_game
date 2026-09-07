# Technical Architecture

## Cible
Mobile-first, monde persistant, backend capable de simuler des événements même lorsque le joueur est absent.

## Stack de travail proposée
- Client : Unity pour le jeu principal ;
- Backend : Symfony ;
- Base : PostgreSQL ;
- Queue/cache : Redis + Symfony Messenger ;
- Services IA : Python/FastAPI ;
- fichiers/assets : stockage objet ;
- CI/CD : GitHub Actions ou équivalent.

## Séparation
Client : présentation et interactions.
Backend : état durable et règles critiques.
Workers : simulation de temps, charts, streams, événements.
IA : narration et génération contrôlée.
