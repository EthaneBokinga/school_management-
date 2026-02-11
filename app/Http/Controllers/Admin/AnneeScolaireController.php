<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnneeScolaire;
use Illuminate\Http\Request;

class AnneeScolaireController extends Controller
{
    public function index()
    {
        $annees = AnneeScolaire::latest()->paginate(20);
        return view('admin.annees.index', compact('annees'));
    }

    public function create()
    {
        return view('admin.annees.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:50|unique:annees_scolaires',
            'date_debut' => 'required|date|before:date_fin',
            'date_fin' => 'required|date|after:date_debut',
            'statut' => 'required|in:À venir,En cours,Terminée'
        ]);

        AnneeScolaire::create([
            'libelle' => $validated['libelle'],
            'date_debut' => $validated['date_debut'],
            'date_fin' => $validated['date_fin'],
            'statut' => $validated['statut'],
            'est_active' => false
        ]);

        return redirect()->route('admin.annees.index')
            ->with('success', 'Année scolaire créée avec succès');
    }

    public function edit($id)
    {
        $annee = AnneeScolaire::findOrFail($id);
        return view('admin.annees.edit', compact('annee'));
    }

    public function update(Request $request, $id)
    {
        $annee = AnneeScolaire::findOrFail($id);

        $validated = $request->validate([
            'libelle' => 'required|string|max:50|unique:annees_scolaires,libelle,' . $id,
            'date_debut' => 'required|date|before:date_fin',
            'date_fin' => 'required|date|after:date_debut',
            'statut' => 'required|in:À venir,En cours,Terminée'
        ]);

        $annee->update($validated);

        return redirect()->route('admin.annees.index')
            ->with('success', 'Année scolaire mise à jour avec succès');
    }

    public function activer($id)
    {
        // Désactiver toutes les autres années
        AnneeScolaire::update(['est_active' => false]);

        // Activer l'année sélectionnée
        $annee = AnneeScolaire::findOrFail($id);
        $annee->update(['est_active' => true, 'statut' => 'En cours']);

        return redirect()->route('admin.annees.index')
            ->with('success', 'Année ' . $annee->libelle . ' activée avec succès');
    }

    public function destroy($id)
    {
        $annee = AnneeScolaire::findOrFail($id);

        // Vérifier si l'année a des inscriptions
        if ($annee->inscriptions()->exists()) {
            return back()->with('error', 'Impossible de supprimer une année avec des inscriptions');
        }

        $annee->delete();

        return redirect()->route('admin.annees.index')
            ->with('success', 'Année scolaire supprimée avec succès');
    }
}
