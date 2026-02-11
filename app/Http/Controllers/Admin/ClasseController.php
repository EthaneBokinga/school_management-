<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use App\Models\AnneeScolaire;
use Illuminate\Http\Request;

class ClasseController extends Controller
{
    public function index()
    {
        $classes = Classe::withCount(['inscriptions' => function($q) {
            $q->whereHas('annee', function($query) {
                $query->where('est_active', true);
            });
        }])->get();
        
        return view('admin.classes.index', compact('classes'));
    }

    public function create()
    {
        return view('admin.classes.create');
    }

  public function store(Request $request)
{
    $validated = $request->validate([
        'nom_classe' => 'required|string|max:50|unique:classes',
        'niveau' => 'required|string|max:50',
        'autre_niveau' => 'nullable|string|max:50',
        'frais_scolarite' => 'required|numeric|min:0'
    ]);

    // Si "Autre" est sélectionné, utiliser le champ "autre_niveau"
    if ($validated['niveau'] === 'Autre' && !empty($validated['autre_niveau'])) {
        $validated['niveau'] = $validated['autre_niveau'];
    }

    unset($validated['autre_niveau']); // Retirer ce champ temporaire

    Classe::create($validated);

    return redirect()->route('admin.classes.index')
        ->with('success', 'Classe créée avec succès');
}

    public function show(string $id)
    {
        $classe = Classe::with(['inscriptions.etudiant', 'cours.matiere', 'cours.enseignant'])
            ->findOrFail($id);
        
        $anneeActive = AnneeScolaire::where('est_active', true)->first();
        
        $inscriptions = $classe->inscriptions()
            ->where('annee_id', $anneeActive->id)
            ->with('etudiant')
            ->get();

        return view('admin.classes.show', compact('classe', 'inscriptions'));
    }

    public function edit(string $id)
    {
        $classe = Classe::findOrFail($id);
        return view('admin.classes.edit', compact('classe'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nom_classe' => 'required|string|max:50',
            'niveau' => 'required|string|max:50',
            'frais_scolarite' => 'required|numeric|min:0'
        ]);

        $classe = Classe::findOrFail($id);
        $classe->update($validated);

        return redirect()->route('admin.classes.index')
            ->with('success', 'Classe mise à jour avec succès');
    }

    public function destroy(string $id)
    {
        $classe = Classe::findOrFail($id);
        
        // Vérifier s'il y a des inscriptions actives
        $hasActiveInscriptions = $classe->inscriptions()
            ->whereHas('annee', function($q) {
                $q->where('est_active', true);
            })->exists();
        
        if ($hasActiveInscriptions) {
            return back()->with('error', 'Impossible de supprimer une classe avec des inscriptions actives');
        }
        
        $classe->delete();

        return redirect()->route('admin.classes.index')
            ->with('success', 'Classe supprimée avec succès');
    }
}