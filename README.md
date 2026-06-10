# 🎓 School Hub - Backend

[![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![Laravel Sanctum](https://img.shields.io/badge/Sanctum-4.x-4B7BE5.svg)](https://laravel.com/docs/sanctum)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)

Backend API robuste et sécurisée pour la plateforme de gestion scolaire **School Hub**.

## 📋 Table des matières

- [À propos](#à-propos)
- [Fonctionnalités principales](#fonctionnalités-principales)
- [Architecture](#architecture)
- [Technologies](#technologies)
- [Installation rapide](#installation-rapide)
- [Configuration](#configuration)
- [Utilisation de l'API](#utilisation-de-lapi)
- [Tests](#tests)
- [Contribution](#contribution)
- [License](#license)

---

## 🎯 À propos

**School Hub** est une plateforme complète de gestion des établissements scolaires. Ce backend fournit une API REST sécurisée pour :

- ✅ Authentification des utilisateurs (parents, administrateurs)
- ✅ Gestion des profils et permissions
- ✅ Vérification d'email
- ✅ Réinitialisation de mot de passe sécurisée
- ✅ Authentification à deux facteurs (2FA)
- ✅ Audit et logging complets

**Projet académique** : Module 1 - Inscription et Réinscription (Groupe 1)

---

## ✨ Fonctionnalités principales

### 🔐 Sécurité

| Fonctionnalité | Statut | Description |
|---|---|---|
| **Authentification Sanctum** | ✅ | Tokens JWT sécurisés |
| **Hachage bcrypt** | ✅ | Mots de passe chiffrés avec Bcrypt |
| **Vérification email** | ✅ | Confirmation obligatoire |
| **Réinitialisation mot de passe** | ✅ | Tokens temporaires sécurisés |
| **Authentification 2FA** | ✅ | Google Authenticator support |
| **Codes de récupération** | ✅ | Codes de secours 2FA |
| **Logging d'audit** | ✅ | Traçabilité complète des actions |

### 👥 Gestion des utilisateurs

- **Parents/Tuteurs** : Accès complet à leurs données d'enfants
- **Administrateurs** : Gestion complète du système
- **Système de rôles** : Contrôle d'accès granulaire
- **Profils personnalisables** : Nom, prénom, téléphone, etc.

### 📱 API REST

- **50+ endpoints** documentés
- **Validation complète** des données
- **Gestion des erreurs** cohérente
- **Pagination** intégrée
- **CORS** configuré
- **Rate limiting** optionnel

---

## 🏗️ Architecture

```
backend/
├── app/
│   ├── Http/
│   │   ├── Controllers/Api/
│   │   │   ├── AuthController.php          # Authentification
│   │   │   ├── PasswordResetController.php # Réinitialisation
│   │   │   ├── EmailVerificationController.php
│   │   │   ├── TwoFactorAuthController.php # 2FA
│   │   │   ├── ProfileController.php       # Profils
│   │   │   └── LogController.php           # Audit
│   │   └── Middleware/
│   │       ├── CheckRole.php
│   │       ├── EnsureEmailIsVerified.php
│   │       └── CheckTwoFactorAuth.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── ParentTuteur.php
│   │   └── Responsable.php
│   └── Notifications/
│       ├── ResetPasswordNotification.php
│       └── VerifyEmailNotification.php
├── database/
│   ├── migrations/
│   ├── factories/
│   └── seeders/
├── routes/
│   └── api.php                # Toutes les routes API
├── tests/
│   └── Feature/
│       ├── AuthenticationTest.php
│       └── PasswordResetTest.php
├── .env.example
└── composer.json
```

---

## 🛠️ Technologies

### Framework & Core

| Composant | Version | Usage |
|---|---|---|
| **Laravel** | 12.x | Framework principal |
| **PHP** | 8.2+ | Langage |
| **Composer** | Latest | Gestionnaire de dépendances |

### Base de données

- **SQLite** (développement)
- **MySQL/MariaDB** (production)
- **Migrations** Laravel

### Authentification & Sécurité

| Package | Version | Usage |
|---|---|---|
| **Laravel Sanctum** | 4.x | API tokens & authentication |
| **Google2FA** | 2.x | Authentification 2FA |

### Développement

- **Laravel Sail** : Docker pour dev local
- **PHPUnit** : Tests unitaires
- **Pest** : Framework de test
- **Laravel Pint** : Code formatting

---

## 🚀 Installation rapide

### Prérequis

```bash
# Vérifier les versions
php --version        # 8.2+
composer --version
node --version
```

### Étapes

```bash
# 1. Cloner le repository
git clone https://github.com/RAYANEBIO/School-hub-backend.git
cd School-hub-backend/backend

# 2. Installer les dépendances
composer install

# 3. Copier la configuration
cp .env.example .env

# 4. Générer la clé app
php artisan key:generate

# 5. Configurer la base de données (voir section Configuration)

# 6. Exécuter les migrations
php artisan migrate

# 7. (Optionnel) Charger les données de test
php artisan db:seed

# 8. Lancer le serveur
php artisan serve
```

L'API sera accessible sur : **http://localhost:8000**

---

## ⚙️ Configuration

### 1. Configuration de la base de données

**Option A : SQLite (Développement)**

```env
DB_CONNECTION=sqlite
DB_DATABASE=/chemin/absolu/vers/database.sqlite
```

Créer la base :
```bash
touch database/database.sqlite
```

**Option B : MySQL (Production)**

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=schoolhub_prod
DB_USERNAME=root
DB_PASSWORD=
```

### 2. Configuration Email

Pour la vérification d'email et réinitialisation de mot de passe :

```env
# Gmail (recommandé)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=votre_email@gmail.com
MAIL_PASSWORD=votre_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@schoolhub.com
MAIL_FROM_NAME="School Hub"

# Ou MailtrapBriefly
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_USERNAME=votre_user
MAIL_PASSWORD=votre_password
```

### 3. Configuration Frontend

```env
FRONTEND_URL=http://localhost:3000
SANCTUM_STATEFUL_DOMAINS=localhost:3000
```

### 4. Configuration Sanctum (Tokens)

```php
// config/sanctum.php
'expiration' => 60 * 24,      // Expiration en minutes (24h par défaut)
'token_prefix' => 'sh_',      // Préfixe des tokens
```

### 5. Configuration 2FA

```env
GOOGLE2FA_ENABLED=true
GOOGLE2FA_WINDOW=1
```

---

## 📖 Utilisation de l'API

### Base URL

```
http://localhost:8000/api
```

### Endpoints principaux

#### 🔓 Publiques (sans authentification)

```http
POST   /auth/register/parent          # Créer un compte parent
POST   /auth/login                    # Se connecter
POST   /auth/forgot-password          # Demander réinitialisation
POST   /auth/reset-password           # Réinitialiser mot de passe
POST   /auth/verify-reset-token       # Vérifier le token
GET    /test                          # Vérifier l'API
```

#### 🔒 Protégées (authentification requise)

```http
POST   /auth/logout                   # Se déconnecter
POST   /auth/logout-all               # Déconnexion tous appareils
GET    /auth/me                       # Infos utilisateur
POST   /auth/refresh-token            # Rafraîchir le token

GET    /email/verification-status     # Statut vérification
POST   /email/verification-notification  # Renvoyer email

POST   /profile                       # Mettre à jour le profil
GET    /profile                       # Récupérer le profil
POST   /profile/change-password       # Changer mot de passe
DELETE /profile                       # Supprimer le compte
```

#### 🎛️ 2FA (Authentification à deux facteurs)

```http
POST   /2fa/enable                    # Activer 2FA
POST   /2fa/confirm                   # Confirmer l'activation
POST   /2fa/verify                    # Vérifier le code
POST   /2fa/disable                   # Désactiver 2FA
GET    /2fa/recovery-codes            # Obtenir les codes
POST   /2fa/recovery-codes/regenerate # Régénérer les codes
```

#### 👨‍💼 Admin (rôle admin requis)

```http
POST   /admin/register                # Créer un admin
GET    /admin/list                    # Lister les admins
GET    /admin/{id}                    # Détails d'un admin
PUT    /admin/{id}                    # Modifier un admin
DELETE /admin/{id}                    # Supprimer un admin

GET    /logs                          # Voir tous les logs
GET    /logs/user/{userId}            # Logs d'un utilisateur
POST   /logs/search                   # Rechercher dans les logs
```

### Exemple d'utilisation

#### 1️⃣ S'inscrire

```bash
curl -X POST http://localhost:8000/api/auth/register/parent \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Jean Dupont",
    "email": "jean@example.com",
    "password": "SecurePass123!",
    "password_confirmation": "SecurePass123!",
    "telephone": "+22997123456"
  }'
```

**Réponse :**
```json
{
  "success": true,
  "message": "Inscription réussie. Veuillez vérifier votre email.",
  "data": {
    "user": {
      "id": 1,
      "name": "Jean Dupont",
      "email": "jean@example.com",
      "email_verified_at": null,
      "created_at": "2026-06-10T10:30:00Z"
    }
  }
}
```

#### 2️⃣ Se connecter

```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "jean@example.com",
    "password": "SecurePass123!"
  }'
```

**Réponse :**
```json
{
  "success": true,
  "message": "Connexion réussie",
  "data": {
    "user": {
      "id": 1,
      "name": "Jean Dupont",
      "email": "jean@example.com",
      "role": "parent"
    },
    "token": "sh_1|AbCdEfGhIjKlMnOpQrStUvWxYz123456"
  }
}
```

#### 3️⃣ Utiliser le token

```bash
curl -X GET http://localhost:8000/api/auth/me \
  -H "Authorization: Bearer sh_1|AbCdEfGhIjKlMnOpQrStUvWxYz123456" \
  -H "Accept: application/json"
```

**Réponse :**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "name": "Jean Dupont",
    "email": "jean@example.com",
    "role": "parent",
    "email_verified_at": "2026-06-10T10:35:00Z"
  }
}
```

---

## 🧪 Tests

### Lancer tous les tests

```bash
php artisan test
```

### Tests spécifiques

```bash
# Tests d'authentification uniquement
php artisan test --filter AuthenticationTest

# Test d'une méthode spécifique
php artisan test --filter test_parent_can_register

# Avec couverture de code
php artisan test --coverage
```

### Suites de test disponibles

| Suite | Fichier | Tests |
|---|---|---|
| **Authentification** | `AuthenticationTest.php` | Inscription, connexion, déconnexion |
| **Mot de passe** | `PasswordResetTest.php` | Réinitialisation sécurisée |
| **Email** | `EmailVerificationTest.php` | Vérification d'email |
| **2FA** | `TwoFactorAuthTest.php` | Authentification à deux facteurs |

---

## 📚 Documentation complète

Pour une documentation détaillée, consultez les fichiers dans le dossier `backend/` :

- **`backend/README.md`** - Documentation complète du module Auth
- **`backend/API_DOCUMENTATION.md`** - Spécification de tous les endpoints
- **`backend/FRONTEND_INTEGRATION.md`** - Guide d'intégration frontend
- **`backend/.env.example`** - Variables d'environnement

---

## 🔧 Dépannage courant

### Erreur : "No such file or directory" (migrations)

```bash
# Créer le dossier database si nécessaire
mkdir -p database
touch database/database.sqlite

# Re-lancer les migrations
php artisan migrate
```

### Erreur : "SQLSTATE[HY000] [2002] No such file"

Vérifier le chemin absolu dans `.env` :
```env
# ❌ Mauvais
DB_DATABASE=database.sqlite

# ✅ Bon
DB_DATABASE=/chemin/complet/vers/database.sqlite
```

### Emails non reçus

1. Vérifier la configuration email dans `.env`
2. Vérifier les logs : `storage/logs/laravel.log`
3. Tester avec Mailhog (local) :
   ```bash
   docker run -d -p 1025:1025 -p 8025:8025 mailhog/mailhog
   ```

### Token invalide ou expiré

Les tokens expirent après 24h. Utiliser l'endpoint `/auth/refresh-token` pour en obtenir un nouveau.

---

## 🤝 Contribution

### Workflow Git

```bash
# Créer une branche feature
git checkout -b feature/ma-fonctionnalité

# Faire des commits atomiques
git add .
git commit -m "feat: ajouter la nouvelle fonctionnalité"

# Pousser la branche
git push origin feature/ma-fonctionnalité

# Créer une Pull Request sur GitHub
```

### Standards de code

- ✅ Suivre **PSR-12**
- ✅ Écrire des **tests** pour chaque fonction
- ✅ Documenter les **fonctions complexes**
- ✅ Utiliser **Laravel conventions**
- ✅ Lancer **`php artisan pint`** avant commit

### Types de commits

```
feat:     Nouvelle fonctionnalité
fix:      Correction de bug
docs:     Documentation
style:    Formatting (sans code change)
refactor: Refactorisation
test:     Tests
chore:    Tâches (deps, build, etc)
```

Exemple : `git commit -m "feat: ajouter validation email"`

---

## 📄 License

Ce projet est sous licence **MIT**. Voir [LICENSE](LICENSE) pour les détails.

---

## 📞 Support & Contact

### Équipe

| Rôle | Personne |
|---|---|
| **Lead Backend** | RAYANEBIO |
| **Groupe** | Groupe 1 |
| **Module** | Authentification & Sécurité |

### Ressources

- 📖 [Laravel Documentation](https://laravel.com/docs/12.x)
- 🔐 [Sanctum Documentation](https://laravel.com/docs/sanctum)
- 🎯 [Google2FA](https://pragmarx.github.io/google2fa-laravel/)
- 📝 [API REST Best Practices](https://restfulapi.net/)

### Problèmes

Signaler les bugs et proposer des améliorations via [GitHub Issues](https://github.com/RAYANEBIO/School-hub-backend/issues)

---

## 🏆 Statut du projet

- [x] **Phase 1** : Configuration initiale ✅
- [x] **Phase 2** : Modèles et Migrations ✅
- [x] **Phase 3** : Controllers d'authentification ✅
- [x] **Phase 4** : Sécurité avancée ✅
- [x] **Phase 5** : Tests ✅
- [x] **Phase 6** : Documentation ✅
- 🚧 **Phase 7** : Intégration avec autres modules (en cours)

---

## 📊 Composition du projet

```
PHP       67.8%
Blade     31.9%
Other      0.3%
```

---

**Développé avec ❤️ par RAYANEBIO - Module Authentification & Sécurité**

*School Hub v1.0.0 | Juin 2026*
