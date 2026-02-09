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
use App\Http\Controllers\Prof\DashboardController as ProfDashboard;
use App\Http\Controllers\Prof\CoursController as ProfCoursController;
use App\Http\Controllers\Prof\NoteController as ProfNoteController;
use App\Http\Controllers\Prof\AbsenceController as ProfAbsenceController;
use App\Http\Controllers\Eleve\DashboardController as EleveDashboard;
use App\Http\Controllers\Eleve\NoteController as EleveNoteController;
use App\Http\Controllers\Eleve\EmploiDuTempsController;
use App\Http\Controllers\NotificationController;

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

// Routes Admin
Route::middleware(['auth', 'admin', 'log.activity'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    
    // Gestion des classes
    Route::resource('classes', ClasseController::class);
    
    // Gestion des étudiants
    Route::resource('etudiants', EtudiantController::class);
    Route::get('etudiants/{id}/reinscription', [EtudiantController::class, 'reinscription'])->name('etudiants.reinscription');
    
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
});

// Routes Élève
Route::middleware(['auth', 'eleve', 'log.activity'])->prefix('eleve')->name('eleve.')->group(function () {
    Route::get('/dashboard', [EleveDashboard::class, 'index'])->name('dashboard');
    
    // Mes notes
    Route::get('/notes', [EleveNoteController::class, 'index'])->name('notes.index');
    Route::get('/notes/bulletin', [EleveNoteController::class, 'bulletin'])->name('notes.bulletin');
    
    // Mon emploi du temps
    Route::get('/emploi-du-temps', [EmploiDuTempsController::class, 'index'])->name('emploi.index');
});

// Routes Notifications (tous les utilisateurs connectés)
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/marquer-lu', [NotificationController::class, 'marquerLu'])->name('notifications.marquer-lu');
    Route::get('/notifications/count', [NotificationController::class, 'count'])->name('notifications.count');
});