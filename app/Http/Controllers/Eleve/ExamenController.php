<?php

namespace App\Http\Controllers\Eleve;

use App\Http\Controllers\Controller;
use App\Models\Examen;
use App\Models\Inscription;

class ExamenController extends Controller
{
    public function index()
    {
        if (!session('inscription_selectionnee')) {
            return redirect()->route('eleve.selection-annee');
        }

        $inscription = Inscription::with(['classe', 'annee'])->findOrFail(session('inscription_selectionnee'));
        
        // Récupérer tous les examens des cours de ma classe
        $examens = Examen::with(['cours.matiere', 'cours.enseignant', 'typeExamen', 'salle'])
            ->whereHas('cours', function($query) use ($inscription) {
                $query->where('classe_id', $inscription->classe_id)
                      ->where('annee_id', $inscription->annee_id);
            })
            ->orderBy('date_examen', 'asc')
            ->get();
        
        // Séparer les examens à venir et passés
        $examensAVenir = $examens->filter(function($examen) {
            return $examen->date_examen >= now()->toDateString();
        });
        
        $examensPasses = $examens->filter(function($examen) {
            return $examen->date_examen < now()->toDateString();
        });
        
        return view('eleve.examens.index', compact('examensAVenir', 'examensPasses', 'inscription'));
    }
}