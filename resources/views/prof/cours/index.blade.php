@extends('layouts.app')

@section('title', 'Mes Cours')
@section('page-title', 'Mes Cours')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h4 class="mb-0"><i class="fas fa-book me-2"></i>Mes Cours - {{ $enseignant->nom_complet }}</h4>
        <p class="text-muted">{{ $enseignant->specialite }}</p>
    </div>

    @if($cours->count() > 0)
    <div class="row">
        @foreach($cours as $c)
        <div class="col-lg-6 mb-4">
            <div class="card h-100 cours-card">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-book-open me-2"></i>{{ $c->matiere->nom_matiere }}
                        </h5>
                        <span class="badge bg-light text-primary">Coef: {{ $c->matiere->coefficient }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-muted mb-2">
                            <i class="fas fa-school me-2"></i>Classe
                        </h6>
                        <span class="badge bg-info fs-6">{{ $c->classe->nom_classe }}</span>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-muted mb-2">
                            <i class="fas fa-calendar-alt me-2"></i>Emploi du Temps
                        </h6>
                        @if($c->emploisDuTemps->count() > 0)
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($c->emploisDuTemps as $emploi)
                                <div class="emploi-item">
                                    <small class="badge bg-secondary">
                                        {{ $emploi->jour_semaine }}
                                        {{ date('H:i', strtotime($emploi->heure_debut)) }} - {{ date('H:i', strtotime($emploi->heure_fin)) }}
                                        <br>
                                        <i class="fas fa-door-open"></i> {{ $emploi->salle->nom_salle ?? 'N/A' }}
                                    </small>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted mb-0">
                                <i class="fas fa-exclamation-circle me-1"></i>Non défini
                            </p>
                        @endif
                    </div>

                    <div class="row text-center mt-3 pt-3 border-top">
                        <div class="col-4">
                            <div class="stat-item">
                                <h5 class="text-primary mb-0">{{ $c->classe->inscriptions_count ?? 0 }}</h5>
                                <small class="text-muted">Élèves</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-item">
                                <h5 class="text-success mb-0">{{ $c->notes_count ?? 0 }}</h5>
                                <small class="text-muted">Notes</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-item">
                                <h5 class="text-warning mb-0">{{ $c->devoirs_count ?? 0 }}</h5>
                                <small class="text-muted">Devoirs</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light">
                    <div class="d-grid">
                        <a href="{{ route('prof.cours.show', $c->id) }}" class="btn btn-primary">
                            <i class="fas fa-eye me-2"></i>Voir les Détails
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="fas fa-book-open fa-4x text-muted mb-3"></i>
            <h5 class="text-muted">Aucun cours assigné</h5>
            <p class="text-muted">Vous n'avez pas encore de cours assignés pour cette année scolaire.</p>
        </div>
    </div>
    @endif
</div>

<style>
.cours-card {
    transition: transform 0.2s, box-shadow 0.2s;
}

.cours-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.stat-item h5 {
    font-weight: bold;
}
</style>
@endsection