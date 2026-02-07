@extends('layouts.app')

@section('title', 'Détails Classe')
@section('page-title', 'Détails de la Classe')

@section('content')
<div class="container-fluid">
    <div class="mb-3">
        <a href="{{ route('admin.classes.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Retour
        </a>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-info-circle me-2"></i>Informations de la Classe
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th>Nom:</th>
                            <td>{{ $classe->nom_classe }}</td>
                        </tr>
                        <tr>
                            <th>Niveau:</th>
                            <td><span class="badge bg-info">{{ $classe->niveau }}</span></td>
                        </tr>
                        <tr>
                            <th>Frais:</th>
                            <td>{{ number_format($classe->frais_scolarite, 0, ',', ' ') }} FCFA</td>
                        </tr>
                        <tr>
                            <th>Élèves:</th>
                            <td><span class="badge bg-primary">{{ $inscriptions->count() }}</span></td>
                        </tr>
                    </table>

                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.classes.edit', $classe->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Modifier
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-users me-2"></i>Liste des Élèves
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Matricule</th>
                                    <th>Nom Complet</th>
                                    <th>Sexe</th>
                                    <th>Statut Paiement</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($inscriptions as $inscription)
                                <tr>
                                    <td>{{ $inscription->etudiant->matricule }}</td>
                                    <td>{{ $inscription->etudiant->nom_complet }}</td>
                                    <td>
                                        <i class="fas fa-{{ $inscription->etudiant->sexe == 'M' ? 'mars text-primary' : 'venus text-danger' }}"></i>
                                    </td>
                                    <td>
                                        <span class="badge 
                                            {{ $inscription->statut_paiement == 'Réglé' ? 'bg-success' : '' }}
                                            {{ $inscription->statut_paiement == 'Partiel' ? 'bg-warning' : '' }}
                                            {{ $inscription->statut_paiement == 'En attente' ? 'bg-danger' : '' }}">
                                            {{ $inscription->statut_paiement }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.etudiants.show', $inscription->etudiant->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">Aucun élève inscrit</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection