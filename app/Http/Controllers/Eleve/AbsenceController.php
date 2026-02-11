<?php

namespace App\Http\Controllers\Eleve;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use App\Models\Inscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AbsenceController extends Controller
{
    public function index()
    {
        if (!session('inscription_selectionnee')) {
            return redirect()->route('eleve.selection-annee');
        }

        $inscription = Inscription::with(['classe', 'annee'])->findOrFail(session('inscription_selectionnee'));
        
        $absences = Absence::with(['cours.matiere'])
            ->where('inscription_id', $inscription->id)
            ->orderBy('date_absence', 'desc')
            ->get();
        
        $totalAbsences = $absences->count();
        $absencesJustifiees = $absences->where('est_justifie', true)->count();
        $absencesNonJustifiees = $absences->where('est_justifie', false)->count();
        
        return view('eleve.absences.index', compact('absences', 'inscription', 'totalAbsences', 'absencesJustifiees', 'absencesNonJustifiees'));
    }

    public function justifier(Absence $absence)
    {
        // Vérifier que l'absence appartient à l'élève
        if ($absence->inscription_id != session('inscription_selectionnee')) {
            abort(403, 'Action non autorisée');
        }

        return view('eleve.absences.justifier', compact('absence'));
    }

    public function storeJustification(Request $request, Absence $absence)
    {
        // Vérifier que l'absence appartient à l'élève
        if ($absence->inscription_id != session('inscription_selectionnee')) {
            abort(403, 'Action non autorisée');
        }

        $validated = $request->validate([
            'motif_justification' => 'required|string|max:500',
            'fichier_justificatif' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120' // 5MB max
        ]);

        $data = [
            'motif_justification' => $validated['motif_justification'],
        ];

        // Upload du fichier si présent
        if ($request->hasFile('fichier_justificatif')) {
            $file = $request->file('fichier_justificatif');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/justificatifs', $filename);
            
            $data['fichier_justificatif'] = Storage::url($path);
        }

        $absence->update($data);

        return redirect()->route('eleve.absences.index')
            ->with('success', 'Justification envoyée avec succès. En attente de validation.');
    }
}