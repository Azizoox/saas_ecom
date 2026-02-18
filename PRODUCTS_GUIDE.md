# Guide de gestion des produits

## Fonctionnalités implémentées

### ✅ Gestion des produits dans le Dashboard

1. **Liste des produits** (`/products`)
   - Affichage de tous les produits de toutes vos boutiques
   - Informations : nom, boutique, prix, stock, statut
   - Actions : modifier, supprimer

2. **Ajouter un produit** (`/products/create`)
   - Formulaire complet avec :
     - Sélection de la boutique
     - Nom du produit
     - Description
     - Prix (TND)
     - Stock
     - SKU (optionnel)
     - Statut actif/inactif

3. **Modifier un produit** (`/products/{id}/edit`)
   - Modification de tous les champs du produit

4. **Supprimer un produit**
   - Suppression avec confirmation

### ✅ Affichage des produits dans la boutique

- Les produits sont automatiquement affichés sur la page **"Boutique"** de chaque boutique
- Seuls les produits **actifs** sont affichés
- Affichage en grille avec :
  - Image (ou placeholder si pas d'image)
  - Nom
  - Description (tronquée à 100 caractères)
  - Prix formaté en TND
  - Statut du stock

## Structure de la base de données

### Table `products`
- `id` - Identifiant unique
- `shop_id` - ID de la boutique (foreign key)
- `name` - Nom du produit
- `description` - Description du produit
- `price` - Prix (decimal 10,2)
- `image` - Chemin de l'image (nullable)
- `stock` - Quantité en stock
- `is_active` - Produit actif/inactif
- `sku` - Code produit (nullable)
- `created_at`, `updated_at` - Timestamps

## Utilisation

### Pour ajouter un produit :

1. Se connecter au dashboard : `http://localhost:8000/dashboard`
2. Cliquer sur "Produits" dans le menu
3. Cliquer sur "Ajouter un produit"
4. Remplir le formulaire :
   - Sélectionner la boutique
   - Nom du produit (obligatoire)
   - Description (optionnel)
   - Prix en TND (obligatoire)
   - Stock (obligatoire, minimum 0)
   - SKU (optionnel)
   - Cocher "Produit actif" pour qu'il soit visible
5. Cliquer sur "Créer le produit"

### Pour voir les produits dans la boutique :

1. Accéder à votre boutique : `http://localhost:8000/shop/{subdomain}`
2. Cliquer sur "Boutique" dans le menu
3. Les produits actifs s'affichent automatiquement

## Routes disponibles

- `GET /products` - Liste des produits (authentifié)
- `GET /products/create` - Formulaire d'ajout (authentifié)
- `POST /products` - Créer un produit (authentifié)
- `GET /products/{id}/edit` - Formulaire de modification (authentifié)
- `PUT /products/{id}` - Mettre à jour un produit (authentifié)
- `DELETE /products/{id}` - Supprimer un produit (authentifié)

## Sécurité

- Seuls les propriétaires de boutiques peuvent gérer leurs produits
- Vérification que l'utilisateur possède la boutique avant modification/suppression
- Les produits inactifs ne sont pas affichés dans la boutique publique

## Prochaines étapes suggérées

- [ ] Upload d'images pour les produits
- [ ] Catégories de produits
- [ ] Recherche et filtres
- [ ] Page détail d'un produit
- [ ] Panier d'achat
- [ ] Gestion des commandes
