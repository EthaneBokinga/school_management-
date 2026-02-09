@extends('layouts.app')

@section('title', 'Détails Inscription')
@section('page-title', 'Détails de l\'Inscription')

@section('content')
<div class="container-fluid">
    <div class="mb-3">
        <a href="{{ route('admin.inscriptions.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Retour
        </a>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-info-circle me-2"></i>Informations Générales
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th>Étudiant:</th>
                            <td>
                                <strong>{{ $inscription->etudiant->nom_complet }}</strong>
                                <br>
                                <small class="text-muted">{{ $inscription->etudiant->matricule }}</small>
                            </td>
                        </tr>
                        <tr>
                            <th>Classe:</th>
                            <td>
                                <span class="badge bg-info">{{ $inscription->classe->nom_classe }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Année:</th>
                            <td>
                                <span class="badge {{ $inscription->annee->est_active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $inscription->annee->libelle }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Type:</th>
                            <td>
                                <span class="badge {{ $inscription->type_inscription == 'Nouvelle' ? 'bg-success' : 'bg-primary' }}">
                                    {{ $inscription->type_inscription }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Date:</th>
                            <td>{{ $inscription->date_inscription->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <th>Statut Paiement:</th>
                            <td>
                                <span class="badge 
                                    {{ $inscription->statut_paiement == 'Réglé' ? 'bg-success' : '' }}
                                    {{ $inscription->statut_paiement == 'Partiel' ? 'bg-warning' : '' }}
                                    {{ $inscription->statut_paiement == 'En attente' ? 'bg-danger' : '' }}">
                                    {{ $inscription->statut_paiement }}
                                </span>
                            </td>
                        </tr>
                    </table>

                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.inscriptions.edit', $inscription->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Modifier
                        </a>
                        <a href="{{ route('admin.inscriptions.paiements', $inscription->id) }}" class="btn btn-success">
                            <i class="fas fa-money-bill-wave me-2"></i>Gérer les Paiements
                        </a>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-info text-white">
                    <i class="fas fa-money-check-alt me-2"></i>Situation Financière
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <small class="text-muted">Frais de scolarité:</small>
                        <h5 class="mb-0">{{ number_format($inscription->classe->frais_scolarite, 0, ',', ' ') }} FCFA</h5>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Montant payé:</small>
                        <h5 class="mb-0 text-success">{{ number_format($inscription->montant_total_paye, 0, ',', ' ') }} FCFA</h5>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Reste à payer:</small>
                        <h5 class="mb-0 {{ $inscription->reste_a_payer_total > 0 ? 'text-danger' : 'text-success' }}">
                            {{ number_format($inscription->reste_a_payer_total, 0, ',', ' ') }} FCFA
                        </h5>
                    </div>

                    <div class="progress mt-3" style="height: 25px;">
                        <div class="progress-bar {{ $inscription->reste_a_payer_total == 0 ? 'bg-success' : 'bg-warning' }}" 
                             style="width: {{ ($inscription->montant_total_paye / $inscription->classe->frais_scolarite) * 100 }}%">
                            {{ round(($inscription->montant_total_paye / $inscription->classe->frais_scolarite) * 100) }}%
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <!-- Onglets -->
            <ul class="nav nav-tabs" id="inscriptionTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="paiements-tab" data-bs-toggle="tab" data-bs-target="#paiements" type="button">
                        <i class="fas fa-money-bill-wave me-2"></i>Paiements
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
            </ul>

            <div class="tab-content" id="inscriptionTabsContent">
                <!-- Onglet Paiements -->
                <div class="tab-pane fade show active" id="paiements" role="tabpanel">
                    <div class="card border-top-0">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>Historique des Paiements</span>
                            <a href="{{ route('admin.paiements.create') }}?inscription_id={{ $inscription->id }}" class="btn btn-sm btn-success">
                                <i class="fas fa-plus me-1"></i>Ajouter
                            </a>
                        </div>
                        <div class="card-body">
                            @if($inscription->paiements->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Montant Payé</th>
                                            <th>Reste</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($inscription->paiements as $paiement)
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
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <p class="text-muted text-center py-3">Aucun paiement enregistré</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Onglet Notes -->
                <div class="tab-pane fade" id="notes" role="tabpanel">
                    <div class="card border-top-0">
                        <div class="card-header">
                            <i class="fas fa-chart-line me-2"></i>Notes et Résultats
                        </div>
                        <div class="card-body">
                            @if($inscription->notes->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Matière</th>
                                            <th>Type</th>
                                            <th>Note</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($inscription->notes as $note)
                                        <tr>
                                            <td>{{ $note->cours->matiere->nom_matiere }}</td>
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

                            <div class="alert alert-info mt-3">
                                <strong>Moyenne générale:</strong> 
                                {{ number_format($inscription->notes->avg('valeur_note'), 2) }}/20
                            </div>
                            @else
                            <p class="text-muted text-center py-3">Aucune note enregistrée</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Onglet Absences -->
                <div class="tab-pane fade" id="absences" role="tabpanel">
                    <div class="card border-top-0">
                        <div class="card-header">
                            <i class="fas fa-calendar-times me-2"></i>Historique des Absences
                        </div>
                        <div class="card-body">
                            @if($inscription->absences->count() > 0)
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="alert alert-warning">
                                        <strong>Total:</strong> {{ $inscription->absences->count() }} absence(s)
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="alert alert-danger">
                                        <strong>Non justifiées:</strong> {{ $inscription->absences->where('est_justifie', false)->count() }}
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Cours</th>
                                            <th>Statut</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($inscription->absences as $absence)
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
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <p class="text-muted text-center py-3">Aucune absence enregistrée</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection