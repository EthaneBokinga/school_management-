@extends('layouts.app')

@section('title', 'Paiements - Inscription')
@section('page-title', 'Gestion des Paiements')

@section('content')
<div class="container-fluid">
    <div class="mb-3">
        <a href="{{ route('admin.inscriptions.show', $inscription->id) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Retour à l'inscription
        </a>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-user me-2"></i>Informations
                </div>
                <div class="card-body">
                    <p class="mb-2">
                        <strong>Étudiant:</strong><br>
                        {{ $inscription->etudiant->nom_complet }}
                    </p>
                    <p class="mb-2">
                        <strong>Matricule:</strong><br>
                        {{ $inscription->etudiant->matricule }}
                    </p>
                    <p class="mb-0">
                        <strong>Classe:</strong><br>
                        <span class="badge bg-info">{{ $inscription->classe->nom_classe }}</span>
                    </p>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-success text-white">
                    <i class="fas fa-calculator me-2"></i>Résumé Financier
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Frais de scolarité:</small>
                        <h4 class="mb-0">{{ number_format($inscription->classe->frais_scolarite, 0, ',', ' ') }} FCFA</h4>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Total payé:</small>
                        <h4 class="mb-0 text-success">{{ number_format($inscription->montant_total_paye, 0, ',', ' ') }} FCFA</h4>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Reste à payer:</small>
                        <h4 class="mb-0 {{ $inscription->reste_a_payer_total > 0 ? 'text-danger' : 'text-success' }}">
                            {{ number_format($inscription->reste_a_payer_total, 0, ',', ' ') }} FCFA
                        </h4>
                    </div>

                    <div class="progress" style="height: 25px;">
                        <div class="progress-bar {{ $inscription->reste_a_payer_total == 0 ? 'bg-success' : 'bg-warning' }}" 
                             style="width: {{ ($inscription->montant_total_paye / $inscription->classe->frais_scolarite) * 100 }}%">
                            {{ round(($inscription->montant_total_paye / $inscription->classe->frais_scolarite) * 100) }}%
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-list me-2"></i>Historique des Paiements</span>
                    <a href="{{ route('admin.paiements.create') }}?inscription_id={{ $inscription->id }}" class="btn btn-sm btn-success">
                        <i class="fas fa-plus me-2"></i>Nouveau Paiement
                    </a>
                </div>
                <div class="card-body">
                    @if($inscription->paiements->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Montant Payé</th>
                                    <th>Reste</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($inscription->paiements as $paiement)
                                <tr>
                                    <td>{{ $paiement->id }}</td>
                                    <td>{{ $paiement->date_paiement->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <span class="badge bg-success fs-6">
                                            {{ number_format($paiement->montant_paye, 0, ',', ' ') }} FCFA
                                        </span>
                                    </td>
                                    <td>{{ number_format($paiement->reste_a_payer, 0, ',', ' ') }} FCFA</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.paiements.show', $paiement->id) }}" class="btn btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.paiements.edit', $paiement->id) }}" class="btn btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">Aucun paiement enregistré</h5>
                        <p class="text-muted">Cliquez sur le bouton ci-dessus pour ajouter un paiement</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection