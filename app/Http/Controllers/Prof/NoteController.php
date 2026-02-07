<?php

namespace App\Http\Controllers\Prof;

use App\Http\Controllers\Controller;
use App\Models\Note;
use App\Models\Cours;
use App\Models\Enseignant;
use App\Models\TypeExamen;
use App\Models\Inscription;
use App\Models\AnneeScolaire;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NoteController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $enseignant = Enseignant::find($user->reference_id);
        $anneeActive = AnneeScolaire::where('est_active', true)->first();
        
        $mesCours = Cours::where('enseignant_id', $enseignant->id)
            ->where('annee_id', $anneeActive->id)
            ->pluck('id');
        
        $notes = Note::with([
            'inscription.etudiant',
            'inscription.classe',
            'cours.matiere',
            'typeExamen'
        ])
        ->whereIn('cours_id', $mesCours)
        ->latest('date_saisie')
        ->paginate(20);
        
        return view('prof.notes.index', compact('notes'));
    }

    public function create(string $cours_id)
    {
        $user = auth()->user();
        $enseignant = Enseignant::find($user->reference_id);
        
        $cours = Cours::with('classe')
            ->where('enseignant_id', $enseignant->id)
            ->findOrFail($cours_id);
        
        $anneeActive = AnneeScolaire::where('est_active', true)->first();
        
        $inscriptions = Inscription::with('etudiant')
            ->where('classe_id', $cours->classe_id)
            ->where('annee_id', $anneeActive->id)
            ->get();
        
        $typesExamens = TypeExamen::all();
        
        return view('prof.notes.create', compact('cours', 'inscriptions', 'typesExamens'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cours_id' => 'required|exists:cours,id',
            'type_examen_id' => 'required|exists:types_examens,id',
            'notes' => 'required|array',
            'notes.*.inscription_id' => 'required|exists:inscriptions,id',
            'notes.*.valeur_note' => 'required|numeric|min:0|max:20'
        ]);

        $user = auth()->user();
        $enseignant = Enseignant::find($user->reference_id);
        
        // Vérifier que le cours appartient bien à l'enseignant
        $cours = Cours::where('id', $validated['cours_id'])
            ->where('enseignant_id', $enseignant->id)
            ->firstOrFail();

        DB::beginTransaction();
        
        try {
            foreach ($validated['notes'] as $noteData) {
                if (!empty($noteData['valeur_note'])) {
                    $note = Note::create([
                        'inscription_id' => $noteData['inscription_id'],
                        'cours_id' => $validated['cours_id'],
                        'type_examen_id' => $validated['type_examen_id'],
                        'valeur_note' => $noteData['valeur_note'],
                        'date_saisie' => now()
                    ]);

                    // Envoyer notification à l'étudiant
                    $inscription = Inscription::with('etudiant.user')->find($noteData['inscription_id']);
                    
                    if ($inscription->etudiant->user) {
                        NotificationHelper::envoyer(
                            $inscription->etudiant->user->id,
                            'Nouvelle note disponible',
                            'Une note a été ajoutée en ' . $cours->matiere->nom_matiere . ': ' . $noteData['valeur_note'] . '/20'
                        );
                    }
                }
            }

            DB::commit();

            return redirect()->route('prof.notes.index')
                ->with('success', 'Notes enregistrées avec succès');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de l\'enregistrement: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit(string $id)
    {
        $user = auth()->user();
        $enseignant = Enseignant::find($user->reference_id);
        
        $note = Note::with('cours')
            ->whereHas('cours', function($q) use ($enseignant) {
                $q->where('enseignant_id', $enseignant->id);
            })
            ->findOrFail($id);
        
        $typesExamens = TypeExamen::all();
        
        return view('prof.notes.edit', compact('note', 'typesExamens'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'type_examen_id' => 'required|exists:types_examens,id',
            'valeur_note' => 'required|numeric|min:0|max:20'
        ]);

        $user = auth()->user();
        $enseignant = Enseignant::find($user->reference_id);
        
        $note = Note::whereHas('cours', function($q) use ($enseignant) {
            $q->where('enseignant_id', $enseignant->id);
        })->findOrFail($id);
        
        $note->update($validated);

        return redirect()->route('prof.notes.index')
            ->with('success', 'Note mise à jour avec succès');
    }
}