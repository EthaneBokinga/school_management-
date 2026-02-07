@extends('layouts.app')

@section('title', 'Gestion des Étudiants')
@section('page-title', 'Gestion des Étudiants')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><i class="fas fa-user-graduate me-2"></i>Liste des Étudiants</h4>
        <a href="{{ route('admin.etudiants.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nouvel Étudiant
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Matricule</th>
                            <th>Nom Complet</th>
                            <th>Date de Naissance</th>
                            <th>Sexe</th>
                            <th>Classe Actuelle</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($etudiants as $etudiant)
                        <tr>
                            <td><strong>{{ $etudiant->matricule }}</strong></td>
                            <td>{{ $etudiant->nom_complet }}</td>
                            <td>{{ $etudiant->date_naissance ? $etudiant->date_naissance->format('d/m/Y') : '-' }}</td>
                            <td>
                                <i class="fas fa-{{ $etudiant->sexe == 'M' ? 'mars text-primary' : 'venus text-danger' }}"></i>
                                {{ $etudiant->sexe == 'M' ? 'Garçon' : 'Fille' }}
                            </td>
                            <td>
                                @if($etudiant->inscription_active)
                                    <span class="badge bg-info">{{ $etudiant->inscription_active->classe->nom_classe }}</span>
                                @else
                                    <span class="text-muted">Non inscrit</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge 
                                    {{ $etudiant->statut_actuel == 'Inscrit' ? 'bg-success' : '' }}
                                    {{ $etudiant->statut_actuel == 'Diplomé' ? 'bg-info' : '' }}
                                    {{ $etudiant->statut_actuel == 'Quitté' ? 'bg-secondary' : '' }}">
                                    {{ $etudiant->statut_actuel }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.etudiants.show', $etudiant->id) }}" class="btn btn-info" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.etudiants.edit', $etudiant->id) }}" class="btn btn-warning" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $etudiant->id }})" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                
                                <form id="delete-form-{{ $etudiant->id }}" action="{{ route('admin.etudiants.destroy', $etudiant->id) }}" method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Aucun étudiant enregistré</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $etudiants->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function confirmDelete(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cet étudiant? Cette action est irréversible.')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush
@endsection