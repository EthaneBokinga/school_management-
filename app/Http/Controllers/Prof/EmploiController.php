<?php

namespace App\Http\Controllers\Prof;

use App\Http\Controllers\Controller;
use App\Models\Enseignant;
use App\Models\EmploiDuTemps;

class EmploiController extends Controller
{
    public function index()
    {
        $enseignant = Enseignant::where('email', auth()->user()->email)->firstOrFail();
        
        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
        
        // Récupérer tous les emplois du temps de mes cours
        $emplois = EmploiDuTemps::with(['cours.matiere', 'cours.classe', 'salle'])
            ->whereHas('cours', function($query) use ($enseignant) {
                $query->where('enseignant_id', $enseignant->id)
                      ->whereHas('annee', function($q) {
                          $q->where('est_active', true);
                      });
            })
            ->get();
        
        // Grouper par jour
        $emploisParJour = $emplois->groupBy('jour_semaine');
        
        return view('prof.emploi.index', compact('enseignant', 'jours', 'emploisParJour'));
    }
}