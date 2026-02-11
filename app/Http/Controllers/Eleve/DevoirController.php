<?php

namespace App\Http\Controllers\Eleve;

use App\Http\Controllers\Controller;
use App\Models\Devoir;
use App\Models\Inscription;

class DevoirController extends Controller
{
    public function index()
    {
        if (!session('inscription_selectionnee')) {
            return redirect()->route('eleve.selection-annee');
        }

        $inscription = Inscription::with(['classe', 'annee'])->findOrFail(session('inscription_selectionnee'));
        
        // Récupérer tous les devoirs des cours de ma classe
        $devoirs = Devoir::with(['cours.matiere', 'cours.enseignant'])
            ->whereHas('cours', function($query) use ($inscription) {
                $query->where('classe_id', $inscription->classe_id)
                      ->where('annee_id', $inscription->annee_id);
            })
            ->orderBy('date_limite', 'desc')
            ->get();
        
        // Séparer les devoirs à venir et passés
        $devoirsAVenir = $devoirs->filter(function($devoir) {
            return \Carbon\Carbon::parse($devoir->date_limite)->isFuture();
        });
        
        $devoirsPasses = $devoirs->filter(function($devoir) {
            return \Carbon\Carbon::parse($devoir->date_limite)->isPast();
        });
        
        return view('eleve.devoirs.index', compact('devoirsAVenir', 'devoirsPasses', 'inscription'));
    }
}