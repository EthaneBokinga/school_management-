@extends('layouts.app')

@section('title', 'Mes Examens')
@section('page-title', 'Gestion des Examens')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            <i class="fas fa-file-alt me-2"></i>Mes Examens Programmés
        </h4>
        <a href="{{ route('prof.examens.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Programmer un Examen
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Titre</th>
                            <th>Type</th>
                            <th>Cours</th>
                            <th>Classe</th>
                            <th>Horaire</th>
                            <th>Salle</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($examens as $examen)
                        <tr class="{{ $examen->isAujourdhui() ? 'table-warning' : '' }}">
                            <td>
                                <strong>{{ $examen->date_examen->format('d/m/Y') }}</strong>
                                @if($examen->isAujourdhui())
                                    <br><span class="badge bg-warning">Aujourd'hui</span>
                                @endif
                            </td>
                            <td>{{ $examen->titre }}</td>
                            <td>
                                <span class="badge bg-info">{{ $examen->typeExamen->libelle }}</span>
                            </td>
                            <td>{{ $examen->cours->matiere->nom_matiere }}</td>
                            <td>
                                <span class="badge bg-primary">{{ $examen->cours->classe->nom_classe }}</span>
                            </td>
                            <td>
                                <small>
                                    {{ date('H:i', strtotime($examen->heure_debut)) }} - 
                                    {{ date('H:i', strtotime($examen->heure_fin)) }}
                                </small>
                            </td>
                            <td>{{ $examen->salle->nom_salle ?? 'Non définie' }}</td>
                            <td>
                                <span class="badge 
                                    {{ $examen->statut == 'Programmé' ? 'bg-success' : '' }}
                                    {{ $examen->statut == 'En cours' ? 'bg-warning' : '' }}
                                    {{ $examen->statut == 'Terminé' ? 'bg-secondary' : '' }}">
                                    {{ $examen->statut }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('prof.examens.edit', $examen->id) }}" class="btn btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $examen->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                
                                <form id="delete-form-{{ $examen->id }}" action="{{ route('prof.examens.destroy', $examen->id) }}" method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Aucun examen programmé</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $examens->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function confirmDelete(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cet examen?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush
@endsection