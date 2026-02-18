# Guide d'installation - Shoopino

## Prérequis

- PHP 8.2 ou supérieur
- Composer
- MySQL
- Serveur web (Apache/Nginx) ou PHP built-in server

## Étapes d'installation

### 1. Installer les dépendances

```bash
composer install
```

### 2. Configuration de l'environnement

Copier le fichier `.env.example` vers `.env` :

```bash
copy .env.example .env
```

### 3. Générer la clé d'application

```bash
php artisan key:generate
```

### 4. Configurer la base de données

Éditer le fichier `.env` et configurer :

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=shoopino
DB_USERNAME=root
DB_PASSWORD=votre_mot_de_passe
```

Créer la base de données :

```sql
CREATE DATABASE shoopino CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 5. Exécuter les migrations

```bash
php artisan migrate
```

### 6. Configuration des sous-domaines (Windows)

#### Option A : Utiliser Laravel Valet (recommandé)

Si vous utilisez Laravel Valet, les sous-domaines wildcard fonctionnent automatiquement.

#### Option B : Configuration manuelle

1. Éditer le fichier `C:\Windows\System32\drivers\etc\hosts` (en tant qu'administrateur) :

```
127.0.0.1 app.shopino.test
127.0.0.1 *.shopino.test
```

2. Pour Apache, configurer un VirtualHost avec ServerAlias :

```apache
<VirtualHost *:80>
    ServerName shopino.test
    ServerAlias *.shopino.test
    DocumentRoot "C:/Users/ahach/OneDrive/Bureau/shoopino/public"
    <Directory "C:/Users/ahach/OneDrive/Bureau/shoopino/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

3. Pour Nginx :

```nginx
server {
    listen 80;
    server_name shopino.test *.shopino.test;
    root C:/Users/ahach/OneDrive/Bureau/shoopino/public;
    
    index index.php;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

### 7. Démarrer le serveur de développement

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

Ou avec un serveur web configuré, accéder directement à :
- `http://app.shopino.test` pour l'application principale
- `http://{subdomain}.shopino.test` pour les boutiques

## Test de l'application

1. Accéder à `http://app.shopino.test/register`
2. Remplir le formulaire d'inscription
3. Après inscription, vous serez redirigé vers votre boutique
4. Accéder au dashboard via `http://app.shopino.test/dashboard`

## Structure des URLs

- **Application principale** : `http://app.shopino.test`
  - `/register` - Inscription
  - `/login` - Connexion
  - `/dashboard` - Dashboard propriétaire

- **Boutiques** : `http://{subdomain}.shopino.test`
  - `/` - Page d'accueil de la boutique
  - `/{slug}` - Pages de la boutique (accueil, boutique, à propos, contact, etc.)

## Notes importantes

- Les sous-domaines doivent être uniques
- Après inscription, la boutique est immédiatement accessible
- Les pages par défaut sont créées automatiquement
- Le thème et les paramètres sont configurés par défaut
