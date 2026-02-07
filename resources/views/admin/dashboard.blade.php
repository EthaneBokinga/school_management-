@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Administrateur')

@section('content')
<div class="container-fluid">
    <!-- Statistiques principales -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card primary">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Étudiants Inscrits
                            </div>
                            <div class="h5 mb-0 font-weight-bold">{{ $totalEtudiants }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card success">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Enseignants
                            </div>
                            <div class="h5 mb-0 font-weight-bold">{{ $totalEnseignants }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card info">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Classes
                            </div>
                            <div class="h5 mb-0 font-weight-bold">{{ $totalClasses }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-school fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card warning">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Montant Collecté
                            </div>
                            <div class="h5 mb-0 font-weight-bold">{{ number_format($montantTotal, 0, ',', ' ') }} FCFA</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques de paiement -->
    <div class="row">
        <div class="col-xl-8 mb-4">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Répartition des Étudiants par Classe
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Classe</th>
                                    <th>Niveau</th>
                                    <th>Nombre d'Étudiants</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($etudiantsParClasse as $item)
                                <tr>
                                    <td>{{ $item->classe->nom_classe }}</td>
                                    <td>{{ $item->classe->niveau }}</td>
                                    <td><span class="badge bg-primary">{{ $item->total }}</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-money-check-alt me-1"></i>
                    Statut des Paiements
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Réglé</span>
                            <span class="text-success fw-bold">{{ $paiementsRegle }}</span>
                        </div>
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar bg-success" style="width: {{ ($paiementsRegle / $inscriptionsActives) * 100 }}%"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Partiel</span>
                            <span class="text-warning fw-bold">{{ $paiementsPartiel }}</span>
                        </div>
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar bg-warning" style="width: {{ ($paiementsPartiel / $inscriptionsActives) * 100 }}%"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>En attente</span>
                            <span class="text-danger fw-bold">{{ $paiementsEnAttente }}</span>
                        </div>
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar bg-danger" style="width: {{ ($paiementsEnAttente / $inscriptionsActives) * 100 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <i class="fas fa-venus-mars me-1"></i>
                    Répartition Garçons/Filles
                </div>
                <div class="card-body">
                    @foreach($repartitionSexe as $item)
                    <div class="mb-2">
                        <div class="d-flex justify-content-between">
                            <span>{{ $item->sexe == 'M' ? 'Garçons' : 'Filles' }}</span>
                            <span class="fw-bold">{{ $item->total }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Dernières inscriptions -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-list me-1"></i>
                    Dernières Inscriptions
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Matricule</th>
                                    <th>Nom Complet</th>
                                    <th>Classe</th>
                                    <th>Type</th>
                                    <th>Statut Paiement</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dernieresInscriptions as $inscription)
                                <tr>
                                    <td>{{ $inscription->etudiant->matricule }}</td>
                                    <td>{{ $inscription->etudiant->nom_complet }}</td>
                                    <td>{{ $inscription->classe->nom_classe }}</td>
                                    <td>
                                        <span class="badge {{ $inscription->type_inscription == 'Nouvelle' ? 'bg-info' : 'bg-secondary' }}">
                                            {{ $inscription->type_inscription }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge 
                                            {{ $inscription->statut_paiement == 'Réglé' ? 'bg-success' : '' }}
                                            {{ $inscription->statut_paiement == 'Partiel' ? 'bg-warning' : '' }}
                                            {{ $inscription->statut_paiement == 'En attente' ? 'bg-danger' : '' }}">
                                            {{ $inscription->statut_paiement }}
                                        </span>
                                    </td>
                                    <td>{{ $inscription->date_inscription->format('d/m/Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection