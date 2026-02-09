@extends('layouts.app')

@section('title', 'Gestion des Cours')
@section('page-title', 'Gestion des Cours')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            <i class="fas fa-book me-2"></i>Liste des Cours - {{ $anneeActive->libelle }}
        </h4>
        <a href="{{ route('admin.cours.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nouveau Cours
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Matière</th>
                            <th>Enseignant</th>
                            <th>Classe</th>
                            <th>Coefficient</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cours as $c)
                        <tr>
                            <td>{{ $c->id }}</td>
                            <td>
                                <i class="fas fa-book text-primary me-2"></i>
                                <strong>{{ $c->matiere->nom_matiere }}</strong>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center me-2" 
                                         style="width: 30px; height: 30px;">
                                        <i class="fas fa-chalkboard-teacher text-success"></i>
                                    </div>
                                    {{ $c->enseignant->nom_complet }}
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $c->classe->nom_classe }}</span>
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $c->matiere->coefficient }}</span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.cours.show', $c->id) }}" class="btn btn-info" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.cours.edit', $c->id) }}" class="btn btn-warning" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $c->id }})" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                
                                <form id="delete-form-{{ $c->id }}" action="{{ route('admin.cours.destroy', $c->id) }}" method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Aucun cours enregistré</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $cours->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function confirmDelete(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce cours?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush
@endsection