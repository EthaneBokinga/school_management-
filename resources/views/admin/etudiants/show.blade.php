@extends('layouts.app')

@section('title', 'Profil Étudiant')
@section('page-title', 'Profil de l\'Étudiant')

@section('content')
<div class="container-fluid">
    <div class="mb-3">
        <a href="{{ route('admin.etudiants.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Retour à la liste
        </a>
    </div>

    <!-- En-tête du profil -->
    <div class="row">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <div class="mb-3">
                        <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center" 
                             style="width: 120px; height: 120px;">
                            <i class="fas fa-user-graduate fa-4x text-white"></i>
                        </div>
                    </div>
                    <h4 class="mb-1">{{ $etudiant->nom_complet }}</h4>
                    <p class="text-muted mb-2">{{ $etudiant->matricule }}</p>
                    <span class="badge 
                        {{ $etudiant->statut_actuel == 'Inscrit' ? 'bg-success' : '' }}
                        {{ $etudiant->statut_actuel == 'Diplomé' ? 'bg-info' : '' }}
                        {{ $etudiant->statut_actuel == 'Quitté' ? 'bg-secondary' : '' }} mb-3">
                        {{ $etudiant->statut_actuel }}
                    </span>

                    <hr>

                    <div class="text-start">
                        <p class="mb-2">
                            <i class="fas fa-calendar text-primary me-2"></i>
                            <strong>Né(e) le:</strong> {{ $etudiant->date_naissance ? $etudiant->date_naissance->format('d/m/Y') : '-' }}
                        </p>
                        <p class="mb-2">
                            <i class="fas fa-{{ $etudiant->sexe == 'M' ? 'mars' : 'venus' }} text-primary me-2"></i>
                            <strong>Sexe:</strong> {{ $etudiant->sexe == 'M' ? 'Masculin' : 'Féminin' }}
                        </p>
                        @if($etudiant->date_naissance)
                        <p class="mb-2">
                            <i class="fas fa-birthday-cake text-primary me-2"></i>
                            <strong>Âge:</strong> {{ \Carbon\Carbon::parse($etudiant->date_naissance)->age }} ans
                        </p>
                        @endif
                    </div>

                    <hr>

                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.etudiants.edit', $etudiant->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Modifier
                        </a>
                        <a href="{{ route('admin.etudiants.reinscription', $etudiant->id) }}" class="btn btn-info">
                            <i class="fas fa-redo me-2"></i>Réinscrire
                        </a>
                    </div>
                </div>
            </div>

            <!-- Statistiques rapides -->
            <div class="card mt-3">
                <div class="card-header bg-info text-white">
                    <i class="fas fa-chart-bar me-2"></i>Statistiques
                </div>
                <div class="card-body">
                    @if($etudiant->inscription_active)
                    <div class="d-flex justify-content-between mb-2">
                        <span>Notes enregistrées:</span>
                        <span class="badge bg-primary">{{ $etudiant->inscription_active->notes->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Moyenne générale:</span>
                        <span class="badge bg-success">
                            {{ number_format($etudiant->inscription_active->notes->avg('valeur_note'), 2) }}/20
                        </span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Absences:</span>
                        <span class="badge bg-warning">{{ $etudiant->inscription_active->absences->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Montant payé:</span>
                        <span class="badge bg-info">{{ number_format($etudiant->inscription_active->montant_total_paye, 0, ',', ' ') }} FCFA</span>
                    </div>
                    @else
                    <p class="text-muted text-center mb-0">Aucune inscription active</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <!-- Onglets de navigation -->
            <ul class="nav nav-tabs" id="etudiantTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="inscriptions-tab" data-bs-toggle="tab" data-bs-target="#inscriptions" type="button">
                        <i class="fas fa-clipboard-list me-2"></i>Inscriptions
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="notes-tab" data-bs-toggle="tab" data-bs-target="#notes" type="button">
                        <i class="fas fa-star me-2"></i>Notes
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="absences-tab" data-bs-toggle="tab" data-bs-target="#absences" type="button">
                        <i class="fas fa-user-times me-2"></i>Absences
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="paiements-tab" data-bs-toggle="tab" data-bs-target="#paiements" type="button">
                        <i class="fas fa-money-bill-wave me-2"></i>Paiements
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="etudiantTabsContent">
                <!-- Onglet Inscriptions -->
                <div class="tab-pane fade show active" id="inscriptions" role="tabpanel">
                    <div class="card border-top-0">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Historique des Inscriptions</h5>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Année Scolaire</th>
                                            <th>Classe</th>
                                            <th>Type</th>
                                            <th>Statut Paiement</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($etudiant->inscriptions as $inscription)
                                        <tr>
                                            <td>
                                                <span class="badge {{ $inscription->annee->est_active ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $inscription->annee->libelle }}
                                                </span>
                                            </td>
                                            <td>{{ $inscription->classe->nom_classe }}</td>
                                            <td>
                                                <span class="badge {{ $inscription->type_inscription == 'Nouvelle' ? 'bg-info' : 'bg-primary' }}">
                                                    {{ $inscription->type_inscription }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge 
                                                    {{ $inscription->statut_paiement == 'Réglé' ? 'bg-success' : '' }}
                                                    {{ $inscription->statut_paiement == 'Partiel' ? 'bg-warning' : '' }}
                                                    {{ $inscription->statut_paiement == 'En attente' ? 'bg-danger' : '' }}">
                                                    {{ $inscription->statut_paiement }}
                                                </span>
                                            </td>
                                            <td>{{ $inscription->date_inscription->format('d/m/Y') }}</td>
                                            <td>
                                                <a href="{{ route('admin.inscriptions.show', $inscription->id) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">Aucune inscription</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Onglet Notes -->
                <div class="tab-pane fade" id="notes" role="tabpanel">
                    <div class="card border-top-0">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Notes de l'année en cours</h5>
                            @if($etudiant->inscription_active)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Matière</th>
                                                <th>Type d'Examen</th>
                                                <th>Note</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($etudiant->inscription_active->notes as $note)
                                            <tr>
                                                <td>{{ $note->cours->matiere->nom_matiere }}</td>
                                                <td>{{ $note->typeExamen->libelle ?? '-' }}</td>
                                                <td>
                                                    <span class="badge {{ $note->valeur_note >= 10 ? 'bg-success' : 'bg-danger' }}">
                                                        {{ number_format($note->valeur_note, 2) }}/20
                                                    </span>
                                                </td>
                                                <td>{{ $note->date_saisie->format('d/m/Y') }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">Aucune note enregistrée</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                @if($etudiant->inscription_active->notes->count() > 0)
                                <div class="alert alert-info mt-3">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Moyenne générale:</strong> 
                                    {{ number_format($etudiant->inscription_active->notes->avg('valeur_note'), 2) }}/20
                                </div>
                                @endif
                            @else
                                <p class="text-muted">Aucune inscription active</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Onglet Absences -->
                <div class="tab-pane fade" id="absences" role="tabpanel">
                    <div class="card border-top-0">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Absences de l'année en cours</h5>
                            @if($etudiant->inscription_active)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Cours</th>
                                                <th>Justifiée</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($etudiant->inscription_active->absences as $absence)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($absence->date_absence)->format('d/m/Y') }}</td>
                                                <td>{{ $absence->cours->matiere->nom_matiere ?? 'Non spécifié' }}</td>
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
                                                <td colspan="3" class="text-center text-muted">Aucune absence enregistrée</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                @if($etudiant->inscription_active->absences->count() > 0)
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="alert alert-warning">
                                            <strong>Total absences:</strong> {{ $etudiant->inscription_active->absences->count() }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="alert alert-danger">
                                            <strong>Non justifiées:</strong> {{ $etudiant->inscription_active->absences->where('est_justifie', false)->count() }}
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @else
                                <p class="text-muted">Aucune inscription active</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Onglet Paiements -->
                <div class="tab-pane fade" id="paiements" role="tabpanel">
                    <div class="card border-top-0">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Historique des Paiements</h5>
                            @if($etudiant->inscription_active)
                                <!-- Résumé des paiements -->
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <div class="card bg-primary text-white">
                                            <div class="card-body">
                                                <h6 class="card-title">Frais de Scolarité</h6>
                                                <h4>{{ number_format($etudiant->inscription_active->classe->frais_scolarite, 0, ',', ' ') }} FCFA</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card bg-success text-white">
                                            <div class="card-body">
                                                <h6 class="card-title">Montant Payé</h6>
                                                <h4>{{ number_format($etudiant->inscription_active->montant_total_paye, 0, ',', ' ') }} FCFA</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card bg-{{ $etudiant->inscription_active->reste_a_payer_total > 0 ? 'danger' : 'info' }} text-white">
                                            <div class="card-body">
                                                <h6 class="card-title">Reste à Payer</h6>
                                                <h4>{{ number_format($etudiant->inscription_active->reste_a_payer_total, 0, ',', ' ') }} FCFA</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Liste des paiements -->
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Montant Payé</th>
                                                <th>Reste à Payer</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($etudiant->inscription_active->paiements as $paiement)
                                            <tr>
                                                <td>{{ $paiement->date_paiement->format('d/m/Y H:i') }}</td>
                                                <td>
                                                    <span class="badge bg-success">
                                                        {{ number_format($paiement->montant_paye, 0, ',', ' ') }} FCFA
                                                    </span>
                                                </td>
                                                <td>{{ number_format($paiement->reste_a_payer, 0, ',', ' ') }} FCFA</td>
                                                <td>
                                                    <a href="{{ route('admin.paiements.show', $paiement->id) }}" class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">Aucun paiement enregistré</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Bouton d'ajout de paiement -->
                                <div class="text-end mt-3">
                                    <a href="{{ route('admin.paiements.create') }}?inscription_id={{ $etudiant->inscription_active->id }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Ajouter un Paiement
                                    </a>
                                </div>
                            @else
                                <p class="text-muted">Aucune inscription active</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection