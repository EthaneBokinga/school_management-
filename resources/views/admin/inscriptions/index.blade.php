@extends('layouts.app')

@section('title', 'Gestion des Inscriptions')
@section('page-title', 'Gestion des Inscriptions')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            <i class="fas fa-clipboard-list me-2"></i>Inscriptions - {{ $anneeActive->libelle }}
        </h4>
        <a href="{{ route('admin.inscriptions.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nouvelle Inscription
        </a>
    </div>

    <!-- Filtres rapides -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" id="searchInput" placeholder="Rechercher un étudiant...">
                    </div>
                </div>
                <div class="col-md-4">
                    <select class="form-select" id="filterClasse">
                        <option value="">Toutes les classes</option>
                        @foreach($inscriptions->unique('classe_id') as $inscription)
                            <option value="{{ $inscription->classe->nom_classe }}">{{ $inscription->classe->nom_classe }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <select class="form-select" id="filterStatut">
                        <option value="">Tous les statuts de paiement</option>
                        <option value="Réglé">Réglé</option>
                        <option value="Partiel">Partiel</option>
                        <option value="En attente">En attente</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des inscriptions -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="inscriptionsTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Étudiant</th>
                            <th>Classe</th>
                            <th>Type</th>
                            <th>Statut Paiement</th>
                            <th>Date Inscription</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inscriptions as $inscription)
                        <tr>
                            <td>{{ $inscription->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center me-2" 
                                         style="width: 35px; height: 35px;">
                                        <i class="fas fa-user-graduate text-primary"></i>
                                    </div>
                                    <div>
                                        <strong>{{ $inscription->etudiant->nom_complet }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $inscription->etudiant->matricule }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $inscription->classe->nom_classe }}</span>
                            </td>
                            <td>
                                <span class="badge {{ $inscription->type_inscription == 'Nouvelle' ? 'bg-success' : 'bg-secondary' }}">
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
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.inscriptions.show', $inscription->id) }}" 
                                       class="btn btn-info" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.inscriptions.edit', $inscription->id) }}" 
                                       class="btn btn-warning" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('admin.inscriptions.paiements', $inscription->id) }}" 
                                       class="btn btn-success" title="Paiements">
                                        <i class="fas fa-money-bill-wave"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger" 
                                            onclick="confirmDelete({{ $inscription->id }})" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                
                                <form id="delete-form-{{ $inscription->id }}" 
                                      action="{{ route('admin.inscriptions.destroy', $inscription->id) }}" 
                                      method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Aucune inscription enregistrée</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $inscriptions->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function confirmDelete(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette inscription?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}

// Filtres en temps réel
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const filterClasse = document.getElementById('filterClasse');
    const filterStatut = document.getElementById('filterStatut');
    const table = document.getElementById('inscriptionsTable');
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const classeFilter = filterClasse.value;
        const statutFilter = filterStatut.value;

        Array.from(rows).forEach(row => {
            if (row.cells.length < 7) return; // Skip empty row
            
            const etudiantText = row.cells[1].textContent.toLowerCase();
            const classeText = row.cells[2].textContent;
            const statutText = row.cells[4].textContent.trim();

            const matchSearch = etudiantText.includes(searchTerm);
            const matchClasse = !classeFilter || classeText.includes(classeFilter);
            const matchStatut = !statutFilter || statutText.includes(statutFilter);

            row.style.display = (matchSearch && matchClasse && matchStatut) ? '' : 'none';
        });
    }

    searchInput.addEventListener('keyup', filterTable);
    filterClasse.addEventListener('change', filterTable);
    filterStatut.addEventListener('change', filterTable);
});
</script>
@endpush
@endsection