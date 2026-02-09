@extends('layouts.app')

@section('title', 'Détails du Cours')
@section('page-title', 'Détails du Cours')

@section('content')
<div class="container-fluid">
    <div class="mb-3">
        <a href="{{ route('admin.cours.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Retour
        </a>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-info-circle me-2"></i>Informations du Cours
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th>Matière:</th>
                            <td>
                                <strong>{{ $cours->matiere->nom_matiere }}</strong>
                                <br>
                                <small class="text-muted">{{ $cours->matiere->code_matiere }}</small>
                            </td>
                        </tr>
                        <tr>
                            <th>Coefficient:</th>
                            <td><span class="badge bg-primary">{{ $cours->matiere->coefficient }}</span></td>
                        </tr>
                        <tr>
                            <th>Enseignant:</th>
                            <td>{{ $cours->enseignant->nom_complet }}</td>
                        </tr>
                        <tr>
                            <th>Classe:</th>
                            <td><span class="badge bg-info">{{ $cours->classe->nom_classe }}</span></td>
                        </tr>
                        <tr>
                            <th>Année:</th>
                            <td>
                                <span class="badge {{ $cours->annee->est_active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $cours->annee->libelle }}
                                </span>
                            </td>
                        </tr>
                    </table>

                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.cours.edit', $cours->id) }}" class="btn btn-warning">
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
                        <span>Notes saisies:</span>
                        <span class="badge bg-primary">{{ $cours->notes->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Devoirs:</span>
                        <span class="badge bg-warning">{{ $cours->devoirs->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Ressources:</span>
                        <span class="badge bg-info">{{ $cours->ressources->count() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <!-- Onglets -->
            <ul class="nav nav-tabs" id="coursTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="emploi-tab" data-bs-toggle="tab" data-bs-target="#emploi" type="button">
                        <i class="fas fa-calendar-alt me-2"></i>Emploi du Temps
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="notes-tab" data-bs-toggle="tab" data-bs-target="#notes" type="button">
                        <i class="fas fa-star me-2"></i>Notes
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="devoirs-tab" data-bs-toggle="tab" data-bs-target="#devoirs" type="button">
                        <i class="fas fa-tasks me-2"></i>Devoirs
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="ressources-tab" data-bs-toggle="tab" data-bs-target="#ressources" type="button">
                        <i class="fas fa-folder me-2"></i>Ressources
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="coursTabsContent">
                <!-- Onglet Emploi du Temps -->
                <div class="tab-pane fade show active" id="emploi" role="tabpanel">
                    <div class="card border-top-0">
                        <div class="card-header">
                            <i class="fas fa-clock me-2"></i>Créneaux Horaires
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

                <!-- Onglet Notes -->
                <div class="tab-pane fade" id="notes" role="tabpanel">
                    <div class="card border-top-0">
                        <div class="card-header">
                            <i class="fas fa-list me-2"></i>Dernières Notes Saisies
                        </div>
                        <div class="card-body">
                            @if($cours->notes->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th>Élève</th>
                                            <th>Type</th>
                                            <th>Note</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cours->notes->take(10) as $note)
                                        <tr>
                                            <td>{{ $note->inscription->etudiant->nom_complet }}</td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $note->typeExamen->libelle ?? 'N/A' }}</span>
                                            </td>
                                            <td>
                                                <span class="badge {{ $note->valeur_note >= 10 ? 'bg-success' : 'bg-danger' }}">
                                                    {{ number_format($note->valeur_note, 2) }}/20
                                                </span>
                                            </td>
                                            <td>{{ $note->date_saisie->format('d/m/Y') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <p class="text-muted text-center py-3">Aucune note enregistrée</p>
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
                                            <p class="mb-1 text-muted small">{{ $devoir->description }}</p>
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
    </div>
</div>
@endsection