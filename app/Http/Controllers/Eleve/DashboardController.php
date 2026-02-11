<?php

namespace App\Http\Controllers\Eleve;

use App\Http\Controllers\Controller;
use App\Models\Etudiant;
use App\Models\Inscription;
use App\Models\AnneeScolaire;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
{
    // Vérifier si une année a été sélectionnée
    if (!session('inscription_selectionnee')) {
        return redirect()->route('eleve.selection-annee');
    }

    $inscriptionActive = Inscription::with(['etudiant', 'classe', 'annee'])
        ->findOrFail(session('inscription_selectionnee'));
    
    $etudiant = $inscriptionActive->etudiant;

    // Statistiques
    $totalNotes = $inscriptionActive->notes->count();
    $moyenneGenerale = $inscriptionActive->notes->count() > 0 
        ? $inscriptionActive->notes->avg('valeur_note') 
        : null;
    
    $totalAbsences = $inscriptionActive->absences->count();
    $absencesNonJustifiees = $inscriptionActive->absences->where('est_justifie', false)->count();
    
    $fraisScolarite = $inscriptionActive->classe->frais_scolarite;
    $montantPaye = $inscriptionActive->montant_total_paye;
    $resteAPayer = $inscriptionActive->reste_a_payer_total;
    
    $dernieresNotes = $inscriptionActive->notes()
        ->with(['cours.matiere', 'typeExamen'])
        ->orderBy('date_saisie', 'desc')
        ->take(5)
        ->get();

    return view('eleve.dashboard', compact(
        'inscriptionActive',
        'etudiant',
        'totalNotes',
        'moyenneGenerale',
        'totalAbsences',
        'absencesNonJustifiees',
        'fraisScolarite',
        'montantPaye',
        'resteAPayer',
        'dernieresNotes'
    ));
}
}