# Configuration pour Localhost

Le système a été adapté pour fonctionner en localhost au lieu de sous-domaines.

## Structure des URLs

### Application principale
- `http://localhost:8000/` - Redirige vers login
- `http://localhost:8000/register` - Inscription
- `http://localhost:8000/login` - Connexion
- `http://localhost:8000/dashboard` - Dashboard (authentifié)

### Boutiques
- `http://localhost:8000/shop/{subdomain}` - Page d'accueil de la boutique
- `http://localhost:8000/shop/{subdomain}/{slug}` - Pages de la boutique

Exemple :
- `http://localhost:8000/shop/mon-boutique` - Accueil
- `http://localhost:8000/shop/mon-boutique/accueil` - Page Accueil
- `http://localhost:8000/shop/mon-boutique/contact` - Page Contact

## Démarrage

1. Installer les dépendances (si pas déjà fait) :
```bash
composer install
```

2. Configurer la base de données dans `.env` :
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=shoopino
DB_USERNAME=root
DB_PASSWORD=
```

3. Créer la base de données :
```sql
CREATE DATABASE shoopino CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

4. Exécuter les migrations :
```bash
php artisan migrate
```

5. Démarrer le serveur :
```bash
php artisan serve
```

Le site sera accessible sur `http://localhost:8000`

## Test

1. Accéder à `http://localhost:8000/register`
2. Créer un compte avec un sous-domaine (ex: `mon-boutique`)
3. Après inscription, vous serez redirigé vers `http://localhost:8000/shop/mon-boutique`
4. Accéder au dashboard via `http://localhost:8000/dashboard`

## Notes

- Les sous-domaines sont maintenant utilisés comme identifiants dans l'URL
- Plus besoin de configurer les sous-domaines dans le fichier hosts
- Fonctionne directement avec `php artisan serve`
