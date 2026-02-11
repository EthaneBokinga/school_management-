@extends('layouts.app')

@section('title', 'Mes Ressources')
@section('page-title', 'Gestion des Ressources Pédagogiques')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            <i class="fas fa-folder-open me-2"></i>Mes Ressources Pédagogiques
        </h4>
        <a href="{{ route('prof.ressources.create') }}" class="btn btn-primary">
            <i class="fas fa-upload me-2"></i>Upload une Ressource
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Cours</th>
                            <th>Classe</th>
                            <th>Type</th>
                            <th>Taille</th>
                            <th>Date d'ajout</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ressources as $ressource)
                        <tr>
                            <td>
                                <i class="{{ $ressource->icone }} me-2"></i>
                                <strong>{{ $ressource->titre }}</strong>
                            </td>
                            <td>{{ $ressource->cours->matiere->nom_matiere }}</td>
                            <td>
                                <span class="badge bg-info">{{ $ressource->cours->classe->nom_classe }}</span>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ strtoupper($ressource->type_fichier) }}</span>
                            </td>
                            <td>{{ $ressource->taille_formatee }}</td>
                            <td>{{ $ressource->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ $ressource->url_fichier }}" class="btn btn-success" download>
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <a href="{{ $ressource->url_fichier }}" class="btn btn-info" target="_blank">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $ressource->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                
                                <form id="delete-form-{{ $ressource->id }}" action="{{ route('prof.ressources.destroy', $ressource->id) }}" method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Aucune ressource uploadée</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $ressources->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function confirmDelete(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette ressource? Le fichier sera définitivement supprimé.')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush
@endsection