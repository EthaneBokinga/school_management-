@extends('layouts.app')

@section('title', 'Gestion des Enseignants')
@section('page-title', 'Gestion des Enseignants')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><i class="fas fa-chalkboard-teacher me-2"></i>Liste des Enseignants</h4>
        <a href="{{ route('admin.enseignants.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nouvel Enseignant
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom Complet</th>
                            <th>Email</th>
                            <th>Spécialité</th>
                            <th>Nombre de Cours</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($enseignants as $enseignant)
                        <tr>
                            <td>{{ $enseignant->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center me-2" 
                                         style="width: 35px; height: 35px;">
                                        <i class="fas fa-chalkboard-teacher text-success"></i>
                                    </div>
                                    <strong>{{ $enseignant->nom_complet }}</strong>
                                </div>
                            </td>
                            <td>{{ $enseignant->email }}</td>
                            <td>
                                <span class="badge bg-info">{{ $enseignant->specialite }}</span>
                            </td>
                            <td>
                                <span class="badge bg-primary rounded-pill">{{ $enseignant->cours_count }}</span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.enseignants.show', $enseignant->id) }}" class="btn btn-info" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.enseignants.edit', $enseignant->id) }}" class="btn btn-warning" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $enseignant->id }})" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                
                                <form id="delete-form-{{ $enseignant->id }}" action="{{ route('admin.enseignants.destroy', $enseignant->id) }}" method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Aucun enseignant enregistré</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $enseignants->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function confirmDelete(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cet enseignant?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush
@endsection