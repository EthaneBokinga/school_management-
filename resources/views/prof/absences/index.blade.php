@extends('layouts.app')

@section('title', 'Mes Absences')
@section('page-title', 'Gestion des Absences')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <i class="fas fa-user-times me-2"></i>Historique des Absences Enregistrées
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Cours</th>
                            <th>Classe</th>
                            <th>Élève</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($absences as $absence)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($absence->date_absence)->format('d/m/Y') }}</td>
                            <td>{{ $absence->cours->matiere->nom_matiere ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-info">{{ $absence->inscription->classe->nom_classe }}</span>
                            </td>
                            <td>{{ $absence->inscription->etudiant->nom_complet }}</td>
                            <td>
                                @if($absence->est_justifie)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check me-1"></i>Justifiée
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times me-1"></i>Non justifiée
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                <p class="mb-0">Aucune absence enregistrée</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $absences->links() }}
            </div>
        </div>
    </div>
</div>
@endsection