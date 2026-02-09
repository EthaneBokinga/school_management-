@extends('layouts.app')

@section('title', 'Profil Enseignant')
@section('page-title', 'Profil de l\'Enseignant')

@section('content')
<div class="container-fluid">
    <div class="mb-3">
        <a href="{{ route('admin.enseignants.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Retour à la liste
        </a>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <div class="mb-3">
                        <div class="rounded-circle bg-success d-inline-flex align-items-center justify-content-center" 
                             style="width: 120px; height: 120px;">
                            <i class="fas fa-chalkboard-teacher fa-4x text-white"></i>
                        </div>
                    </div>
                    <h4 class="mb-1">{{ $enseignant->nom_complet }}</h4>
                    <p class="text-muted mb-2">{{ $enseignant->email }}</p>
                    <span class="badge bg-info mb-3">{{ $enseignant->specialite }}</span>

                    <hr>

                    <div class="text-start">
                        <p class="mb-2">
                            <i class="fas fa-envelope text-primary me-2"></i>
                            <strong>Email:</strong> {{ $enseignant->email }}
                        </p>
                        <p class="mb-2">
                            <i class="fas fa-book text-primary me-2"></i>
                            <strong>Spécialité:</strong> {{ $enseignant->specialite }}
                        </p>
                        <p class="mb-2">
                            <i class="fas fa-calendar text-primary me-2"></i>
                            <strong>Inscrit le:</strong> {{ $enseignant->created_at->format('d/m/Y') }}
                        </p>
                    </div>

                    <hr>

                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.enseignants.edit', $enseignant->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Modifier
                        </a>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-success text-white">
                    <i class="fas fa-chart-bar me-2"></i>Statistiques
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Cours assignés:</span>
                        <span class="badge bg-primary">{{ $enseignant->cours->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Classes différentes:</span>
                        <span class="badge bg-info">{{ $enseignant->cours->unique('classe_id')->count() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-book me-2"></i>Cours Assignés
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Matière</th>
                                    <th>Classe</th>
                                    <th>Année Scolaire</th>
                                    <th>Coefficient</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($enseignant->cours as $cours)
                                <tr>
                                    <td>
                                        <i class="fas fa-book text-primary me-2"></i>
                                        <strong>{{ $cours->matiere->nom_matiere }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $cours->classe->nom_classe }}</span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $cours->annee->est_active ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $cours->annee->libelle }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $cours->matiere->coefficient }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Aucun cours assigné</td>
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