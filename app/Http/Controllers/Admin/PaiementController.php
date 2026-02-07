<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paiement;
use App\Models\Inscription;
use App\Models\AnneeScolaire;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PaiementController extends Controller
{
    public function index()
    {
        $anneeActive = AnneeScolaire::where('est_active', true)->first();
        
        $paiements = Paiement::with([
            'inscription.etudiant',
            'inscription.classe'
        ])
        ->whereHas('inscription', function($q) use ($anneeActive) {
            $q->where('annee_id', $anneeActive->id);
        })
        ->latest('date_paiement')
        ->paginate(20);
        
        // Statistiques
        $totalPaye = Paiement::whereHas('inscription', function($q) use ($anneeActive) {
            $q->where('annee_id', $anneeActive->id);
        })->sum('montant_paye');
        
        $totalReste = Paiement::whereHas('inscription', function($q) use ($anneeActive) {
            $q->where('annee_id', $anneeActive->id);
        })->sum('reste_a_payer');
        
        return view('admin.paiements.index', compact('paiements', 'anneeActive', 'totalPaye', 'totalReste'));
    }

    public function create()
    {
        $anneeActive = AnneeScolaire::where('est_active', true)->first();
        
        $inscriptions = Inscription::with(['etudiant', 'classe'])
            ->where('annee_id', $anneeActive->id)
            ->where('statut_paiement', '!=', 'Réglé')
            ->get();
        
        return view('admin.paiements.create', compact('inscriptions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'inscription_id' => 'required|exists:inscriptions,id',
            'montant_paye' => 'required|numeric|min:0'
        ]);

        DB::beginTransaction();
        
        try {
            $inscription = Inscription::with('classe')->findOrFail($validated['inscription_id']);
            
            // Calculer le total déjà payé
            $totalPaye = $inscription->paiements()->sum('montant_paye');
            $nouveauTotal = $totalPaye + $validated['montant_paye'];
            
            // Calculer le reste à payer
            $fraisScolarite = $inscription->classe->frais_scolarite;
            $resteAPayer = $fraisScolarite - $nouveauTotal;
            
            if ($resteAPayer < 0) {
                return back()->with('error', 'Le montant dépasse les frais de scolarité')
                    ->withInput();
            }

            // Créer le paiement
            $paiement = Paiement::create([
                'inscription_id' => $validated['inscription_id'],
                'montant_paye' => $validated['montant_paye'],
                'reste_a_payer' => $resteAPayer,
                'date_paiement' => now()
            ]);

            // Mettre à jour le statut de paiement de l'inscription
            if ($resteAPayer == 0) {
                $inscription->update(['statut_paiement' => 'Réglé']);
            } elseif ($nouveauTotal > 0) {
                $inscription->update(['statut_paiement' => 'Partiel']);
            }

            // Envoyer notification à l'étudiant
            if ($inscription->etudiant->user) {
                NotificationHelper::envoyer(
                    $inscription->etudiant->user->id,
                    'Paiement enregistré',
                    'Un paiement de ' . number_format($validated['montant_paye'], 0, ',', ' ') . ' FCFA a été enregistré. Reste à payer: ' . number_format($resteAPayer, 0, ',', ' ') . ' FCFA'
                );
            }

            DB::commit();

            return redirect()->route('admin.paiements.index')
                ->with('success', 'Paiement enregistré avec succès');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de l\'enregistrement: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(string $id)
    {
        $paiement = Paiement::with([
            'inscription.etudiant',
            'inscription.classe',
            'inscription.annee'
        ])->findOrFail($id);

        return view('admin.paiements.show', compact('paiement'));
    }

    public function edit(string $id)
    {
        $paiement = Paiement::with('inscription')->findOrFail($id);
        
        return view('admin.paiements.edit', compact('paiement'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'montant_paye' => 'required|numeric|min:0'
        ]);

        DB::beginTransaction();
        
        try {
            $paiement = Paiement::with('inscription.classe')->findOrFail($id);
            $inscription = $paiement->inscription;
            
            // Calculer le nouveau reste à payer
            $ancienMontant = $paiement->montant_paye;
            $nouveauMontant = $validated['montant_paye'];
            $difference = $nouveauMontant - $ancienMontant;
            
            $totalPaye = $inscription->paiements()->where('id', '!=', $id)->sum('montant_paye') + $nouveauMontant;
            $fraisScolarite = $inscription->classe->frais_scolarite;
            $resteAPayer = $fraisScolarite - $totalPaye;
            
            if ($resteAPayer < 0) {
                return back()->with('error', 'Le montant dépasse les frais de scolarité')
                    ->withInput();
            }

            // Mettre à jour le paiement
            $paiement->update([
                'montant_paye' => $nouveauMontant,
                'reste_a_payer' => $resteAPayer
            ]);

            // Mettre à jour le statut de paiement de l'inscription
            if ($resteAPayer == 0) {
                $inscription->update(['statut_paiement' => 'Réglé']);
            } elseif ($totalPaye > 0) {
                $inscription->update(['statut_paiement' => 'Partiel']);
            } else {
                $inscription->update(['statut_paiement' => 'En attente']);
            }

            DB::commit();

            return redirect()->route('admin.paiements.index')
                ->with('success', 'Paiement mis à jour avec succès');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la mise à jour: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(string $id)
    {
        DB::beginTransaction();
        
        try {
            $paiement = Paiement::with('inscription.classe')->findOrFail($id);
            $inscription = $paiement->inscription;
            
            // Supprimer le paiement
            $paiement->delete();
            
            // Recalculer le statut
            $totalPaye = $inscription->paiements()->sum('montant_paye');
            $fraisScolarite = $inscription->classe->frais_scolarite;
            
            if ($totalPaye == 0) {
                $inscription->update(['statut_paiement' => 'En attente']);
            } elseif ($totalPaye < $fraisScolarite) {
                $inscription->update(['statut_paiement' => 'Partiel']);
            } else {
                $inscription->update(['statut_paiement' => 'Réglé']);
            }

            DB::commit();

            return redirect()->route('admin.paiements.index')
                ->with('success', 'Paiement supprimé avec succès');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la suppression: ' . $e->getMessage());
        }
    }

    public function exportPdf()
    {
        $anneeActive = AnneeScolaire::where('est_active', true)->first();
        
        $paiements = Paiement::with([
            'inscription.etudiant',
            'inscription.classe'
        ])
        ->whereHas('inscription', function($q) use ($anneeActive) {
            $q->where('annee_id', $anneeActive->id);
        })
        ->latest('date_paiement')
        ->get();
        
        $totalPaye = $paiements->sum('montant_paye');
        $totalReste = $paiements->sum('reste_a_payer');

        $pdf = Pdf::loadView('admin.paiements.pdf', compact('paiements', 'anneeActive', 'totalPaye', 'totalReste'));
        
        return $pdf->download('paiements-' . $anneeActive->libelle . '.pdf');
    }
}