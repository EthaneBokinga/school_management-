<?php

namespace App\Http\Controllers\Prof;

use App\Http\Controllers\Controller;
use App\Models\Cours;
use App\Models\Enseignant;
use App\Models\AnneeScolaire;
use Illuminate\Http\Request;

class CoursController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $enseignant = Enseignant::find($user->reference_id);
        $anneeActive = AnneeScolaire::where('est_active', true)->first();
        
        $cours = Cours::with(['classe', 'matiere', 'emploisDuTemps'])
            ->where('enseignant_id', $enseignant->id)
            ->where('annee_id', $anneeActive->id)
            ->get();
        
        return view('prof.cours.index', compact('cours', 'enseignant'));
    }

    public function show(string $id)
    {
        $user = auth()->user();
        $enseignant = Enseignant::find($user->reference_id);
        
        $cours = Cours::with([
            'classe.inscriptions.etudiant',
            'matiere',
            'emploisDuTemps.salle',
            'devoirs',
            'ressources'
        ])
        ->where('enseignant_id', $enseignant->id)
        ->findOrFail($id);
        
        return view('prof.cours.show', compact('cours'));
    }
}