# 🚀 GUIDE DE DÉMARRAGE - Système d'Authentification Shop

## 📍 URLs d'Accès

### Format Prefix (localhost)

```
🌐 Bienvenue:      http://localhost/shop/soukii
🔐 Login:          http://localhost/shop/soukii/login
📝 Register:       http://localhost/shop/soukii/register
🚪 Logout:         http://localhost/shop/soukii/logout (POST)
```

### Format Subdomain (recommandé)

```
🌐 Bienvenue:      http://soukii.shoopino.test
🔐 Login:          http://soukii.shoopino.test/login
📝 Register:       http://soukii.shoopino.test/register
🚪 Logout:         http://soukii.shoopino.test/logout (POST)
```

**Note**: Remplacez `soukii` par le subdomain réel de votre shop.

---

## 🧪 Scénario de Test Complet

### 1️⃣ TEST: Visiteur Accède à la Shop

```bash
# Ouvrir un navigateur et accéder à:
http://localhost/shop/soukii
```

**Résultat Attendu:**

- ✅ Page de bienvenue affichée
- ✅ Gradient bleu-violet visible
- ✅ 6 cartes d'avantages visibles
- ✅ 5 étapes du guide visibles
- ✅ Boutons "Créer un Compte" et "Se Connecter" visibles
- ✅ Navbar avec "Login" et "Register" boutons
- ✅ Pas de produits affichés

---

### 2️⃣ TEST: Créer un Compte

```bash
# Cliquer sur "Créer un Compte"
http://localhost/shop/soukii/register
```

**Formulaire à Remplir:**

```
First Name:     Jean
Last Name:      Dupont
Email:          jean.dupont@example.com
Phone:          +33612345678
Password:       Test123456!
Confirm Pwd:    Test123456!
Terms:          ✅ Accepter
```

**Résultat Attendu:**

- ✅ Formulaire affichéé avec tous les champs
- ✅ Validation côté client au focus/blur
- ✅ Bordereau de couleur change au focus (bordure bleue)
- ✅ Box shadow subtil au focus

**Après Soumission:**

- ✅ Utilisateur créé dans la DB
- ✅ email_verified_at = maintenant
- ✅ role = "customer"
- ✅ Utilisateur auto-loggé
- ✅ Redirection vers /shop/soukii
- ✅ Navbar change: affiche prénom + dropdown

---

### 3️⃣ TEST: Navbar Authentifiée

**Après Connexion:**

```
Navbar affiche:
├─ Logo du shop (ou avatar)
├─ Icône panier avec badge (0)
└─ Bouton avec initiales "JD" (Jean Dupont)
```

**Cliquer sur le Bouton Utilisateur:**

```
Dropdown affiche:
├─ Profil (futur - actuellement grisé)
├─ Commandes (futur - actuellement grisé)
└─ Se Déconnecter (actif)
```

**Résultat Attendu:**

- ✅ Dropdown s'ouvre au clic (Alpine.js)
- ✅ Ferme au clic elsewhere
- ✅ Options visibles et lisibles

---

### 4️⃣ TEST: Voir les Produits

**Après Connexion, Vous Voyez:**

```
- Section "Nos Produits"
- Grille de produits
- Chatbot en bas à droite
- Chaque produit a un bouton "Ajouter au Panier"
```

**Cliquer sur "Ajouter au Panier":**

- ✅ Badge panier se met à jour (+1)
- ✅ Toast "Produit ajouté" apparaît (si configuré)

---

### 5️⃣ TEST: Se Déconnecter

**Cliquer sur "Se Déconnecter":**

```
Navbar → Dropdown → Se Déconnecter
```

**Résultat Attendu:**

- ✅ POST request vers /shop/soukii/logout
- ✅ Session destroyed
- ✅ Cookies cleared
- ✅ Redirection vers /shop/soukii
- ✅ Welcome page affichée
- ✅ Navbar revient à l'état "guest"

---

### 6️⃣ TEST: Login avec Compte Existant

```bash
# Accéder au formulaire login
http://localhost/shop/soukii/login
```

**Formulaire:**

```
Email:      jean.dupont@example.com
Password:   Test123456!
Remember:   ✅ (optionnel)
```

**Résultat Attendu:**

- ✅ Connecté avec succès
- ✅ Session créée
- ✅ Redirection vers /shop/soukii
- ✅ Produits affichés
- ✅ Navbar affiche l'utilisateur

---

## ❌ Tests d'Erreur

### Erreur 1: Email Invalide

```
Formulaire Login:
Email:    invalid-email
Password: Test123456!
```

**Résultat Attendu:**

- ❌ Message d'erreur: "L'adresse e-mail est invalide"
- 🔴 Champ email surligné en rouge
- ❌ Pas de création de compte

---

### Erreur 2: Email Déjà Utilisé

```
Formulaire Register:
First Name:     Marc
Last Name:      Durand
Email:          jean.dupont@example.com (déjà utilisé!)
Phone:          +33612345679
Password:       Test123456!
Confirm:        Test123456!
```

**Résultat Attendu:**

- ❌ Message d'erreur: "Cet email est déjà utilisé"
- 🔴 Champ email surligné en rouge
- ❌ Pas de création de compte

---

### Erreur 3: Password Trop Court

```
Formulaire Register:
Password:       Test123  (7 chars - min 8)
```

**Résultat Attendu:**

- ❌ Message d'erreur: "Le mot de passe doit contenir au minimum 8 caractères"
- 🔴 Champ password surligné en rouge

---

### Erreur 4: Password Mismatch

```
Formulaire Register:
Password:       Test123456!
Confirm:        Test123456  (différent!)
```

**Résultat Attendu:**

- ❌ Message d'erreur: "Les mots de passe ne correspondent pas"
- 🔴 Champ confirmation surligné en rouge

---

### Erreur 5: Terms Non Acceptées

```
Formulaire Register:
Terms:          ☐ (pas coché)
```

**Résultat Attendu:**

- ❌ Message d'erreur: "Vous devez accepter les conditions"
- ❌ Compte non créé

---

### Erreur 6: Credentials Incorrects

```
Formulaire Login:
Email:      jean.dupont@example.com
Password:   WrongPassword123!
```

**Résultat Attendu:**

- ❌ Message d'erreur: "Email ou mot de passe incorrect"
- 🔴 Formulaire reste affiché
- ❌ Pas de connexion

---

## 🔧 Commandes Utiles

### Tester les Routes

```bash
# Afficher toutes les routes du shop
php artisan route:list | grep shop

# Résultat attendu:
# GET|HEAD    shop/{subdomain}/login
# POST        shop/{subdomain}/login
# GET|HEAD    shop/{subdomain}/register
# POST        shop/{subdomain}/register
# POST        shop/{subdomain}/logout
# (+ variantes subdomain)
```

### Tester la Base de Données

```bash
# Accéder à tinker
php artisan tinker

# Compter les utilisateurs clients
> User::where('role', 'customer')->count()

# Voir un utilisateur
> User::where('email', 'jean.dupont@example.com')->first()

# Vérifier email_verified_at
> User::where('email', 'jean.dupont@example.com')->value('email_verified_at')
# Résultat attendu: date/heure actuelle (NON NULL)
```

### Nettoyer les Caches

```bash
# Nettoyer tous les caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Ou tout à la fois
php artisan cache:clear && php artisan config:clear && php artisan route:clear
```

---

## 📋 Checklist de Vérification

### Visuel & Design

- [ ] Gradient bleu-violet appliqué correctement
- [ ] Boutons avec hover effects (translateY -3px)
- [ ] Champs input avec focus states
- [ ] Texte lisible (contraste suffisant)
- [ ] Design responsive (tester sur mobile)
- [ ] Navbar sticky en haut
- [ ] Dropdown user fonctionne

### Fonctionnalité

