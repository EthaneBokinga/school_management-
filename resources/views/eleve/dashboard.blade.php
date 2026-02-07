@extends('layouts.app')

@section('title', 'Dashboard Élève')
@section('page-title', 'Mon Tableau de Bord')

@section('content')
<div class="container-fluid">
    @if(!$inscriptionActive)
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle me-2"></i>
            Vous n'avez pas d'inscription active pour cette année scolaire.
        </div>
    @else
    <!-- En-tête de bienvenue -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-1">Bonjour, {{ $etudiant->prenom }} !</h3>
                            <p class="mb-0 opacity-75">
                                <i class="fas fa-graduation-cap me-2"></i>{{ $inscriptionActive->classe->nom_classe }}
                                <span class="mx-2">•</span>
                                <i class="fas fa-id-badge me-2"></i>{{ $etudiant->matricule }}
                            </p>
                        </div>
                        <div class="col-auto">
                            <div class="rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center" 
                                 style="width: 80px; height: 80px;">
                                <i class="fas fa-user-graduate fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques principales -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card success h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Moyenne Générale
                            </div>
                            <div class="h5 mb-0 font-weight-bold">
                                {{ $moyenneGenerale ? number_format($moyenneGenerale, 2) : 'N/A' }}/20
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card primary h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Notes Enregistrées
                            </div>
                            <div class="h5 mb-0 font-weight-bold">{{ $totalNotes }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-star fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card warning h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Absences
                            </div>
                            <div class="h5 mb-0 font-weight-bold">{{ $totalAbsences }}</div>
                            <small class="text-danger">Dont {{ $absencesNonJustifiees }} non justifiées</small>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-times fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card {{ $resteAPayer > 0 ? 'danger' : 'info' }} h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-{{ $resteAPayer > 0 ? 'danger' : 'info' }} text-uppercase mb-1">
                                Reste à Payer
                            </div>
                            <div class="h5 mb-0 font-weight-bold">{{ number_format($resteAPayer, 0, ',', ' ') }}</div>
                            <small class="text-muted">Sur {{ number_format($fraisScolarite, 0, ',', ' ') }} FCFA</small>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="row">
        <!-- Dernières notes -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-star me-2"></i>Mes Dernières Notes</span>
                    <a href="{{ route('eleve.notes.index') }}" class="btn btn-sm btn-primary">
                        Voir toutes <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Matière</th>
                                    <th>Type</th>
                                    <th>Note</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dernieresNotes as $note)
                                <tr>
                                    <td>
                                        <strong>{{ $note->cours->matiere->nom_matiere }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $note->typeExamen->libelle ?? 'N/A' }}</span>
                                    </td>
                                    <td>
                                        <span class="badge fs-6 {{ $note->valeur_note >= 10 ? 'bg-success' : 'bg-danger' }}">
                                            {{ number_format($note->valeur_note, 2) }}/20
                                        </span>
                                    </td>
                                    <td>{{ $note->date_saisie->format('d/m/Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">
                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                        <p class="mb-0">Aucune note enregistrée</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Progression du paiement -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <i class="fas fa-wallet me-2"></i>État des Paiements
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Progression</span>
                            <span class="fw-bold">{{ $fraisScolarite > 0 ? round(($montantPaye / $fraisScolarite) * 100) : 0 }}%</span>
                        </div>
                        <div class="progress" style="height: 25px;">
                            <div class="progress-bar {{ $resteAPayer == 0 ? 'bg-success' : 'bg-warning' }}" 
                                 style="width: {{ $fraisScolarite > 0 ? ($montantPaye / $fraisScolarite) * 100 : 0 }}%">
                            </div>
                        </div>
                    </div>

                    <div class="border-top pt-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Frais totaux:</span>
                            <strong>{{ number_format($fraisScolarite, 0, ',', ' ') }} FCFA</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Déjà payé:</span>
                            <strong class="text-success">{{ number_format($montantPaye, 0, ',', ' ') }} FCFA</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Reste:</span>
                            <strong class="{{ $resteAPayer > 0 ? 'text-danger' : 'text-success' }}">
                                {{ number_format($resteAPayer, 0, ',', ' ') }} FCFA
                            </strong>
                        </div>
                    </div>

                    @if($resteAPayer == 0)
                    <div class="alert alert-success mt-3 mb-0">
                        <i class="fas fa-check-circle me-2"></i>Paiement complet
                    </div>
                    @endif
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-bolt me-2"></i>Accès Rapide
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('eleve.notes.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-star me-2"></i>Mes Notes
                        </a>
                        <a href="{{ route('eleve.emploi.index') }}" class="btn btn-outline-info">
                            <i class="fas fa-calendar-alt me-2"></i>Emploi du Temps
                        </a>
                        <a href="{{ route('eleve.notes.bulletin') }}" class="btn btn-outline-success">
                            <i class="fas fa-file-pdf me-2"></i>Télécharger Bulletin
                        </a>
                        <a href="{{ route('notifications.index') }}" class="btn btn-outline-warning">
                            <i class="fas fa-bell me-2"></i>Mes Notifications
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.stat-card {
    transition: transform 0.2s;
}

.stat-card:hover {
    transform: translateY(-5px);
}
</style>
@endsection