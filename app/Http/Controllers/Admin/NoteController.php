<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Note;
use App\Models\Inscription;
use App\Models\Cours;
use App\Models\TypeExamen;
use App\Models\AnneeScolaire;
use Illuminate\Http\Request;
use App\Helpers\NotificationHelper;

class NoteController extends Controller
{
    public function index()
    {
        $anneeActive = AnneeScolaire::where('est_active', true)->first();
        
        $notes = Note::with(['inscription.etudiant', 'inscription.classe', 'cours.matiere', 'typeExamen'])
            ->whereHas('inscription', function($query) use ($anneeActive) {
                $query->where('annee_id', $anneeActive->id);
            })
            ->orderBy('date_saisie', 'desc')
            ->paginate(20);
        
        return view('admin.notes.index', compact('notes', 'anneeActive'));
    }

    public function create()
    {
        $anneeActive = AnneeScolaire::where('est_active', true)->first();
        $cours = Cours::with(['matiere', 'classe', 'enseignant'])
            ->where('annee_id', $anneeActive->id)
            ->get();
        $typesExamens = TypeExamen::all();
        
        return view('admin.notes.create', compact('cours', 'typesExamens', 'anneeActive'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cours_id' => 'required|exists:cours,id',
            'type_examen_id' => 'required|exists:types_examens,id',
            'notes' => 'required|array',
            'notes.*.inscription_id' => 'required|exists:inscriptions,id',
            'notes.*.valeur_note' => 'nullable|numeric|min:0|max:20'
        ]);

        $count = 0;
        foreach ($request->notes as $noteData) {
            if (!empty($noteData['valeur_note'])) {
                $note = Note::create([
                    'inscription_id' => $noteData['inscription_id'],
                    'cours_id' => $request->cours_id,
                    'type_examen_id' => $request->type_examen_id,
                    'valeur_note' => $noteData['valeur_note'],
                    'date_saisie' => now()
                ]);

                // Notification à l'étudiant
                $inscription = Inscription::find($noteData['inscription_id']);
                if ($inscription->etudiant->user) {
                    NotificationHelper::envoyer(
                        $inscription->etudiant->user->id,
                        'Nouvelle note ajoutée',
                        'Une note a été ajoutée en ' . $note->cours->matiere->nom_matiere
                    );
                }
                $count++;
            }
        }

        return redirect()->route('admin.notes.index')
            ->with('success', "$count note(s) enregistrée(s) avec succès");
    }

    public function show(Note $note)
    {
        $note->load(['inscription.etudiant', 'inscription.classe', 'cours.matiere', 'typeExamen']);
        return view('admin.notes.show', compact('note'));
    }

    public function edit(Note $note)
    {
        $typesExamens = TypeExamen::all();
        $note->load(['inscription.etudiant', 'inscription.classe', 'cours.matiere']);
        
        return view('admin.notes.edit', compact('note', 'typesExamens'));
    }

    public function update(Request $request, Note $note)
    {
        $validated = $request->validate([
            'type_examen_id' => 'required|exists:types_examens,id',
            'valeur_note' => 'required|numeric|min:0|max:20'
        ]);

        $note->update($validated);

        return redirect()->route('admin.notes.index')
            ->with('success', 'Note modifiée avec succès');
    }

    public function destroy(Note $note)
    {
        $note->delete();
        
        return redirect()->route('admin.notes.index')
            ->with('success', 'Note supprimée avec succès');
    }

    // Méthode pour afficher les notes par classe
    public function parClasse(Request $request)
    {
        $anneeActive = AnneeScolaire::where('est_active', true)->first();
        $classe_id = $request->get('classe_id');
        
        $notes = Note::with(['inscription.etudiant', 'cours.matiere', 'typeExamen'])
            ->whereHas('inscription', function($query) use ($anneeActive, $classe_id) {
                $query->where('annee_id', $anneeActive->id);
                if ($classe_id) {
                    $query->where('classe_id', $classe_id);
                }
            })
            ->orderBy('date_saisie', 'desc')
            ->get();
        
        return view('admin.notes.par-classe', compact('notes', 'anneeActive'));
    }
}