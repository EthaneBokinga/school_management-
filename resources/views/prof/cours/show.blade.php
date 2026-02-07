@extends('layouts.app')

@section('title', 'Détails du Cours')
@section('page-title', 'Détails du Cours')

@section('content')
<div class="container-fluid">
    <div class="mb-3">
        <a href="{{ route('prof.cours.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Retour à mes cours
        </a>
    </div>

    <!-- En-tête du cours -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-1">{{ $cours->matiere->nom_matiere }}</h3>
                            <p class="mb-0 opacity-75">
                                <i class="fas fa-school me-2"></i>{{ $cours->classe->nom_classe }}
                                <span class="mx-2">•</span>
                                <i class="fas fa-certificate me-2"></i>Coefficient {{ $cours->matiere->coefficient }}
                            </p>
                        </div>
                        <div class="col-auto">
                            <div class="rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center" 
                                 style="width: 80px; height: 80px;">
                                <i class="fas fa-book-open fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Onglets -->
    <ul class="nav nav-tabs" id="coursTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="eleves-tab" data-bs-toggle="tab" data-bs-target="#eleves" type="button">
                <i class="fas fa-users me-2"></i>Élèves ({{ $cours->classe->inscriptions->count() }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="emploi-tab" data-bs-toggle="tab" data-bs-target="#emploi" type="button">
                <i class="fas fa-calendar-alt me-2"></i>Emploi du Temps
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="devoirs-tab" data-bs-toggle="tab" data-bs-target="#devoirs" type="button">
                <i class="fas fa-tasks me-2"></i>Devoirs
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="ressources-tab" data-bs-toggle="tab" data-bs-target="#ressources" type="button">
                <i class="fas fa-file-alt me-2"></i>Ressources
            </button>
        </li>
    </ul>

    <div class="tab-content" id="coursTabsContent">
        <!-- Onglet Élèves -->
        <div class="tab-pane fade show active" id="eleves" role="tabpanel">
            <div class="card border-top-0">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Liste des Élèves</span>
                    <div>
                        <a href="{{ route('prof.notes.create', $cours->id) }}" class="btn btn-sm btn-success">
                            <i class="fas fa-star me-1"></i>Saisir Notes
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Matricule</th>
                                    <th>Nom Complet</th>
                                    <th>Sexe</th>
                                    <th>Statut Paiement</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cours->classe->inscriptions as $inscription)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $inscription->etudiant->matricule }}</td>
                                    <td>
                                        <strong>{{ $inscription->etudiant->nom_complet }}</strong>
                                    </td>
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
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Aucun élève inscrit</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Onglet Emploi du Temps -->
        <div class="tab-pane fade" id="emploi" role="tabpanel">
            <div class="card border-top-0">
                <div class="card-header">
                    <i class="fas fa-calendar-week me-2"></i>Créneaux Horaires
                </div>
                <div class="card-body">
                    @if($cours->emploisDuTemps->count() > 0)
                    <div class="row">
                        @foreach($cours->emploisDuTemps as $emploi)
                        <div class="col-md-6 mb-3">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title text-primary">
                                        <i class="fas fa-calendar-day me-2"></i>{{ $emploi->jour_semaine }}
                                    </h6>
                                    <p class="mb-1">
                                        <i class="fas fa-clock me-2"></i>
                                        <strong>{{ date('H:i', strtotime($emploi->heure_debut)) }}</strong> - 
                                        <strong>{{ date('H:i', strtotime($emploi->heure_fin)) }}</strong>
                                    </p>
                                    <p class="mb-0">
                                        <i class="fas fa-door-open me-2"></i>{{ $emploi->salle->nom_salle ?? 'Salle non définie' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-muted text-center py-3">Aucun créneau horaire défini</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Onglet Devoirs -->
        <div class="tab-pane fade" id="devoirs" role="tabpanel">
            <div class="card border-top-0">
                <div class="card-header">
                    <i class="fas fa-clipboard-list me-2"></i>Liste des Devoirs
                </div>
                <div class="card-body">
                    @if($cours->devoirs->count() > 0)
                    <div class="list-group">
                        @foreach($cours->devoirs as $devoir)
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">{{ $devoir->titre }}</h6>
                                    <p class="mb-1 text-muted">{{ $devoir->description }}</p>
                                    <small class="text-danger">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        Date limite: {{ \Carbon\Carbon::parse($devoir->date_limite)->format('d/m/Y') }}
                                    </small>
                                </div>
                                <span class="badge bg-{{ \Carbon\Carbon::parse($devoir->date_limite)->isPast() ? 'secondary' : 'success' }}">
                                    {{ \Carbon\Carbon::parse($devoir->date_limite)->isPast() ? 'Terminé' : 'En cours' }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-muted text-center py-3">Aucun devoir enregistré</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Onglet Ressources -->
        <div class="tab-pane fade" id="ressources" role="tabpanel">
            <div class="card border-top-0">
                <div class="card-header">
                    <i class="fas fa-folder-open me-2"></i>Ressources Pédagogiques
                </div>
                <div class="card-body">
                    @if($cours->ressources->count() > 0)
                    <div class="list-group">
                        @foreach($cours->ressources as $ressource)
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-file-pdf text-danger me-2"></i>
                                    <strong>{{ $ressource->titre }}</strong>
                                </div>
                                <a href="{{ $ressource->url_fichier }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                    <i class="fas fa-download me-1"></i>Télécharger
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-muted text-center py-3">Aucune ressource disponible</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
}
</style>
@endsection