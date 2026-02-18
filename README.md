# Shoopino - Plateforme E-commerce Multi-Tenant

Plateforme e-commerce multi-tenant avec Laravel 12 permettant la création automatique de boutiques en ligne.

## Fonctionnalités

- ✅ Authentification complète (Login & Register)
- ✅ Création automatique de boutique après inscription
- ✅ Multi-tenant par sous-domaine
- ✅ Génération automatique des pages par défaut
- ✅ Dashboard propriétaire de boutique
- ✅ Configuration automatique des paramètres

## Installation

1. Installer les dépendances :
```bash
composer install
```

2. Copier le fichier `.env.example` vers `.env` :
```bash
copy .env.example .env
```

3. Générer la clé d'application :
```bash
php artisan key:generate
```

4. Configurer la base de données dans `.env` :
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=shoopino
DB_USERNAME=root
DB_PASSWORD=
```

5. Exécuter les migrations :
```bash
php artisan migrate
```

## Configuration des sous-domaines

Pour le développement local, ajoutez dans votre fichier `hosts` (C:\Windows\System32\drivers\etc\hosts) :

```
127.0.0.1 app.shopino.test
127.0.0.1 *.shopino.test
```

Et configurez votre serveur web (Apache/Nginx) pour accepter les sous-domaines wildcard.

## Utilisation

1. Accéder à `http://app.shopino.test/register` pour créer un compte
2. Après inscription, vous serez redirigé vers votre boutique : `http://{subdomain}.shopino.test`
3. Accéder au dashboard : `http://app.shopino.test/dashboard`

## Structure

- `app/Models/` - Modèles Eloquent
- `app/Http/Controllers/` - Contrôleurs
- `app/Http/Middleware/` - Middleware multi-tenant
- `database/migrations/` - Migrations de base de données
- `resources/views/` - Vues Blade
