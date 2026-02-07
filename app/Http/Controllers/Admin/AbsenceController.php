<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use App\Models\Inscription;
use App\Models\Cours;
use App\Models\Classe;
use App\Models\AnneeScolaire;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbsenceController extends Controller
{
    public function index()
    {
        $anneeActive = AnneeScolaire::where('est_active', true)->first();
        
        $absences = Absence::with([
            'inscription.etudiant',
            'inscription.classe',
            'cours.matiere'
        ])
        ->whereHas('inscription', function($q) use ($anneeActive) {
            $q->where('annee_id', $anneeActive->id);
        })
        ->latest('date_absence')
        ->paginate(20);
        
        return view('admin.absences.index', compact('absences', 'anneeActive'));
    }

    public function create()
    {
        $anneeActive = AnneeScolaire::where('est_active', true)->first();
        
        $inscriptions = Inscription::with(['etudiant', 'classe'])
            ->where('annee_id', $anneeActive->id)
            ->get();
        
        $cours = Cours::with(['matiere', 'classe'])
            ->where('annee_id', $anneeActive->id)
            ->get();
        
        return view('admin.absences.create', compact('inscriptions', 'cours'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'inscription_id' => 'required|exists:inscriptions,id',
            'cours_id' => 'nullable|exists:cours,id',
            'date_absence' => 'required|date',
            'est_justifie' => 'required|boolean'
        ]);

        DB::beginTransaction();
        
        try {
            $absence = Absence::create([
                'inscription_id' => $validated['inscription_id'],
                'cours_id' => $validated['cours_id'],
                'date_absence' => $validated['date_absence'],
                'est_justifie' => $validated['est_justifie']
            ]);

            // Envoyer notification à l'étudiant
            $inscription = Inscription::with('etudiant.user')->find($validated['inscription_id']);
            
            if ($inscription->etudiant->user) {
                $message = $validated['est_justifie'] 
                    ? 'Absence justifiée enregistrée le ' . date('d/m/Y', strtotime($validated['date_absence']))
                    : 'Absence non justifiée enregistrée le ' . date('d/m/Y', strtotime($validated['date_absence']));
                
                NotificationHelper::envoyer(
                    $inscription->etudiant->user->id,
                    'Absence enregistrée',
                    $message
                );
            }

            DB::commit();

            return redirect()->route('admin.absences.index')
                ->with('success', 'Absence enregistrée avec succès');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de l\'enregistrement: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(string $id)
    {
        $absence = Absence::with([
            'inscription.etudiant',
            'inscription.classe',
            'cours.matiere',
            'cours.enseignant'
        ])->findOrFail($id);

        return view('admin.absences.show', compact('absence'));
    }

    public function edit(string $id)
    {
        $absence = Absence::with('inscription', 'cours')->findOrFail($id);
        
        return view('admin.absences.edit', compact('absence'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'date_absence' => 'required|date',
            'est_justifie' => 'required|boolean'
        ]);

        $absence = Absence::findOrFail($id);
        $absence->update($validated);

        return redirect()->route('admin.absences.index')
            ->with('success', 'Absence mise à jour avec succès');
    }

    public function destroy(string $id)
    {
        $absence = Absence::findOrFail($id);
        $absence->delete();

        return redirect()->route('admin.absences.index')
            ->with('success', 'Absence supprimée avec succès');
    }

    public function parClasse(string $classe_id)
    {
        $classe = Classe::findOrFail($classe_id);
        $anneeActive = AnneeScolaire::where('est_active', true)->first();
        
        $inscriptions = Inscription::with([
            'etudiant',
            'absences.cours.matiere'
        ])
        ->where('classe_id', $classe_id)
        ->where('annee_id', $anneeActive->id)
        ->get();

        // Calculer les statistiques d'absences
        $statistiques = [];
        foreach ($inscriptions as $inscription) {
            $totalAbsences = $inscription->absences->count();
            $absencesJustifiees = $inscription->absences->where('est_justifie', true)->count();
            $absencesNonJustifiees = $inscription->absences->where('est_justifie', false)->count();
            
            $statistiques[$inscription->id] = [
                'total' => $totalAbsences,
                'justifiees' => $absencesJustifiees,
                'non_justifiees' => $absencesNonJustifiees
            ];
        }

        return view('admin.absences.par-classe', compact('classe', 'inscriptions', 'statistiques', 'anneeActive'));
    }
}