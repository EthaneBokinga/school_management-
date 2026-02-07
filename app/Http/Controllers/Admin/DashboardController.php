<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Etudiant;
use App\Models\Enseignant;
use App\Models\Classe;
use App\Models\Inscription;
use App\Models\Paiement;
use App\Models\AnneeScolaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $anneeActive = AnneeScolaire::where('est_active', true)->first();
        
        // Statistiques générales
        $totalEtudiants = Etudiant::where('statut_actuel', 'Inscrit')->count();
        $totalEnseignants = Enseignant::count();
        $totalClasses = Classe::count();
        
        // Inscriptions de l'année active
        $inscriptionsActives = Inscription::where('annee_id', $anneeActive->id)->count();
        
        // Statistiques de paiement
        $paiementsRegle = Inscription::where('annee_id', $anneeActive->id)
            ->where('statut_paiement', 'Réglé')
            ->count();
        
        $paiementsPartiel = Inscription::where('annee_id', $anneeActive->id)
            ->where('statut_paiement', 'Partiel')
            ->count();
        
        $paiementsEnAttente = Inscription::where('annee_id', $anneeActive->id)
            ->where('statut_paiement', 'En attente')
            ->count();
        
        // Montant total collecté
        $montantTotal = Paiement::whereHas('inscription', function($q) use ($anneeActive) {
            $q->where('annee_id', $anneeActive->id);
        })->sum('montant_paye');
        
        // Répartition par classe
        $etudiantsParClasse = Inscription::select('classe_id', DB::raw('count(*) as total'))
            ->where('annee_id', $anneeActive->id)
            ->groupBy('classe_id')
            ->with('classe')
            ->get();
        
        // Dernières inscriptions
        $dernieresInscriptions = Inscription::where('annee_id', $anneeActive->id)
            ->with(['etudiant', 'classe'])
            ->latest()
            ->limit(5)
            ->get();
        
        // Répartition Garçons/Filles
        $repartitionSexe = Inscription::where('annee_id', $anneeActive->id)
            ->join('etudiants', 'inscriptions.etudiant_id', '=', 'etudiants.id')
            ->select('etudiants.sexe', DB::raw('count(*) as total'))
            ->groupBy('etudiants.sexe')
            ->get();

        return view('admin.dashboard', compact(
            'totalEtudiants',
            'totalEnseignants',
            'totalClasses',
            'inscriptionsActives',
            'paiementsRegle',
            'paiementsPartiel',
            'paiementsEnAttente',
            'montantTotal',
            'etudiantsParClasse',
            'dernieresInscriptions',
            'repartitionSexe',
            'anneeActive'
        ));
    }
}