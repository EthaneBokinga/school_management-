@extends('layouts.app')

@section('title', 'Échéances de Paiement')
@section('page-title', 'Échéances de Paiement')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            <i class="fas fa-calendar-check me-2"></i>Gestion des Échéances
        </h4>
        <a href="{{ route('admin.echeances.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nouvelle Échéance
        </a>
    </div>

    <!-- Statistiques rapides -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stat-card danger">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">En Retard</div>
                    <div class="h5 mb-0 font-weight-bold">{{ $echeances->where('statut', 'En attente')->filter(fn($e) => $e->date_limite < now())->count() }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card warning">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">En Attente</div>
                    <div class="h5 mb-0 font-weight-bold">{{ $echeances->where('statut', 'En attente')->count() }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card success">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Payées</div>
                    <div class="h5 mb-0 font-weight-bold">{{ $echeances->where('statut', 'Payé')->count() }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Mois</th>
                            <th>Étudiant</th>
                            <th>Classe</th>
                            <th>Montant</th>
                            <th>Date Limite</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($echeances as $echeance)
                        <tr class="{{ $echeance->isEnRetard() ? 'table-danger' : '' }}">
                            <td><strong>{{ $echeance->mois }}</strong></td>
                            <td>
                                {{ $echeance->inscription->etudiant->nom_complet }}
                                <br>
                                <small class="text-muted">{{ $echeance->inscription->etudiant->matricule }}</small>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $echeance->inscription->classe->nom_classe }}</span>
                            </td>
                            <td>
                                {{ number_format($echeance->montant_echeance, 0, ',', ' ') }} FCFA
                                @if($echeance->montant_paye > 0)
                                    <br>
                                    <small class="text-success">Payé: {{ number_format($echeance->montant_paye, 0, ',', ' ') }} FCFA</small>
                                @endif
                            </td>
                            <td>
                                {{ $echeance->date_limite->format('d/m/Y') }}
                                @if($echeance->isEnRetard())
                                    <br><span class="badge bg-danger">En retard</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge 
                                    {{ $echeance->statut == 'Payé' ? 'bg-success' : '' }}
                                    {{ $echeance->statut == 'En attente' ? 'bg-warning' : '' }}
                                    {{ $echeance->statut == 'En retard' ? 'bg-danger' : '' }}">
                                    {{ $echeance->statut }}
                                </span>
                            </td>
                            <td>
                                @if($echeance->statut !== 'Payé')
                                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#payerModal{{ $echeance->id }}">
                                    <i class="fas fa-money-bill"></i> Payer
                                </button>

                                <!-- Modal de paiement -->
                                <div class="modal fade" id="payerModal{{ $echeance->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Enregistrer un Paiement</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('admin.echeances.payer', $echeance->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <p><strong>Mois:</strong> {{ $echeance->mois }}</p>
                                                    <p><strong>Montant total:</strong> {{ number_format($echeance->montant_echeance, 0, ',', ' ') }} FCFA</p>
                                                    <p><strong>Reste à payer:</strong> {{ number_format($echeance->reste, 0, ',', ' ') }} FCFA</p>
                                                    
                                                    <div class="mb-3">
                                                        <label for="montant_paye" class="form-label">Montant à payer</label>
                                                        <input type="number" class="form-control" name="montant_paye" 
                                                               max="{{ $echeance->reste }}" min="0" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                    <button type="submit" class="btn btn-success">Enregistrer</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <span class="text-success"><i class="fas fa-check-circle"></i> Payé</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Aucune échéance enregistrée</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $echeances->links() }}
            </div>
        </div>
    </div>
</div>
@endsection