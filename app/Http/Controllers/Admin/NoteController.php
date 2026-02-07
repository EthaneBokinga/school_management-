<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Note;
use App\Models\Inscription;
use App\Models\Cours;
use App\Models\TypeExamen;
use App\Models\Classe;
use App\Models\AnneeScolaire;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NoteController extends Controller
{
    public function index()
    {
        $anneeActive = AnneeScolaire::where('est_active', true)->first();
        
        $notes = Note::with([
            'inscription.etudiant',
            'inscription.classe',
            'cours.matiere',
            'typeExamen'
        ])
        ->whereHas('inscription', function($q) use ($anneeActive) {
            $q->where('annee_id', $anneeActive->id);
        })
        ->latest('date_saisie')
        ->paginate(20);
        
        return view('admin.notes.index', compact('notes', 'anneeActive'));
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
        
        $typesExamens = TypeExamen::all();
        
        return view('admin.notes.create', compact('inscriptions', 'cours', 'typesExamens'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'inscription_id' => 'required|exists:inscriptions,id',
            'cours_id' => 'required|exists:cours,id',
            'type_examen_id' => 'required|exists:types_examens,id',
            'valeur_note' => 'required|numeric|min:0|max:20'
        ]);

        DB::beginTransaction();
        
        try {
            $note = Note::create([
                'inscription_id' => $validated['inscription_id'],
                'cours_id' => $validated['cours_id'],
                'type_examen_id' => $validated['type_examen_id'],
                'valeur_note' => $validated['valeur_note'],
                'date_saisie' => now()
            ]);

            // Envoyer notification à l'étudiant
            $inscription = Inscription::with('etudiant.user', 'classe')->find($validated['inscription_id']);
            $cours = Cours::with('matiere')->find($validated['cours_id']);
            
            if ($inscription->etudiant->user) {
                NotificationHelper::envoyer(
                    $inscription->etudiant->user->id,
                    'Nouvelle note disponible',
                    'Une note a été ajoutée en ' . $cours->matiere->nom_matiere . ': ' . $validated['valeur_note'] . '/20'
                );
            }

            DB::commit();

            return redirect()->route('admin.notes.index')
                ->with('success', 'Note ajoutée avec succès');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de l\'ajout de la note: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(string $id)
    {
        $note = Note::with([
            'inscription.etudiant',
            'inscription.classe',
            'cours.matiere',
            'cours.enseignant',
            'typeExamen'
        ])->findOrFail($id);

        return view('admin.notes.show', compact('note'));
    }

    public function edit(string $id)
    {
        $note = Note::findOrFail($id);
        $typesExamens = TypeExamen::all();
        
        return view('admin.notes.edit', compact('note', 'typesExamens'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'type_examen_id' => 'required|exists:types_examens,id',
            'valeur_note' => 'required|numeric|min:0|max:20'
        ]);

        $note = Note::findOrFail($id);
        $note->update($validated);

        return redirect()->route('admin.notes.index')
            ->with('success', 'Note mise à jour avec succès');
    }

    public function destroy(string $id)
    {
        $note = Note::findOrFail($id);
        $note->delete();

        return redirect()->route('admin.notes.index')
            ->with('success', 'Note supprimée avec succès');
    }

    public function parClasse(string $classe_id)
    {
        $classe = Classe::findOrFail($classe_id);
        $anneeActive = AnneeScolaire::where('est_active', true)->first();
        
        $inscriptions = Inscription::with([
            'etudiant',
            'notes.cours.matiere',
            'notes.typeExamen'
        ])
        ->where('classe_id', $classe_id)
        ->where('annee_id', $anneeActive->id)
        ->get();

        return view('admin.notes.par-classe', compact('classe', 'inscriptions', 'anneeActive'));
    }
}