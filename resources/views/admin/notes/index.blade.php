@extends('layouts.app')

@section('title', 'Gestion des Notes')
@section('page-title', 'Gestion des Notes')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            <i class="fas fa-star me-2"></i>Liste des Notes - {{ $anneeActive->libelle }}
        </h4>
        <a href="{{ route('admin.notes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Saisir des Notes
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Étudiant</th>
                            <th>Classe</th>
                            <th>Matière</th>
                            <th>Type</th>
                            <th>Note</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($notes as $note)
                        <tr>
                            <td>{{ $note->id }}</td>
                            <td>{{ $note->date_saisie->format('d/m/Y') }}</td>
                            <td>
                                {{ $note->inscription->etudiant->nom_complet }}
                                <br>
                                <small class="text-muted">{{ $note->inscription->etudiant->matricule }}</small>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $note->inscription->classe->nom_classe }}</span>
                            </td>
                            <td>{{ $note->cours->matiere->nom_matiere }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ $note->typeExamen->libelle ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <span class="badge fs-6 {{ $note->valeur_note >= 10 ? 'bg-success' : 'bg-danger' }}">
                                    {{ number_format($note->valeur_note, 2) }}/20
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.notes.edit', $note->id) }}" class="btn btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $note->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                
                                <form id="delete-form-{{ $note->id }}" action="{{ route('admin.notes.destroy', $note->id) }}" method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Aucune note enregistrée</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $notes->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function confirmDelete(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette note?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush
@endsection