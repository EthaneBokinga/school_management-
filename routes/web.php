<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\ClasseController;
use App\Http\Controllers\Admin\EtudiantController;
use App\Http\Controllers\Admin\EnseignantController;
use App\Http\Controllers\Admin\InscriptionController;
use App\Http\Controllers\Admin\CoursController as AdminCoursController;
use App\Http\Controllers\Admin\NoteController as AdminNoteController;
use App\Http\Controllers\Admin\PaiementController;
use App\Http\Controllers\Admin\AbsenceController as AdminAbsenceController;
use App\Http\Controllers\Admin\EcheanceController;
use App\Http\Controllers\Admin\AnneeScolaireController;
use App\Http\Controllers\Prof\DashboardController as ProfDashboard;
use App\Http\Controllers\Prof\CoursController as ProfCoursController;
use App\Http\Controllers\Prof\NoteController as ProfNoteController;
use App\Http\Controllers\Prof\AbsenceController as ProfAbsenceController;
use App\Http\Controllers\Prof\RessourceController as ProfRessourceController;
use App\Http\Controllers\Prof\DevoirController as ProfDevoirController;
use App\Http\Controllers\Prof\ExamenController as ProfExamenController;
use App\Http\Controllers\Prof\EmploiController as ProfEmploiController;
use App\Http\Controllers\Eleve\DashboardController;
use App\Http\Controllers\Eleve\NoteController as EleveNoteController;
use App\Http\Controllers\Eleve\EmploiDuTempsController;
use App\Http\Controllers\Eleve\SelectionAnneeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ThemeController;

// Page d'accueil : afficher la vue publique `welcome`
// Si vous souhaitez revenir à l'ancien comportement (rediriger vers /home si connecté,
// sinon vers /login), décommentez le bloc ci-dessous et commentez la route qui retourne la vue.
/*
Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/home');
    }
    return redirect('/login');
});
*/
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Auth::routes();

// Redirection après login
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route pour définir le thème
Route::post('/set-theme', [ThemeController::class, 'setTheme'])->name('set-theme')->middleware('auth');

// Routes Admin
Route::middleware(['auth', 'admin', 'log.activity'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    
    // Gestion des classes
    Route::resource('classes', ClasseController::class);
    
    // Gestion des étudiants
    Route::resource('etudiants', EtudiantController::class);
    Route::get('etudiants/{id}/reinscription', [EtudiantController::class, 'reinscription'])->name('etudiants.reinscription');
    Route::post('etudiants/{id}/reinscription', [EtudiantController::class, 'storeReinscription'])->name('etudiants.store-reinscription');
    
    // Gestion des enseignants
    Route::resource('enseignants', EnseignantController::class);
    
    // Gestion des inscriptions
    Route::resource('inscriptions', InscriptionController::class);
    Route::get('inscriptions/{id}/paiements', [InscriptionController::class, 'paiements'])->name('inscriptions.paiements');
    
    // Gestion des cours
    Route::resource('cours', AdminCoursController::class);
    Route::get('cours/{id}/emploi', [AdminCoursController::class, 'emploiDuTemps'])->name('cours.emploi');
    
    // Gestion des notes
    Route::resource('notes', AdminNoteController::class);
    Route::get('notes/classe/{classe_id}', [AdminNoteController::class, 'parClasse'])->name('notes.classe');
    
    // Gestion des paiements
    Route::resource('paiements', PaiementController::class);
    Route::get('paiements/export/pdf', [PaiementController::class, 'exportPdf'])->name('paiements.export');
    
    // Gestion des absences
    Route::resource('absences', AdminAbsenceController::class);
    Route::get('absences/classe/{classe_id}', [AdminAbsenceController::class, 'parClasse'])->name('absences.classe');

     // Échéances de paiement
    Route::resource('echeances', EcheanceController::class);
    Route::post('echeances/generer/{inscription}', [EcheanceController::class, 'genererAuto'])->name('echeances.generer');
    Route::post('echeances/{echeance}/payer', [EcheanceController::class, 'marquerPaye'])->name('echeances.payer');

    // Gestion des années scolaires
    Route::resource('annees', AnneeScolaireController::class);
    Route::post('annees/{id}/activer', [AnneeScolaireController::class, 'activer'])->name('annees.activer');
});

