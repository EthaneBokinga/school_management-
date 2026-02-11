@extends('layouts.app')

@section('title', 'Années Scolaires')
@section('page-title', 'Gestion des Années Scolaires')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            <i class="fas fa-calendar-alt me-2"></i>Années Scolaires
        </h4>
        <a href="{{ route('admin.annees.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nouvelle Année
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Libellé</th>
                            <th>Date Début</th>
                            <th>Date Fin</th>
                            <th>Statut</th>
                            <th>Active</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($annees as $annee)
                        <tr>
                            <td><strong>{{ $annee->libelle }}</strong></td>
                            <td>{{ $annee->date_debut->format('d/m/Y') }}</td>
                            <td>{{ $annee->date_fin->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge 
                                    {{ $annee->statut == 'En cours' ? 'bg-success' : '' }}
                                    {{ $annee->statut == 'Terminée' ? 'bg-secondary' : '' }}
                                    {{ $annee->statut == 'À venir' ? 'bg-info' : '' }}">
                                    {{ $annee->statut }}
                                </span>
                            </td>
                            <td>
                                @if($annee->est_active)
                                    <span class="badge bg-success">Oui</span>
                                @else
                                    <span class="badge bg-secondary">Non</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.annees.edit', $annee->id) }}" class="btn btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if(!$annee->est_active)
                                    <form action="{{ route('admin.annees.activer', $annee->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success" title="Activer">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Aucune année scolaire</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection