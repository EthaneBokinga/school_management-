<?php

namespace App\Http\Controllers\Prof;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use App\Models\Cours;
use App\Models\Enseignant;
use App\Models\Inscription;
use App\Models\AnneeScolaire;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbsenceController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $enseignant = Enseignant::find($user->reference_id);
        $anneeActive = AnneeScolaire::where('est_active', true)->first();
        
        $mesCours = Cours::where('enseignant_id', $enseignant->id)
            ->where('annee_id', $anneeActive->id)
            ->pluck('id');
        
        $absences = Absence::with([
            'inscription.etudiant',
            'inscription.classe',
            'cours.matiere'
        ])
        ->whereIn('cours_id', $mesCours)
        ->latest('date_absence')
        ->paginate(20);
        
        return view('prof.absences.index', compact('absences'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cours_id' => 'required|exists:cours,id',
            'date_absence' => 'required|date',
            'absences' => 'required|array',
            'absences.*' => 'exists:inscriptions,id'
        ]);

        $user = auth()->user();
        $enseignant = Enseignant::find($user->reference_id);
        
        // Vérifier que le cours appartient bien à l'enseignant
        $cours = Cours::where('id', $validated['cours_id'])
            ->where('enseignant_id', $enseignant->id)
            ->firstOrFail();

        DB::beginTransaction();
        
        try {
            foreach ($validated['absences'] as $inscriptionId) {
                $absence = Absence::create([
                    'inscription_id' => $inscriptionId,
                    'cours_id' => $validated['cours_id'],
                    'date_absence' => $validated['date_absence'],
                    'est_justifie' => false
                ]);

                // Envoyer notification à l'étudiant
                $inscription = Inscription::with('etudiant.user')->find($inscriptionId);
                
                if ($inscription->etudiant->user) {
                    NotificationHelper::envoyer(
                        $inscription->etudiant->user->id,
                        'Absence enregistrée',
                        'Absence enregistrée le ' . date('d/m/Y', strtotime($validated['date_absence'])) . ' en ' . $cours->matiere->nom_matiere
                    );
                }
            }

            DB::commit();

            return back()->with('success', 'Absences enregistrées avec succès');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de l\'enregistrement: ' . $e->getMessage());
        }
    }
}