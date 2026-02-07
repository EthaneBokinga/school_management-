<?php

namespace App\Http\Controllers\Eleve;

use App\Http\Controllers\Controller;
use App\Models\Etudiant;
use App\Models\AnneeScolaire;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class NoteController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $etudiant = Etudiant::find($user->reference_id);
        $anneeActive = AnneeScolaire::where('est_active', true)->first();
        
        $inscription = $etudiant->inscriptions()
            ->where('annee_id', $anneeActive->id)
            ->with(['classe', 'notes.cours.matiere', 'notes.typeExamen'])
            ->first();
        
        if (!$inscription) {
            return view('eleve.notes.index')->with('error', 'Aucune inscription active trouvée');
        }
        
        // Grouper les notes par matière
        $notesParMatiere = $inscription->notes->groupBy('cours.matiere.nom_matiere');
        
        // Calculer les moyennes par matière
        $moyennesParMatiere = [];
        foreach ($notesParMatiere as $matiere => $notes) {
            $moyennesParMatiere[$matiere] = [
                'moyenne' => $notes->avg('valeur_note'),
                'coefficient' => $notes->first()->cours->matiere->coefficient,
                'notes' => $notes
            ];
        }
        
        // Moyenne générale
        $moyenneGenerale = $inscription->notes->avg('valeur_note');
        
        return view('eleve.notes.index', compact(
            'etudiant',
            'inscription',
            'notesParMatiere',
            'moyennesParMatiere',
            'moyenneGenerale'
        ));
    }

    public function bulletin()
    {
        $user = auth()->user();
        $etudiant = Etudiant::find($user->reference_id);
        $anneeActive = AnneeScolaire::where('est_active', true)->first();
        
        $inscription = $etudiant->inscriptions()
            ->where('annee_id', $anneeActive->id)
            ->with(['classe', 'notes.cours.matiere', 'notes.typeExamen'])
            ->first();
        
        if (!$inscription) {
            return back()->with('error', 'Aucune inscription active trouvée');
        }
        
        // Grouper les notes par matière
        $notesParMatiere = $inscription->notes->groupBy('cours.matiere.nom_matiere');
        
        // Calculer les moyennes par matière
        $moyennesParMatiere = [];
        $totalPoints = 0;
        $totalCoefficients = 0;
        
        foreach ($notesParMatiere as $matiere => $notes) {
            $moyenne = $notes->avg('valeur_note');
            $coefficient = $notes->first()->cours->matiere->coefficient;
            
            $moyennesParMatiere[$matiere] = [
                'moyenne' => $moyenne,
                'coefficient' => $coefficient
            ];
            
            $totalPoints += $moyenne * $coefficient;
            $totalCoefficients += $coefficient;
        }
        
        $moyenneGenerale = $totalCoefficients > 0 ? $totalPoints / $totalCoefficients : 0;
        
        $pdf = Pdf::loadView('eleve.notes.bulletin-pdf', compact(
            'etudiant',
            'inscription',
            'moyennesParMatiere',
            'moyenneGenerale',
            'anneeActive'
        ));
        
        return $pdf->download('bulletin-' . $etudiant->matricule . '.pdf');
    }
}