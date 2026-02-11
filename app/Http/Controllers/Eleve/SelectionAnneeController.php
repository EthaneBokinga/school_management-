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
        $etudiant = Etudiant::where('email', auth()->user()->email)
            ->orWhereHas('user', function($q) {
                $q->where('id', auth()->id());
            })
            ->firstOrFail();
        
        // Récupérer toutes les inscriptions de l'étudiant
        $inscriptions = Inscription::with(['annee', 'classe'])
            ->where('etudiant_id', $etudiant->id)
            ->orderBy('created_at', 'desc')
            ->get();
        
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