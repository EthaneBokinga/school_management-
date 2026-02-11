<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EcheancePaiement;
use App\Models\Inscription;
use Illuminate\Http\Request;

class EcheanceController extends Controller
{
    public function index()
    {
        $echeances = EcheancePaiement::with(['inscription.etudiant', 'inscription.classe'])
            ->orderBy('date_limite', 'asc')
            ->paginate(20);
        
        return view('admin.echeances.index', compact('echeances'));
    }

    public function create()
    {
        $inscriptions = Inscription::with(['etudiant', 'classe'])
            ->whereHas('annee', function($q) {
                $q->where('est_active', true);
            })
            ->get();
        
        return view('admin.echeances.create', compact('inscriptions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'inscription_id' => 'required|exists:inscriptions,id',
            'mois' => 'required|string|max:50',
            'montant_echeance' => 'required|numeric|min:0',
            'date_limite' => 'required|date'
        ]);

        EcheancePaiement::create($validated);

        return redirect()->route('admin.echeances.index')
            ->with('success', 'Échéance créée avec succès');
    }

    public function edit($id)
    {
        $echeance = EcheancePaiement::findOrFail($id);
        return view('admin.echeances.edit', compact('echeance'));
    }

    public function update(Request $request, $id)
    {
        $echeance = EcheancePaiement::findOrFail($id);

        $validated = $request->validate([
            'mois' => 'required|string|max:50',
            'montant_echeance' => 'required|numeric|min:0',
            'date_limite' => 'required|date'
        ]);

        $echeance->update($validated);

        return redirect()->route('admin.echeances.index')
            ->with('success', 'Échéance mise à jour avec succès');
    }

    public function destroy($id)
    {
        $echeance = EcheancePaiement::findOrFail($id);
        $echeance->delete();

        return redirect()->route('admin.echeances.index')
            ->with('success', 'Échéance supprimée avec succès');
    }

    // Générer automatiquement les échéances mensuelles
    public function genererAuto(Inscription $inscription)
    {
        $fraisTotal = $inscription->classe->frais_scolarite;
        $nombreMois = 10; // Octobre à Juillet
        $montantMensuel = $fraisTotal / $nombreMois;
        
        $mois = ['Octobre', 'Novembre', 'Décembre', 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet'];
        
        foreach ($mois as $index => $nomMois) {
            EcheancePaiement::create([
                'inscription_id' => $inscription->id,
                'mois' => $nomMois . ' ' . $inscription->annee->libelle,
                'montant_echeance' => $montantMensuel,
                'date_limite' => now()->addMonths($index)->endOfMonth(),
                'statut' => 'En attente'
            ]);
        }

        return redirect()->back()->with('success', '10 échéances générées automatiquement');
    }

    public function marquerPaye(EcheancePaiement $echeance, Request $request)
    {
        $validated = $request->validate([
            'montant_paye' => 'required|numeric|min:0|max:' . $echeance->montant_echeance
        ]);

        $echeance->update([
            'montant_paye' => $echeance->montant_paye + $validated['montant_paye'],
            'statut' => ($echeance->montant_paye + $validated['montant_paye'] >= $echeance->montant_echeance) ? 'Payé' : 'En attente'
        ]);

        return redirect()->route('admin.echeances.index')
            ->with('success', 'Paiement enregistré');
    }
}