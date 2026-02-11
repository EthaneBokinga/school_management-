@extends('layouts.app')

@section('title', 'Mon Emploi du Temps')
@section('page-title', 'Mon Emploi du Temps')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <div class="card bg-gradient-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">{{ $enseignant->nom_complet }}</h4>
                        <p class="mb-0 opacity-75">{{ $enseignant->specialite }}</p>
                    </div>
                    <button class="btn btn-light" onclick="window.print()">
                        <i class="fas fa-print me-2"></i>Imprimer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Vue par jour -->
    @if($emploisParJour->count() > 0)
    <div class="row mb-4">
        @foreach($jours as $jour)
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-calendar-day me-2"></i>{{ $jour }}
                </div>
                <div class="card-body p-0">
                    @if(isset($emploisParJour[$jour]) && $emploisParJour[$jour]->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($emploisParJour[$jour]->sortBy('heure_debut') as $emploi)
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 text-primary">
                                        {{ $emploi->cours->matiere->nom_matiere }}
                                    </h6>
                                    <p class="mb-1 small">
                                        <i class="fas fa-school me-1 text-info"></i>
                                        {{ $emploi->cours->classe->nom_classe }}
                                    </p>
                                    <p class="mb-0 small">
                                        <i class="fas fa-door-open me-1 text-success"></i>
                                        {{ $emploi->salle->nom_salle ?? 'Salle non définie' }}
                                    </p>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-success">
                                        {{ date('H:i', strtotime($emploi->heure_debut)) }}
                                    </span>
                                    <br>
                                    <span class="badge bg-danger mt-1">
                                        {{ date('H:i', strtotime($emploi->heure_fin)) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="p-4 text-center text-muted">
                        <i class="fas fa-coffee fa-2x mb-2"></i>
                        <p class="mb-0">Pas de cours ce jour</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Vue tableau complète -->
    <div class="card">
        <div class="card-header bg-dark text-white">
            <i class="fas fa-table me-2"></i>Vue d'ensemble hebdomadaire
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 120px;">Horaire</th>
                            @foreach($jours as $jour)
                            <th class="text-center">{{ $jour }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $heures = [];
                            foreach($emploisParJour as $jourEmploi => $emplois) {
                                foreach($emplois as $emploi) {
                                    $debut = date('H:i', strtotime($emploi->heure_debut));
                                    $fin = date('H:i', strtotime($emploi->heure_fin));
                                    $creneau = $debut . ' - ' . $fin;
                                    if(!in_array($creneau, $heures)) {
                                        $heures[] = $creneau;
                                    }
                                }
                            }
                            sort($heures);
                        @endphp
                        
                        @foreach($heures as $heure)
                        <tr>
                            <td class="fw-bold bg-light">{{ $heure }}</td>
                            @foreach($jours as $jour)
                            <td class="text-center">
                                @if(isset($emploisParJour[$jour]))
                                    @php
                                        $coursAuCreneau = $emploisParJour[$jour]->first(function($emploi) use ($heure) {
                                            $debut = date('H:i', strtotime($emploi->heure_debut));
                                            $fin = date('H:i', strtotime($emploi->heure_fin));
                                            return ($debut . ' - ' . $fin) == $heure;
                                        });
                                    @endphp
                                    @if($coursAuCreneau)
                                    <div class="p-2 bg-primary bg-opacity-10 rounded">
                                        <strong class="d-block text-primary">
                                            {{ $coursAuCreneau->cours->matiere->nom_matiere }}
                                        </strong>
                                        <small class="d-block text-info">
                                            {{ $coursAuCreneau->cours->classe->nom_classe }}
                                        </small>
                                        <small class="text-muted">
                                            {{ $coursAuCreneau->salle->nom_salle ?? 'N/A' }}
                                        </small>
                                    </div>
                                    @else
                                    <span class="text-muted">-</span>
                                    @endif
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
            <h5 class="text-muted">Aucun emploi du temps disponible</h5>
            <p class="text-muted">Votre emploi du temps n'a pas encore été configuré par l'administration.</p>
        </div>
    </div>
    @endif
</div>

<style>
@media print {
    .sidebar, .navbar, .btn, .card-header {
        display: none !important;
    }
}
</style>
@endsection