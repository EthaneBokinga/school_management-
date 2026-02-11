<?php

namespace App\Http\Controllers\Eleve;

use App\Http\Controllers\Controller;
use App\Models\Etudiant;
use App\Models\Inscription;
use Illuminate\Http\Request;

class SelectionAnneeController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $etudiant = Etudiant::find($user->reference_id);
        
        if (!$etudiant) {
            abort(404, 'Étudiant non trouvé');
        }
        
        // Récupérer toutes les inscriptions de l'étudiant
        $inscriptions = Inscription::with(['annee', 'classe'])
            ->where('etudiant_id', $etudiant->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Si l'étudiant n'a qu'une seule inscription, la sélectionner automatiquement
        if ($inscriptions->count() === 1) {
            session(['inscription_selectionnee' => $inscriptions->first()->id]);
            return redirect()->route('eleve.dashboard');
        }

        return view('eleve.selection-annee', compact('etudiant', 'inscriptions'));
    }

    public function selectionner(Request $request)
    {
        $request->validate([
            'inscription_id' => 'required|exists:inscriptions,id'
        ]);

        // Stocker l'inscription sélectionnée en session
        session(['inscription_selectionnee' => $request->inscription_id]);

        return redirect()->route('eleve.dashboard');
    }
}