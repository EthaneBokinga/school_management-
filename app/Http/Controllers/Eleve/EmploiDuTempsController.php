<?php

namespace App\Http\Controllers\Eleve;

use App\Http\Controllers\Controller;
use App\Models\Etudiant;
use App\Models\AnneeScolaire;
use App\Models\EmploiDuTemps;
use Illuminate\Http\Request;

class EmploiDuTempsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $etudiant = Etudiant::find($user->reference_id);
        $anneeActive = AnneeScolaire::where('est_active', true)->first();
        
        $inscription = $etudiant->inscriptions()
            ->where('annee_id', $anneeActive->id)
            ->with('classe')
            ->first();
        
        if (!$inscription) {
            return view('eleve.emploi.index')->with('error', 'Aucune inscription active trouvée');
        }
        
        // Récupérer l'emploi du temps de la classe
        $emploiDuTemps = EmploiDuTemps::with(['cours.matiere', 'cours.enseignant', 'salle'])
            ->whereHas('cours', function($q) use ($inscription, $anneeActive) {
                $q->where('classe_id', $inscription->classe_id)
                  ->where('annee_id', $anneeActive->id);
            })
            ->orderBy('jour_semaine')
            ->orderBy('heure_debut')
            ->get();
        
        // Grouper par jour
        $emploiParJour = $emploiDuTemps->groupBy('jour_semaine');
        
        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
        
        return view('eleve.emploi.index', compact(
            'etudiant',
            'inscription',
            'emploiParJour',
            'jours'
        ));
    }
}