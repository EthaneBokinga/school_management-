# 🎓 SCHOOL MANAGER - Système de Gestion Scolaire

## 📋 Table des matières

1. [Vue d'ensemble](#vue-densemble)
2. [Technologies utilisées](#technologies-utilisées)
3. [Architecture du projet](#architecture-du-projet)
4. [Installation](#installation)
5. [Structure de la base de données](#structure-de-la-base-de-données)
6. [Fonctionnalités](#fonctionnalités)
7. [Rôles et permissions](#rôles-et-permissions)
8. [Principes de développement](#principes-de-développement)
9. [Guide du développeur](#guide-du-développeur)

---

## 🌟 Vue d'ensemble

**School Manager** est un système complet de gestion scolaire développé avec Laravel 10. Il permet de gérer tous les aspects d'un établissement scolaire : inscriptions, notes, absences, paiements, emplois du temps, etc.

### Contexte du développement

Ce projet a été conçu pour répondre aux besoins d'une école moderne souhaitant :
- Digitaliser la gestion administrative
- Faciliter le suivi académique des élèves
- Améliorer la communication entre administration, enseignants et élèves
- Automatiser les processus répétitifs (calcul de moyennes, génération de bulletins, etc.)

---

## 🛠 Technologies utilisées

### Backend
- **Laravel 10** - Framework PHP
- **PHP 8.1+** - Langage de programmation
- **MySQL** - Base de données relationnelle

### Frontend
- **Bootstrap 5.3** - Framework CSS
- **Blade** - Moteur de template Laravel
- **Font Awesome 6** - Icônes
- **JavaScript/jQuery** - Interactions dynamiques

### Outils & Librairies
- **Laravel UI** - Authentification scaffolding
- **DomPDF** - Génération de PDF (bulletins, rapports)
- **Composer** - Gestionnaire de dépendances PHP
- **NPM** - Gestionnaire de dépendances JavaScript

---

## 🏗 Architecture du projet

### Pattern MVC (Model-View-Controller)

Le projet suit strictement le pattern MVC de Laravel :
```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/          # Contrôleurs administrateur
│   │   ├── Prof/           # Contrôleurs professeur
│   │   └── Eleve/          # Contrôleurs élève
│   └── Middleware/         # Middlewares de sécurité
├── Models/                 # Modèles Eloquent ORM
└── Helpers/                # Fonctions utilitaires

resources/
└── views/
    ├── admin/              # Vues administrateur
    ├── prof/               # Vues professeur
    ├── eleve/              # Vues élève
    └── layouts/            # Templates de base

database/
├── migrations/             # Schémas de base de données
└── seeders/                # Données de test
```

### Principes SOLID appliqués

1. **Single Responsibility Principle (SRP)**
   - Chaque contrôleur gère un seul type d'entité
   - Les modèles ne contiennent que la logique métier liée à l'entité

2. **Open/Closed Principle (OCP)**
   - Les middlewares permettent d'étendre les fonctionnalités sans modifier le code existant

3. **Dependency Inversion Principle (DIP)**
   - Utilisation de l'injection de dépendances de Laravel
   - Les contrôleurs dépendent d'abstractions (interfaces Eloquent) et non d'implémentations concrètes

---

## 💾 Structure de la base de données

### Tables principales

#### 1. **Gestion des utilisateurs**
```
- roles (Admin, Prof, Eleve, Parent)
- users (comptes d'accès)
```

#### 2. **Structure pédagogique**
```
- annees_scolaires (2023-2024, 2024-2025, etc.)
- classes (6ème A, Terminale B, etc.)
- matieres (Mathématiques, Français, etc.)
- salles (Salle A1, Labo Informatique, etc.)
```

#### 3. **Acteurs**
```
- etudiants (informations personnelles)
- enseignants (spécialités, contacts)
```

#### 4. **Logique académique**
```
- inscriptions (table pivot centrale - année/classe/étudiant)
- cours (enseignant/matière/classe/année)
- emplois_du_temps (planification hebdomadaire)
```

#### 5. **Évaluations**
```
- types_examens (Contrôle, Examen, etc.)
- notes (liées à inscription + cours)
- absences (avec justification)
```

#### 6. **Finances**
```
- paiements (suivi des versements)
```

#### 7. **Communication**
```
- notifications (alertes en temps réel)
- logs_activites (traçabilité des actions)
- devoirs, ressources_pedagogiques
```

### Clé de voûte : la table `inscriptions`

**Principe fondamental :** La table `inscriptions` est la **table pivot centrale** du système.

**Pourquoi ?**
- Elle lie un étudiant à une classe pour une année scolaire donnée
- Elle permet les réinscriptions (nouveau tuple chaque année)
- Toutes les notes, absences et paiements sont liés à l'inscription, pas directement à l'étudiant

**Exemple pratique :**
```
Étudiant "Jean DUPONT" :
- Inscription 2023-2024 → 5ème A → Notes de 5ème → Paiements de 5ème
- Inscription 2024-2025 → 4ème B → Notes de 4ème → Paiements de 4ème
```

Cela permet :
✅ Historique complet année par année
✅ Réinscriptions automatiques
✅ Changement de classe sans perdre les données
✅ Statistiques par année scolaire

---

## ⚡ Fonctionnalités

### 👨‍💼 Administration

#### Gestion des Étudiants
- ➕ Ajout/modification/suppression d'étudiants
- 📝 Création automatique de comptes utilisateurs
- 🔄 Système de réinscription annuelle
- 📊 Vue détaillée : notes, absences, paiements

#### Gestion des Enseignants
- ➕ Ajout/modification/suppression d'enseignants
- 📚 Attribution des cours
- 👤 Création de comptes professeurs

#### Gestion des Cours
- 📘 Attribution matière/enseignant/classe
- ⏰ Configuration emploi du temps
- 📋 Suivi des ressources pédagogiques

#### Gestion Financière
- 💰 Enregistrement des paiements
- 📊 Statistiques financières en temps réel
- 📄 Export PDF des rapports de paiements
- 🎯 Suivi des impayés

#### Gestion des Notes
- ⭐ Consultation de toutes les notes
- 📈 Statistiques par classe/matière
- 🔍 Recherche et filtres avancés

#### Gestion des Absences
- 📅 Enregistrement des absences
- ✅ Gestion des justifications
- 📊 Statistiques par classe

### 👨‍🏫 Professeur

#### Mon Espace
- 📚 Vue d'ensemble de mes cours
- 📊 Statistiques (nombre de classes, devoirs, etc.)
- 📅 Emploi du temps personnel

#### Gestion des Notes
- ✏️ Saisie multiple de notes par classe
- 📝 Modification des notes saisies
- 📊 Historique complet

#### Gestion des Absences
- ✔️ Pointage des absents par cours
- 📋 Historique des absences enregistrées

### 👨‍🎓 Élève

#### Mon Dashboard
- 📊 Moyennes et statistiques personnelles
- 📈 Graphique de progression
- 💰 Situation financière
- 📢 Dernières notifications

#### Mes Notes
- ⭐ Consultation par matière
- 📊 Calcul automatique des moyennes (avec coefficients)
- 🎖️ Mentions et appréciations
- 📄 Téléchargement du bulletin en PDF

#### Mon Emploi du Temps
- 📅 Vue hebdomadaire complète
- 🏫 Informations sur les salles
- 👨‍🏫 Noms des enseignants
- 🖨️ Version imprimable

---

## 🔐 Rôles et permissions

### Architecture de sécurité

Le système utilise une **gestion des rôles basée sur les middlewares**.

#### Middlewares créés

1. **AdminMiddleware** (`app/Http/Middleware/AdminMiddleware.php`)
   - Vérifie : `$user->isAdmin()`
   - Protège : toutes les routes `/admin/*`

2. **ProfMiddleware** (`app/Http/Middleware/ProfMiddleware.php`)
   - Vérifie : `$user->isProf()`
   - Protège : toutes les routes `/prof/*`

3. **EleveMiddleware** (`app/Http/Middleware/EleveMiddleware.php`)
   - Vérifie : `$user->isEleve()`
   - Protège : toutes les routes `/eleve/*`

4. **LogActivity** (`app/Http/Middleware/LogActivity.php`)
   - Enregistre chaque action dans `logs_activites`
   - Traçabilité complète du système

#### Redirection automatique après login

**Fichier : `app/Http/Controllers/Auth/LoginController.php`**

Après authentification, redirection automatique selon le rôle :
- Admin → `/admin/dashboard`
- Professeur → `/prof/dashboard`
- Élève → `/eleve/dashboard`

**Implémentation :**
```php
protected function authenticated(Request $request, $user)
{
    if ($user->isAdmin()) return redirect()->route('admin.dashboard');
    if ($user->isProf()) return redirect()->route('prof.dashboard');
    if ($user->isEleve()) return redirect()->route('eleve.dashboard');
}
```

---

## 🧑‍💻 Principes de développement

### 1. Convention de nommage

#### Modèles (Models)
- Singulier, PascalCase
- Exemple : `Etudiant`, `Classe`, `AnneeScolaire`

#### Tables de base de données
- Pluriel, snake_case
- Exemple : `etudiants`, `classes`, `annees_scolaires`

#### Contrôleurs
- Suffixe `Controller`
- Exemple : `EtudiantController`, `DashboardController`

#### Routes
- snake_case ou kebab-case
- Exemple : `admin.etudiants.index`, `prof.notes.create`

### 2. Eloquent ORM - Relations

**Exemple : Modèle Inscription**
```php
class Inscription extends Model
{
    // Relation : une inscription appartient à un étudiant
    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'etudiant_id');
    }

    // Relation : une inscription a plusieurs notes
    public function notes()
    {
        return $this->hasMany(Note::class, 'inscription_id');
    }

    // Accesseur personnalisé
    public function getMontantTotalPayeAttribute()
    {
        return $this->paiements->sum('montant_paye');
    }
}
```

**Types de relations utilisées :**
- `belongsTo` : appartient à (N vers 1)
- `hasMany` : a plusieurs (1 vers N)
- `hasOne` : a un seul (1 vers 1)

### 3. Validation des données

**Toujours valider côté serveur :**
```php
$validated = $request->validate([
    'nom' => 'required|string|max:50',
    'email' => 'required|email|unique:etudiants',
    'date_naissance' => 'required|date',
    'valeur_note' => 'required|numeric|min:0|max:20'
]);
```

### 4. Gestion des erreurs

**Try-catch pour les opérations critiques :**
```php
DB::beginTransaction();
try {
    // Opérations multiples
    $etudiant = Etudiant::create($data);
    User::create($userData);
    
    DB::commit();
    return redirect()->with('success', 'Opération réussie');
} catch (\Exception $e) {
    DB::rollBack();
    return back()->with('error', 'Erreur: ' . $e->getMessage());
}
```

### 5. Notifications utilisateur

**Système de notifications en temps réel :**
```php
use App\Helpers\NotificationHelper;

NotificationHelper::envoyer(
    $userId,
    'Titre de la notification',
    'Message détaillé'
);
```

**Compteur dynamique :**
- Chargement AJAX toutes les 30 secondes
- Badge rouge sur l'icône de notification
- Mise à jour automatique après lecture

---

## 📖 Guide du développeur

### Installation du projet
```bash
# 1. Cloner le projet
git clone [url-du-repo]
cd school-management

# 2. Installer les dépendances PHP
composer install

# 3. Installer les dépendances JavaScript
npm install && npm run build

# 4. Configurer l'environnement
cp .env.example .env
php artisan key:generate

# 5. Configurer la base de données dans .env
DB_DATABASE=school_management
DB_USERNAME=root
DB_PASSWORD=

# 6. Créer la base de données
mysql -u root -p
CREATE DATABASE school_management;
exit;

# 7. Exécuter les migrations
php artisan migrate

# 8. Insérer les données de test
php artisan db:seed

# 9. Lancer le serveur
php artisan serve
```

### Comptes de test

Après le seeding, vous pouvez vous connecter avec :

**Administrateur :**
- Email : `admin@school.cg`
- Mot de passe : `password`

**Professeur (exemple) :**
- Email : `jean.mbemba@school.cg`
- Mot de passe : `password`

**Élève (exemple) :**
- Email : `etu2024001@eleve.school.cg`
- Mot de passe : `password`

### Ajout d'une nouvelle fonctionnalité

#### Exemple : Ajouter la gestion des bulletins personnalisés

**Étape 1 : Créer la migration**
```bash
php artisan make:migration create_bulletins_table
```

**Étape 2 : Créer le modèle**
```bash
php artisan make:model Bulletin
```

**Étape 3 : Créer le contrôleur**
```bash
php artisan make:controller Admin/BulletinController --resource
```

**Étape 4 : Ajouter les routes** (`routes/web.php`)
```php
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('bulletins', BulletinController::class);
});
```

**Étape 5 : Créer les vues**
```
resources/views/admin/bulletins/
├── index.blade.php
├── create.blade.php
├── edit.blade.php
└── show.blade.php
```

### Debugging

**Activer le mode debug :** (``.env`)
```
APP_DEBUG=true
```

**Logs Laravel :**
```bash
tail -f storage/logs/laravel.log
```

**Debug avec dd() (Dump & Die) :**
```php
dd($variable); // Affiche et arrête l'exécution
dump($variable); // Affiche sans arrêter
```

### Commandes utiles
```bash
# Nettoyer le cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Reconstruire l'autoloader
composer dump-autoload

# Créer un nouveau contrôleur
php artisan make:controller NomController

# Créer un nouveau modèle avec migration
php artisan make:model NomModele -m

# Rafraîchir la base de données
php artisan migrate:fresh --seed
```

---

## 🎨 Personnalisation du design

### Couleurs principales

Définies dans `resources/views/layouts/app.blade.php` :
```css
:root {
    --primary-color: #4e73df;    /* Bleu principal */
    --secondary-color: #858796;  /* Gris */
    --success-color: #1cc88a;    /* Vert */
    --info-color: #36b9cc;       /* Cyan */
    --warning-color: #f6c23e;    /* Jaune */
    --danger-color: #e74a3b;     /* Rouge */
}
```

### Modifier le logo

Remplacer l'icône dans la navbar :
```blade
<i class="fas fa-graduation-cap"></i> <!-- Icône actuelle -->
<!-- Remplacer par votre logo : -->
<img src="{{ asset('images/logo.png') }}" alt="Logo">
```

---

## 🔧 Ajustements techniques importants

### 1. Pourquoi HasFactory manquait-il ?

**Problème initial :**
```
Trait "App\Models\HasFactory" not found
```

**Cause :** L'import était manquant dans les modèles.

**Solution :** Ajouter systématiquement dans chaque modèle :
```php
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NomModele extends Model
{
    use HasFactory;
}
```

**Raison :** Laravel 8+ utilise les factories pour générer des données de test. Sans cet import, l'erreur survient.

### 2. Pourquoi le middleware LogActivity causait des erreurs ?

**Problème :** La classe `LogActivite` n'était pas importée.

**Solution :**
```php
use App\Models\LogActivite; // Import manquant
```

**Bonne pratique :** Toujours entourer les logs d'un try-catch pour ne pas bloquer les requêtes :
```php
try {
    LogActivite::create([...]);
} catch (\Exception $e) {
    \Log::error('Erreur log: ' . $e->getMessage());
}
```

### 3. Erreur 419 - Page expirée

**Cause :** Token CSRF expiré (session Laravel expire après inactivité).

**Solutions :**
1. Actualiser la page avant de se reconnecter
2. Augmenter la durée de session dans `config/session.php` :
```php
   'lifetime' => 120, // minutes (2 heures par défaut)
```

---

## 📚 Ressources et documentation

### Documentation officielle
- [Laravel 10](https://laravel.com/docs/10.x)
- [Bootstrap 5](https://getbootstrap.com/docs/5.3)
- [Font Awesome](https://fontawesome.com/icons)

### Packages utilisés
- [Laravel UI](https://github.com/laravel/ui)
- [DomPDF](https://github.com/barryvdh/laravel-dompdf)

---

## 🤝 Contribution

Pour contribuer au projet :

1. Forker le repository
2. Créer une branche feature (`git checkout -b feature/AmazingFeature`)
3. Commit vos changements (`git commit -m 'Add AmazingFeature'`)
4. Push vers la branche (`git push origin feature/AmazingFeature`)
5. Ouvrir une Pull Request

---

## 📝 Licence

Ce projet est développé à des fins éducatives.

---

## 👥 Support

Pour toute question ou problème :
- Ouvrir une issue sur GitHub
- Consulter la documentation Laravel
- Vérifier les logs : `storage/logs/laravel.log`

---

**Développé avec ❤️ et Laravel**