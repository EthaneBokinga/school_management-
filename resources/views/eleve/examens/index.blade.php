@extends('layouts.app')

@section('title', 'Mes Examens')
@section('page-title', 'Calendrier des Examens')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <div class="card bg-gradient-danger text-white">
            <div class="card-body">
                <h4 class="mb-0"><i class="fas fa-file-alt me-2"></i>Calendrier des Examens</h4>
                <p class="mb-0 opacity-75">
                    {{ $inscription->classe->nom_classe }} - {{ $inscription->annee->libelle }}
                </p>
            </div>
        </div>
    </div>

    <!-- Examens à venir -->
    <div class="mb-4">
        <h5 class="mb-3">
            <i class="fas fa-calendar-check text-danger me-2"></i>Examens à Venir
            <span class="badge bg-danger ms-2">{{ $examensAVenir->count() }}</span>
        </h5>

        @if($examensAVenir->count() > 0)
        <div class="row">
            @foreach($examensAVenir as $examen)
            <div class="col-md-6 mb-3">
                <div class="card border-{{ $examen->isAujourdhui() ? 'warning' : 'danger' }} h-100">
                    <div class="card-header bg-{{ $examen->isAujourdhui() ? 'warning' : 'danger' }} text-white">
                        <div class="d-flex justify-content-between align-items-start">
                            <h6 class="mb-0">{{ $examen->titre }}</h6>
                            @if($examen->isAujourdhui())
                                <span class="badge bg-light text-dark">
                                    <i class="fas fa-exclamation-triangle text-warning"></i> AUJOURD'HUI !
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-6">
                                <p class="mb-1">
                                    <i class="fas fa-book text-primary me-2"></i>
                                    <strong>{{ $examen->cours->matiere->nom_matiere }}</strong>
                                </p>
                                <p class="mb-0 small text-muted">
                                    <i class="fas fa-user me-1"></i>
                                    {{ $examen->cours->enseignant->nom_complet }}
                                </p>
                            </div>
                            <div class="col-6 text-end">
                                <span class="badge bg-info">{{ $examen->typeExamen->libelle }}</span>
                            </div>
                        </div>

                        @if($examen->description)
                        <div class="mb-3">
                            <strong>Chapitres concernés:</strong>
                            <p class="mb-0 small text-muted">{{ Str::limit($examen->description, 100) }}</p>
                        </div>
                        @endif

                        <div class="row">
                            <div class="col-6">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-calendar text-danger me-2"></i>
                                    <strong>{{ $examen->date_examen->format('d/m/Y') }}</strong>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-clock text-primary me-2"></i>
                                    <span>{{ date('H:i', strtotime($examen->heure_debut)) }} - {{ date('H:i', strtotime($examen->heure_fin)) }}</span>
                                </div>
                            </div>
                            <div class="col-6 text-end">
                                @if($examen->salle)
                                <div class="mb-2">
                                    <i class="fas fa-door-open text-success me-1"></i>
                                    <strong>{{ $examen->salle->nom_salle }}</strong>
                                </div>
                                @endif
                                <div>
                                    <span class="badge bg-{{ $examen->isAujourdhui() ? 'warning' : 'info' }}">
                                        {{ $examen->isAujourdhui() ? "C'est aujourd'hui !" : $examen->date_examen->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            Aucun examen programmé pour le moment.
        </div>
        @endif
    </div>

    <!-- Examens passés -->
    <div>
        <h5 class="mb-3">
            <i class="fas fa-history text-secondary me-2"></i>Examens Passés
            <span class="badge bg-secondary ms-2">{{ $examensPasses->count() }}</span>
        </h5>

        @if($examensPasses->count() > 0)
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Titre</th>
                                <th>Type</th>
                                <th>Matière</th>
                                <th>Salle</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($examensPasses->take(10) as $examen)
                            <tr>
                                <td>{{ $examen->date_examen->format('d/m/Y') }}</td>
                                <td>{{ $examen->titre }}</td>
                                <td>
                                    <span class="badge bg-secondary">{{ $examen->typeExamen->libelle }}</span>
                                </td>
                                <td>{{ $examen->cours->matiere->nom_matiere }}</td>
                                <td>{{ $examen->salle->nom_salle ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @else
        <div class="alert alert-secondary">
            Aucun examen passé.
        </div>
        @endif
    </div>
</div>

<style>
.bg-gradient-danger {
    background: linear-gradient(135deg, #e74a3b 0%, #be2617 100%);
}
</style>
@endsection