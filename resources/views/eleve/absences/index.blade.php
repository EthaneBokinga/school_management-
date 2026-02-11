@extends('layouts.app')

@section('title', 'Mes Absences')
@section('page-title', 'Mes Absences')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <div class="card bg-gradient-warning text-white">
            <div class="card-body">
                <h4 class="mb-0"><i class="fas fa-user-times me-2"></i>Mes Absences</h4>
                <p class="mb-0 opacity-75">
                    {{ $inscription->classe->nom_classe }} - {{ $inscription->annee->libelle }}
                </p>
            </div>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card stat-card warning">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Absences</div>
                    <div class="h5 mb-0 font-weight-bold">{{ $totalAbsences }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card success">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Justifiées</div>
                    <div class="h5 mb-0 font-weight-bold">{{ $absencesJustifiees }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card danger">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Non Justifiées</div>
                    <div class="h5 mb-0 font-weight-bold">{{ $absencesNonJustifiees }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des absences -->
    <div class="card">
        <div class="card-header">
            <i class="fas fa-list me-2"></i>Historique de mes Absences
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Cours</th>
                            <th>Statut</th>
                            <th>Justification</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($absences as $absence)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($absence->date_absence)->format('d/m/Y') }}</td>
                            <td>{{ $absence->cours->matiere->nom_matiere ?? 'Non spécifié' }}</td>
                            <td>
                                @if($absence->est_justifie)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i>Justifiée
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times-circle me-1"></i>Non justifiée
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($absence->motif_justification)
                                    <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#motifModal{{ $absence->id }}">
                                        <i class="fas fa-eye"></i> Voir motif
                                    </button>

                                    <!-- Modal motif -->
                                    <div class="modal fade" id="motifModal{{ $absence->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Justification</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($absence->date_absence)->format('d/m/Y') }}</p>
                                                    <p><strong>Motif:</strong></p>
                                                    <p class="text-muted">{{ $absence->motif_justification }}</p>
                                                    
                                                    @if($absence->fichier_justificatif)
                                                    <p><strong>Pièce jointe:</strong></p>
                                                    <a href="{{ $absence->fichier_justificatif }}" class="btn btn-sm btn-primary" download>
                                                        <i class="fas fa-download me-1"></i>Télécharger
                                                    </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if(!$absence->est_justifie && !$absence->motif_justification)
                                    <a href="{{ route('eleve.absences.justifier', $absence->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-file-upload me-1"></i>Justifier
                                    </a>
                                @elseif(!$absence->est_justifie && $absence->motif_justification)
                                    <span class="badge bg-info">En attente de validation</span>
                                @else
                                    <span class="text-success">
                                        <i class="fas fa-check-circle"></i> Validée
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                                <p class="text-muted">Aucune absence enregistrée. Continuez ainsi !</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-warning {
    background: linear-gradient(135deg, #f6c23e 0%, #d4a017 100%);
}
</style>
@endsection