@extends('layouts.app')

@section('title', 'Gestion des Paiements')
@section('page-title', 'Gestion des Paiements')

@section('content')
<div class="container-fluid">
    <!-- En-tête avec statistiques -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card stat-card success h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Collecté
                            </div>
                            <div class="h5 mb-0 font-weight-bold">{{ number_format($totalPaye, 0, ',', ' ') }} FCFA</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card stat-card danger h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Reste à Collecter
                            </div>
                            <div class="h5 mb-0 font-weight-bold">{{ number_format($totalReste, 0, ',', ' ') }} FCFA</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions et filtres -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><i class="fas fa-money-bill-wave me-2"></i>Liste des Paiements - {{ $anneeActive->libelle }}</h4>
        <div>
            <a href="{{ route('admin.paiements.export') }}" class="btn btn-success me-2">
                <i class="fas fa-file-pdf me-2"></i>Exporter PDF
            </a>
            <a href="{{ route('admin.paiements.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Nouveau Paiement
            </a>
        </div>
    </div>

    <!-- Liste des paiements -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Étudiant</th>
                            <th>Classe</th>
                            <th>Montant Payé</th>
                            <th>Reste à Payer</th>
                            <th>Date de Paiement</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($paiements as $paiement)
                        <tr>
                            <td>{{ $paiement->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center me-2" 
                                         style="width: 35px; height: 35px;">
                                        <i class="fas fa-user text-primary"></i>
                                    </div>
                                    <div>
                                        <strong>{{ $paiement->inscription->etudiant->nom_complet }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $paiement->inscription->etudiant->matricule }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $paiement->inscription->classe->nom_classe }}</span>
                            </td>
                            <td>
                                <span class="badge bg-success fs-6">
                                    {{ number_format($paiement->montant_paye, 0, ',', ' ') }} FCFA
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $paiement->reste_a_payer > 0 ? 'bg-danger' : 'bg-success' }} fs-6">
                                    {{ number_format($paiement->reste_a_payer, 0, ',', ' ') }} FCFA
                                </span>
                            </td>
                            <td>{{ $paiement->date_paiement->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.paiements.show', $paiement->id) }}" class="btn btn-info" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.paiements.edit', $paiement->id) }}" class="btn btn-warning" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $paiement->id }})" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                
                                <form id="delete-form-{{ $paiement->id }}" action="{{ route('admin.paiements.destroy', $paiement->id) }}" method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Aucun paiement enregistré</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $paiements->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function confirmDelete(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce paiement? Cette action est irréversible.')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush
@endsection