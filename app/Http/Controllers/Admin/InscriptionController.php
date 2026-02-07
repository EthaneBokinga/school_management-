<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inscription;
use App\Models\Etudiant;
use App\Models\Classe;
use App\Models\AnneeScolaire;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InscriptionController extends Controller
{
    public function index()
    {
        $anneeActive = AnneeScolaire::where('est_active', true)->first();
        
        $inscriptions = Inscription::with(['etudiant', 'classe', 'annee'])
            ->where('annee_id', $anneeActive->id)
            ->latest()
            ->paginate(20);
        
        return view('admin.inscriptions.index', compact('inscriptions', 'anneeActive'));
    }

    public function create()
    {
        $etudiants = Etudiant::where('statut_actuel', 'Inscrit')->get();
        $classes = Classe::all();
        $anneeActive = AnneeScolaire::where('est_active', true)->first();
        
        return view('admin.inscriptions.create', compact('etudiants', 'classes', 'anneeActive'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'etudiant_id' => 'required|exists:etudiants,id',
            'classe_id' => 'required|exists:classes,id',
            'type_inscription' => 'required|in:Nouvelle,Réinscription',
            'statut_paiement' => 'required|in:Réglé,Partiel,En attente'
        ]);

        $anneeActive = AnneeScolaire::where('est_active', true)->first();
        
        // Vérifier si l'étudiant n'est pas déjà inscrit cette année
        $existeInscription = Inscription::where('etudiant_id', $validated['etudiant_id'])
            ->where('annee_id', $anneeActive->id)
            ->exists();
        
        if ($existeInscription) {
            return back()->with('error', 'Cet étudiant est déjà inscrit pour cette année scolaire')
                ->withInput();
        }

        DB::beginTransaction();
        
        try {
            $inscription = Inscription::create([
                'etudiant_id' => $validated['etudiant_id'],
                'classe_id' => $validated['classe_id'],
                'annee_id' => $anneeActive->id,
                'type_inscription' => $validated['type_inscription'],
                'statut_paiement' => $validated['statut_paiement'],
                'date_inscription' => now()
            ]);

            // Envoyer une notification à l'étudiant
            $etudiant = Etudiant::find($validated['etudiant_id']);
            $user = $etudiant->user;
            
            if ($user) {
                NotificationHelper::envoyer(
                    $user->id,
                    'Inscription confirmée',
                    'Votre inscription pour l\'année ' . $anneeActive->libelle . ' a été confirmée.'
                );
            }

            DB::commit();

            return redirect()->route('admin.inscriptions.index')
                ->with('success', 'Inscription créée avec succès');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de l\'inscription: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(string $id)
    {
        $inscription = Inscription::with([
            'etudiant',
            'classe',
            'annee',
            'paiements',
            'notes.cours.matiere',
            'absences'
        ])->findOrFail($id);

        return view('admin.inscriptions.show', compact('inscription'));
    }

    public function edit(string $id)
    {
        $inscription = Inscription::findOrFail($id);
        $etudiants = Etudiant::where('statut_actuel', 'Inscrit')->get();
        $classes = Classe::all();
        
        return view('admin.inscriptions.edit', compact('inscription', 'etudiants', 'classes'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'statut_paiement' => 'required|in:Réglé,Partiel,En attente'
        ]);

        $inscription = Inscription::findOrFail($id);
        $inscription->update($validated);

        return redirect()->route('admin.inscriptions.index')
            ->with('success', 'Inscription mise à jour avec succès');
    }

    public function destroy(string $id)
    {
        $inscription = Inscription::findOrFail($id);
        $inscription->delete();

        return redirect()->route('admin.inscriptions.index')
            ->with('success', 'Inscription supprimée avec succès');
    }

    public function paiements(string $id)
    {
        $inscription = Inscription::with(['etudiant', 'classe', 'paiements'])
            ->findOrFail($id);
        
        return view('admin.inscriptions.paiements', compact('inscription'));
    }
}