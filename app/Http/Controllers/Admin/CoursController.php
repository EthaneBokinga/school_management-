<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cours;
use App\Models\Enseignant;
use App\Models\Matiere;
use App\Models\Classe;
use App\Models\AnneeScolaire;
use Illuminate\Http\Request;

class CoursController extends Controller
{
    public function index()
    {
        $anneeActive = AnneeScolaire::where('est_active', true)->first();
        
        $cours = Cours::with(['enseignant', 'matiere', 'classe'])
            ->where('annee_id', $anneeActive->id)
            ->paginate(20);
        
        return view('admin.cours.index', compact('cours', 'anneeActive'));
    }

    public function create()
    {
        $enseignants = Enseignant::all();
        $matieres = Matiere::all();
        $classes = Classe::all();
        $anneeActive = AnneeScolaire::where('est_active', true)->first();
        
        return view('admin.cours.create', compact('enseignants', 'matieres', 'classes', 'anneeActive'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'enseignant_id' => 'required|exists:enseignants,id',
            'matiere_id' => 'required|exists:matieres,id',
            'classe_id' => 'required|exists:classes,id'
        ]);

        $anneeActive = AnneeScolaire::where('est_active', true)->first();
        
        Cours::create([
            'enseignant_id' => $validated['enseignant_id'],
            'matiere_id' => $validated['matiere_id'],
            'classe_id' => $validated['classe_id'],
            'annee_id' => $anneeActive->id
        ]);

        return redirect()->route('admin.cours.index')
            ->with('success', 'Cours créé avec succès');
    }

    public function show(string $id)
    {
        $cours = Cours::with([
            'enseignant',
            'matiere',
            'classe',
            'emploisDuTemps.salle',
            'notes',
            'devoirs',
            'ressources'
        ])->findOrFail($id);

        return view('admin.cours.show', compact('cours'));
    }

    public function edit(string $id)
    {
        $cours = Cours::findOrFail($id);
        $enseignants = Enseignant::all();
        $matieres = Matiere::all();
        $classes = Classe::all();
        
        return view('admin.cours.edit', compact('cours', 'enseignants', 'matieres', 'classes'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'enseignant_id' => 'required|exists:enseignants,id',
            'matiere_id' => 'required|exists:matieres,id',
            'classe_id' => 'required|exists:classes,id'
        ]);

        $cours = Cours::findOrFail($id);
        $cours->update($validated);

        return redirect()->route('admin.cours.index')
            ->with('success', 'Cours mis à jour avec succès');
    }

    public function destroy(string $id)
    {
        $cours = Cours::findOrFail($id);
        $cours->delete();

        return redirect()->route('admin.cours.index')
            ->with('success', 'Cours supprimé avec succès');
    }

    public function emploiDuTemps(string $id)
    {
        $cours = Cours::with(['emploisDuTemps.salle'])->findOrFail($id);
        return view('admin.cours.emploi', compact('cours'));
    }
}