- [ ] Register crée un utilisateur
- [ ] Login authentifie
- [ ] Logout déconnecte
- [ ] Navbar se met à jour après login/logout
- [ ] Welcome page visible aux guests
- [ ] Produits visibles aux authentifiés
- [ ] Redirection correcte après actions

### Validation

- [ ] Messages d'erreur affichés
- [ ] Email unique check fonctionne
- [ ] Password confirmation check fonctionne
- [ ] Tous les champs requis
- [ ] Minimum length check
- [ ] HTML escaping (pas de code injecté)

### Sécurité

- [ ] CSRF token présent sur les forms
- [ ] Password hashé (jamais en plaintext)
- [ ] Session persistante
- [ ] Logout détruit la session
- [ ] Pas d'accès aux données d'autres users

---

## 💾 Données de Test

### Compte Test Créé

```
Email:              jean.dupont@example.com
Password:           Test123456!
First Name:         Jean
Last Name:          Dupont
Phone:              +33612345678
Role:               customer
Email Verified:     ✅ OUI
```

### Autre Compte à Créer

```
Email:              marie.martin@example.com
Password:           SecurePass789!
First Name:         Marie
Last Name:          Martin
Phone:              +33623456789
Role:               customer
Email Verified:     ✅ OUI
```

---

## 📊 Points de Contrôle Importants

### Email Verification

```
✅ NON REQUIS de cliquer sur lien de vérification
✅ Auto-set à email_verified_at = NOW lors de register
✅ Permet immédiatement l'accès au checkout (futur)
```

### Role Assignment

```
✅ Automatiquement set à "customer"
✅ Permet les futures vérifications de rôle
✅ Différencie des admins/owners
```

### Remember-Me

```
✅ Optionnel dans le formulaire login
✅ Si coché: cookie 'remember_token' set pour 1 an
✅ Authentification automatique au retour
```

### Password Security

```
✅ Minimum 8 caractères
✅ Hashé avec bcrypt
✅ Jamais stocké en plaintext
✅ Jamais visible dans les logs
```

---

## 🎯 Prochaines Étapes

Une fois que le système de base fonctionne:

### Phase 2: Profil Client

```
[ ] Créer page /shop/{subdomain}/profile
[ ] Permettre modification des infos personnelles
[ ] Permettre changement de mot de passe
[ ] Ajouter lien dans navbar dropdown
```

### Phase 3: Historique Commandes

```
[ ] Créer page /shop/{subdomain}/orders
[ ] Lister les commandes du client
[ ] Détail de chaque commande
[ ] Status de la commande en temps réel
```

### Phase 4: Sécurisation du Checkout

```
[ ] Ajouter middleware 'auth' au checkout
[ ] Ajouter middleware 'verified'
[ ] Vérifier email_verified_at != null
[ ] Afficher adresse de livraison
```

---

## 📞 Dépannage

### Problème: Routes non trouvées (404)

**Solution:**

```bash
php artisan cache:clear
php artisan route:clear
```

### Problème: Navbar ne s'affiche pas

**Vérifier:**

```bash
# Vérifier que la navbar est incluse dans app.blade.php
grep -n "navbar" resources/views/shop/layouts/app.blade.php
# Doit afficher: @include('shop.components.navbar')
```

### Problème: Formulaire ne valide pas

**Vérifier:**

```bash
# Vérifier que ShopAuthController existe
ls -la app/Http/Controllers/Shop/ShopAuthController.php
```

### Problème: Session persistant trop longtemps

**Configuration:**

```php
// config/session.php
'lifetime' => 120, // minutes
'expire_on_close' => false,
```

---

## 🎉 Félicitations!

Vous avez maintenant un système d'authentification complet et sécurisé pour votre shop!

**Prochaine étape:** Implémenter les phases 2-5 pour les fonctionnalités avancées.

**Questions?** Consultez les fichiers documentation:

- `SHOP_AUTH_COMPLETE.md` - Guide complet
- `IMPLEMENTATION_CHECKLIST.md` - Checklist détaillée
- `PHASE1_FINAL_SUMMARY.md` - Résumé final

---

**Bon développement! 🚀**
