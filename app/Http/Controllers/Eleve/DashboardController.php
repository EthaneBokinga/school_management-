<?php

namespace App\Http\Controllers\Eleve;

use App\Http\Controllers\Controller;
use App\Models\Etudiant;
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

    $inscription = Inscription::with(['etudiant', 'classe', 'annee'])
        ->findOrFail(session('inscription_selectionnee'));
    
    $etudiant = $inscription->etudiant;

    // Statistiques
    $totalNotes = $inscription->notes->count();
    $moyenneGenerale = $inscription->notes->count() > 0 
        ? $inscription->notes->avg('valeur_note') 
        : null;
    
    $totalAbsences = $inscription->absences->count();
    $absencesNonJustifiees = $inscription->absences->where('est_justifie', false)->count();
    
    $fraisScolarite = $inscription->classe->frais_scolarite;
    $montantPaye = $inscription->montant_total_paye;
    $resteAPayer = $inscription->reste_a_payer_total;
    
    $dernieresNotes = $inscription->notes()
        ->with(['cours.matiere', 'typeExamen'])
        ->orderBy('date_saisie', 'desc')
        ->take(5)
        ->get();

    return view('eleve.dashboard', compact(
        'inscription',
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