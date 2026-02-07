<?php

namespace App\Http\Controllers\Prof;

use App\Http\Controllers\Controller;
use App\Models\Enseignant;
use App\Models\Cours;
use App\Models\AnneeScolaire;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $enseignant = Enseignant::find($user->reference_id);
        $anneeActive = AnneeScolaire::where('est_active', true)->first();
        
        // Mes cours
        $mesCours = Cours::with(['classe', 'matiere'])
            ->where('enseignant_id', $enseignant->id)
            ->where('annee_id', $anneeActive->id)
            ->get();
        
        // Statistiques
        $totalCours = $mesCours->count();
        $totalClasses = $mesCours->unique('classe_id')->count();
        
        // Devoirs à venir
        $devoirsAVenir = [];
        foreach ($mesCours as $cours) {
            $devoirs = $cours->devoirs()
                ->where('date_limite', '>=', now())
                ->latest('date_limite')
                ->limit(3)
                ->get();
            
            foreach ($devoirs as $devoir) {
                $devoirsAVenir[] = $devoir;
            }
        }
        
        return view('prof.dashboard', compact(
            'enseignant',
            'mesCours',
            'totalCours',
            'totalClasses',
            'devoirsAVenir',
            'anneeActive'
        ));
    }
}