// Routes Professeur
Route::middleware(['auth', 'prof', 'log.activity'])->prefix('prof')->name('prof.')->group(function () {
    Route::get('/dashboard', [ProfDashboard::class, 'index'])->name('dashboard');
    
    // Mes cours
    Route::get('/cours', [ProfCoursController::class, 'index'])->name('cours.index');
    Route::get('/cours/{id}', [ProfCoursController::class, 'show'])->name('cours.show');
    
    // Gestion des notes
    Route::get('/notes', [ProfNoteController::class, 'index'])->name('notes.index');
    Route::get('/notes/create/{cours_id}', [ProfNoteController::class, 'create'])->name('notes.create');
    Route::post('/notes', [ProfNoteController::class, 'store'])->name('notes.store');
    Route::get('/notes/{id}/edit', [ProfNoteController::class, 'edit'])->name('notes.edit');
    Route::put('/notes/{id}', [ProfNoteController::class, 'update'])->name('notes.update');
    
    // Gestion des absences
    Route::get('/absences', [ProfAbsenceController::class, 'index'])->name('absences.index');
    Route::post('/absences', [ProfAbsenceController::class, 'store'])->name('absences.store');
    
    // Emploi du temps
    Route::get('/emploi-du-temps', [ProfEmploiController::class, 'index'])->name('emploi.index');

    // Ressources pédagogiques
    Route::resource('ressources', ProfRessourceController::class)->except(['show', 'edit', 'update']);
    
    // Devoirs
    Route::resource('devoirs', ProfDevoirController::class);

    // Examens
    Route::resource('examens', ProfExamenController::class)->except(['show']);
});

// Routes Élève
Route::middleware(['auth', 'eleve', 'log.activity'])->prefix('eleve')->name('eleve.')->group(function () {
    // Sélection année (DOIT ÊTRE AVANT dashboard)
    Route::get('/selection-annee', [SelectionAnneeController::class, 'index'])->name('selection-annee');
    Route::post('/selectionner-annee', [SelectionAnneeController::class, 'selectionner'])->name('selectionner-annee');
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Mes notes
    Route::get('/notes', [EleveNoteController::class, 'index'])->name('notes.index');
    Route::get('/notes/bulletin', [EleveNoteController::class, 'bulletin'])->name('notes.bulletin');
    
    // Mon emploi du temps
    Route::get('/emploi-du-temps', [EmploiDuTempsController::class, 'index'])->name('emploi.index');
    
    // Ressources / Cours
    Route::get('/ressources', [App\Http\Controllers\Eleve\RessourceController::class, 'index'])->name('ressources.index');
    
    // Absences
    Route::get('/absences', [App\Http\Controllers\Eleve\AbsenceController::class, 'index'])->name('absences.index');
    Route::get('/absences/{absence}/justifier', [App\Http\Controllers\Eleve\AbsenceController::class, 'justifier'])->name('absences.justifier');
    Route::post('/absences/{absence}/justification', [App\Http\Controllers\Eleve\AbsenceController::class, 'storeJustification'])->name('absences.store-justification');
    
    // Devoirs
    Route::get('/devoirs', [App\Http\Controllers\Eleve\DevoirController::class, 'index'])->name('devoirs.index');
    
    // Examens
    Route::get('/examens', [App\Http\Controllers\Eleve\ExamenController::class, 'index'])->name('examens.index');
});

// Routes Notifications (tous les utilisateurs connectés)
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/marquer-lu', [NotificationController::class, 'marquerLu'])->name('notifications.marquer-lu');
    Route::get('/notifications/count', [NotificationController::class, 'count'])->name('notifications.count');
});