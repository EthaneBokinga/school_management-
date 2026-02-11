<?php

namespace App\Http\Controllers\Prof;

use App\Http\Controllers\Controller;
use App\Models\Examen;
use App\Models\Cours;
use App\Models\TypeExamen;
use App\Models\Salle;
use App\Models\Enseignant;
use Illuminate\Http\Request;
use App\Helpers\NotificationHelper;

class ExamenController extends Controller
{
    public function index()
    {
        $enseignant = Enseignant::where('email', auth()->user()->email)->firstOrFail();
        
        $examens = Examen::with(['cours.matiere', 'cours.classe', 'typeExamen', 'salle'])
            ->whereHas('cours', function($query) use ($enseignant) {
                $query->where('enseignant_id', $enseignant->id);
            })
            ->orderBy('date_examen', 'desc')
            ->paginate(15);
        
        return view('prof.examens.index', compact('examens'));
    }

    public function create()
    {
        $enseignant = Enseignant::where('email', auth()->user()->email)->firstOrFail();
        
        $cours = Cours::with(['matiere', 'classe'])
            ->where('enseignant_id', $enseignant->id)
            ->whereHas('annee', function($q) {
                $q->where('est_active', true);
            })
            ->get();
        
        $typesExamens = TypeExamen::all();
        $salles = Salle::all();
        
        return view('prof.examens.create', compact('cours', 'typesExamens', 'salles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cours_id' => 'required|exists:cours,id',
            'type_examen_id' => 'required|exists:types_examens,id',
            'titre' => 'required|string|max:200',
            'description' => 'nullable|string',
            'date_examen' => 'required|date|after:today',
            'heure_debut' => 'required',
            'heure_fin' => 'required|after:heure_debut',
            'salle_id' => 'nullable|exists:salles,id'
        ]);

        // Vérifier que le cours appartient au professeur
        $enseignant = Enseignant::where('email', auth()->user()->email)->firstOrFail();
        $cours = Cours::where('id', $validated['cours_id'])
            ->where('enseignant_id', $enseignant->id)
            ->firstOrFail();

        $examen = Examen::create($validated);

        // Notifier l'admin
        $admins = \App\Models\User::whereHas('role', function($q) {
            $q->where('nom_role', 'Admin');
        })->get();
        
        foreach ($admins as $admin) {
            NotificationHelper::envoyer(
                $admin->id,
                'Nouvel examen créé',
                'Le professeur ' . $enseignant->prenom . ' ' . $enseignant->nom . ' a créé un examen en ' . 
                $cours->matiere->nom_matiere
            );
        }

        // Notifier tous les élèves
        $inscriptions = $cours->classe->inscriptions()
            ->whereHas('annee', function($q) {
                $q->where('est_active', true);
            })
            ->get();

        $userIds = [];
        foreach ($inscriptions as $inscription) {
            if ($inscription->etudiant->user) {
                $userIds[] = $inscription->etudiant->user->id;
            }
        }

        if (!empty($userIds)) {
            NotificationHelper::envoyerGroupe(
                $userIds,
                'Examen programmé : ' . $examen->titre,
                'Un examen de ' . $cours->matiere->nom_matiere . ' aura lieu le ' . 
                $examen->date_examen->format('d/m/Y') . ' à ' . $examen->heure_debut
            );
        }

        return redirect()->route('prof.examens.index')
            ->with('success', 'Examen programmé avec succès');
    }

    public function edit(Examen $examen)
    {
        // Vérifier que l'examen appartient au professeur
        $enseignant = Enseignant::where('email', auth()->user()->email)->firstOrFail();
        
        if ($examen->cours->enseignant_id !== $enseignant->id) {
            abort(403, 'Action non autorisée');
        }

        $cours = Cours::with(['matiere', 'classe'])
            ->where('enseignant_id', $enseignant->id)
            ->whereHas('annee', function($q) {
                $q->where('est_active', true);
            })
            ->get();
        
        $typesExamens = TypeExamen::all();
        $salles = Salle::all();
        
        return view('prof.examens.edit', compact('examen', 'cours', 'typesExamens', 'salles'));
    }

    public function update(Request $request, Examen $examen)
    {
        // Vérifier que l'examen appartient au professeur
        $enseignant = Enseignant::where('email', auth()->user()->email)->firstOrFail();
        
        if ($examen->cours->enseignant_id !== $enseignant->id) {
            abort(403, 'Action non autorisée');
        }

        $validated = $request->validate([
            'titre' => 'required|string|max:200',
            'description' => 'nullable|string',
            'date_examen' => 'required|date',
            'heure_debut' => 'required',
            'heure_fin' => 'required|after:heure_debut',
            'salle_id' => 'nullable|exists:salles,id',
            'type_examen_id' => 'required|exists:types_examens,id'
        ]);

        $examen->update($validated);

        return redirect()->route('prof.examens.index')
            ->with('success', 'Examen modifié avec succès');
    }

    public function destroy(Examen $examen)
    {
        // Vérifier que l'examen appartient au professeur
        $enseignant = Enseignant::where('email', auth()->user()->email)->firstOrFail();
        
        if ($examen->cours->enseignant_id !== $enseignant->id) {
            abort(403, 'Action non autorisée');
        }

        $examen->delete();

        return redirect()->route('prof.examens.index')
            ->with('success', 'Examen supprimé avec succès');
    }
}