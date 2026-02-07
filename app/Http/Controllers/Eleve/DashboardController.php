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
        $user = auth()->user();
        $etudiant = Etudiant::with('inscriptions.classe')->find($user->reference_id);
        $anneeActive = AnneeScolaire::where('est_active', true)->first();
        
        // Inscription active
        $inscriptionActive = $etudiant->inscriptions()
            ->where('annee_id', $anneeActive->id)
            ->with(['classe', 'notes.cours.matiere', 'absences', 'paiements'])
            ->first();
        
        if (!$inscriptionActive) {
            return view('eleve.dashboard')->with('error', 'Aucune inscription active trouvée');
        }
        
        // Statistiques
        $totalNotes = $inscriptionActive->notes->count();
        $moyenneGenerale = $inscriptionActive->notes->avg('valeur_note');
        $totalAbsences = $inscriptionActive->absences->count();
        $absencesNonJustifiees = $inscriptionActive->absences->where('est_justifie', false)->count();
        
        // Statut paiement
        $fraisScolarite = $inscriptionActive->classe->frais_scolarite;
        $montantPaye = $inscriptionActive->paiements->sum('montant_paye');
        $resteAPayer = $fraisScolarite - $montantPaye;
        
        // Dernières notes
        $dernieresNotes = $inscriptionActive->notes()
            ->with(['cours.matiere', 'typeExamen'])
            ->latest('date_saisie')
            ->limit(5)
            ->get();
        
        return view('eleve.dashboard', compact(
            'etudiant',
            'inscriptionActive',
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