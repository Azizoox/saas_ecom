# 🚀 Démarrage Rapide - Shoopino Localhost

## Installation rapide

### 1. Installer les dépendances
```bash
composer install
```

### 2. Configurer l'environnement
Le fichier `.env` est déjà configuré pour localhost. Vérifiez juste la base de données :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=shoopino
DB_USERNAME=root
DB_PASSWORD=votre_mot_de_passe
```

### 3. Créer la base de données
```sql
CREATE DATABASE shoopino CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 4. Exécuter les migrations
```bash
php artisan migrate
```

### 5. Démarrer le serveur
```bash
php artisan serve
```

## Accès au site

- **Inscription** : http://localhost:8000/register
- **Connexion** : http://localhost:8000/login
- **Dashboard** : http://localhost:8000/dashboard
- **Boutique** : http://localhost:8000/shop/{subdomain}

## Exemple d'utilisation

1. Aller sur http://localhost:8000/register
2. Remplir le formulaire avec :
   - Prénom : John
   - Nom : Doe
   - Email : john@example.com
   - Téléphone : +21612345678
   - Nom boutique : Ma Boutique
   - Sous-domaine : ma-boutique
   - Mot de passe : password123
3. Après inscription → Redirection vers http://localhost:8000/shop/ma-boutique
4. Accéder au dashboard → http://localhost:8000/dashboard

## Structure des URLs

### Application
- `/` → Redirige vers login
- `/register` → Inscription
- `/login` → Connexion
- `/dashboard` → Dashboard (nécessite authentification)

### Boutiques
- `/shop/{subdomain}` → Page d'accueil de la boutique
- `/shop/{subdomain}/{slug}` → Pages de la boutique

Exemples :
- `/shop/ma-boutique` → Accueil
- `/shop/ma-boutique/accueil` → Page Accueil
- `/shop/ma-boutique/contact` → Page Contact
- `/shop/ma-boutique/boutique` → Page Boutique

## ✅ Tout est prêt !

Le système fonctionne maintenant en localhost sans configuration de sous-domaines.
