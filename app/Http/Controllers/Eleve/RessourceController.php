<?php

namespace App\Http\Controllers\Eleve;

use App\Http\Controllers\Controller;
use App\Models\RessourcePedagogique;
use App\Models\Inscription;

class RessourceController extends Controller
{
    public function index()
    {
        if (!session('inscription_selectionnee')) {
            return redirect()->route('eleve.selection-annee');
        }

        $inscription = Inscription::with(['classe', 'annee'])->findOrFail(session('inscription_selectionnee'));
        
        // Récupérer toutes les ressources des cours de ma classe
        $ressources = RessourcePedagogique::with(['cours.matiere', 'cours.enseignant'])
            ->whereHas('cours', function($query) use ($inscription) {
                $query->where('classe_id', $inscription->classe_id)
                      ->where('annee_id', $inscription->annee_id);
            })
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Grouper par matière
        $ressourcesParMatiere = $ressources->groupBy(function($ressource) {
            return $ressource->cours->matiere->nom_matiere;
        });
        
        return view('eleve.ressources.index', compact('ressourcesParMatiere', 'inscription'));
    }
}