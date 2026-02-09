@extends('layouts.app')

@section('title', 'Gestion des Absences')
@section('page-title', 'Gestion des Absences')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            <i class="fas fa-user-times me-2"></i>Liste des Absences - {{ $anneeActive->libelle }}
        </h4>
        <a href="{{ route('admin.absences.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nouvelle Absence
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
                            <th>Cours</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($absences as $absence)
                        <tr>
                            <td>{{ $absence->id }}</td>
                            <td>{{ \Carbon\Carbon::parse($absence->date_absence)->format('d/m/Y') }}</td>
                            <td>
                                <strong>{{ $absence->inscription->etudiant->nom_complet }}</strong>
                                <br>
                                <small class="text-muted">{{ $absence->inscription->etudiant->matricule }}</small>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $absence->inscription->classe->nom_classe }}</span>
                            </td>
                            <td>
                                @if($absence->cours)
                                    {{ $absence->cours->matiere->nom_matiere }}
                                @else
                                    <span class="text-muted">Non spécifié</span>
                                @endif
                            </td>
                            <td>
                                @if($absence->est_justifie)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check me-1"></i>Justifiée
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times me-1"></i>Non justifiée
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.absences.show', $absence->id) }}" class="btn btn-info" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.absences.edit', $absence->id) }}" class="btn btn-warning" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $absence->id }})" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                
                                <form id="delete-form-{{ $absence->id }}" action="{{ route('admin.absences.destroy', $absence->id) }}" method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Aucune absence enregistrée</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $absences->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function confirmDelete(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette absence?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush
@endsection