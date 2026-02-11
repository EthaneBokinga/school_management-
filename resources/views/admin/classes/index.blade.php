@extends('layouts.app')

@section('title', 'Gestion des Classes')
@section('page-title', 'Gestion des Classes')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><i class="fas fa-school me-2"></i>Liste des Classes</h4>
        <!-- Barre de recherche -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control" id="searchClasses" placeholder="Rechercher une classe...">
                </div>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="filterNiveau">
                    <option value="">Tous les niveaux</option>
                    <option value="6ème">6ème</option>
                    <option value="5ème">5ème</option>
                    <option value="4ème">4ème</option>
                    <option value="3ème">3ème</option>
                    <option value="Seconde">Seconde</option>
                    <option value="Première">Première</option>
                    <option value="Terminale">Terminale</option>
                </select>
            </div>
        </div>
    </div>
</div>
        <a href="{{ route('admin.classes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nouvelle Classe
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom de la Classe</th>
                            <th>Niveau</th>
                            <th>Frais de Scolarité</th>
                            <th>Nombre d'Élèves</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($classes as $classe)
                        <tr>
                            <td>{{ $classe->id }}</td>
                            <td>
                                <strong>{{ $classe->nom_classe }}</strong>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $classe->niveau }}</span>
                            </td>
                            <td>{{ number_format($classe->frais_scolarite, 0, ',', ' ') }} FCFA</td>
                            <td>
                                <span class="badge bg-primary rounded-pill">{{ $classe->inscriptions_count }}</span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.classes.show', $classe->id) }}" class="btn btn-info" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.classes.edit', $classe->id) }}" class="btn btn-warning" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $classe->id }})" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                
                                <form id="delete-form-{{ $classe->id }}" action="{{ route('admin.classes.destroy', $classe->id) }}" method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Aucune classe enregistrée</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function confirmDelete(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette classe?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush





@push('scripts')
<script>
// Recherche en temps réel
document.getElementById('searchClasses').addEventListener('keyup', function() {
    filterClasses();
});

document.getElementById('filterNiveau').addEventListener('change', function() {
    filterClasses();
});

function filterClasses() {
    const searchTerm = document.getElementById('searchClasses').value.toLowerCase();
    const niveauFilter = document.getElementById('filterNiveau').value;
    const rows = document.querySelectorAll('tbody tr');

    rows.forEach(row => {
        if (row.cells.length < 2) return; // Skip empty row
        
        const nomClasse = row.cells[1].textContent.toLowerCase();
        const niveau = row.cells[2].textContent.trim();

        const matchSearch = nomClasse.includes(searchTerm);
        const matchNiveau = !niveauFilter || niveau.includes(niveauFilter);

        row.style.display = (matchSearch && matchNiveau) ? '' : 'none';
    });
}
</script>
@endpush
@endsection

