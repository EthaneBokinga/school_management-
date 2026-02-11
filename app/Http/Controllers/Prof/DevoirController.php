<?php

namespace App\Http\Controllers\Prof;

use App\Http\Controllers\Controller;
use App\Models\Devoir;
use App\Models\Cours;
use App\Models\Enseignant;
use Illuminate\Http\Request;
use App\Helpers\NotificationHelper;

class DevoirController extends Controller
{
    public function index()
    {
        $enseignant = Enseignant::where('email', auth()->user()->email)->firstOrFail();
        
        $devoirs = Devoir::with(['cours.matiere', 'cours.classe'])
            ->whereHas('cours', function($query) use ($enseignant) {
                $query->where('enseignant_id', $enseignant->id);
            })
            ->orderBy('date_limite', 'desc')
            ->paginate(15);
        
        return view('prof.devoirs.index', compact('devoirs'));
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
        
        return view('prof.devoirs.create', compact('cours'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cours_id' => 'required|exists:cours,id',
            'titre' => 'required|string|max:200',
            'description' => 'required|string',
            'date_limite' => 'required|date|after:today'
        ]);

        // Vérifier que le cours appartient au professeur
        $enseignant = Enseignant::where('email', auth()->user()->email)->firstOrFail();
        $cours = Cours::where('id', $validated['cours_id'])
            ->where('enseignant_id', $enseignant->id)
            ->firstOrFail();

        $devoir = Devoir::create($validated);

        // Notifier l'admin
        $admins = \App\Models\User::whereHas('role', function($q) {
            $q->where('nom_role', 'Admin');
        })->get();
        
        foreach ($admins as $admin) {
            NotificationHelper::envoyer(
                $admin->id,
                'Nouveau devoir créé',
                'Le professeur ' . $enseignant->prenom . ' ' . $enseignant->nom . ' a créé un devoir en ' . 
                $cours->matiere->nom_matiere
            );
        }

        // Notifier tous les élèves de la classe
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
                'Nouveau devoir : ' . $devoir->titre,
                'Un devoir a été programmé en ' . $cours->matiere->nom_matiere . ' pour le ' . 
                \Carbon\Carbon::parse($devoir->date_limite)->format('d/m/Y')
            );
        }

        return redirect()->route('prof.devoirs.index')
            ->with('success', 'Devoir programmé avec succès');
    }

    public function show(Devoir $devoir)
    {
        // Vérifier que le devoir appartient au professeur
        $enseignant = Enseignant::where('email', auth()->user()->email)->firstOrFail();
        
        if ($devoir->cours->enseignant_id !== $enseignant->id) {
            abort(403, 'Action non autorisée');
        }

        $devoir->load(['cours.matiere', 'cours.classe']);
        
        return view('prof.devoirs.show', compact('devoir'));
    }

    public function edit(Devoir $devoir)
    {
        // Vérifier que le devoir appartient au professeur
        $enseignant = Enseignant::where('email', auth()->user()->email)->firstOrFail();
        
        if ($devoir->cours->enseignant_id !== $enseignant->id) {
            abort(403, 'Action non autorisée');
        }

        $cours = Cours::with(['matiere', 'classe'])
            ->where('enseignant_id', $enseignant->id)
            ->whereHas('annee', function($q) {
                $q->where('est_active', true);
            })
            ->get();
        
        return view('prof.devoirs.edit', compact('devoir', 'cours'));
    }

    public function update(Request $request, Devoir $devoir)
    {
        // Vérifier que le devoir appartient au professeur
        $enseignant = Enseignant::where('email', auth()->user()->email)->firstOrFail();
        
        if ($devoir->cours->enseignant_id !== $enseignant->id) {
            abort(403, 'Action non autorisée');
        }

        $validated = $request->validate([
            'titre' => 'required|string|max:200',
            'description' => 'required|string',
            'date_limite' => 'required|date'
        ]);

        $devoir->update($validated);

        return redirect()->route('prof.devoirs.index')
            ->with('success', 'Devoir modifié avec succès');
    }

    public function destroy(Devoir $devoir)
    {
        // Vérifier que le devoir appartient au professeur
        $enseignant = Enseignant::where('email', auth()->user()->email)->firstOrFail();
        
        if ($devoir->cours->enseignant_id !== $enseignant->id) {
            abort(403, 'Action non autorisée');
        }

        $devoir->delete();

        return redirect()->route('prof.devoirs.index')
            ->with('success', 'Devoir supprimé avec succès');
    }
}