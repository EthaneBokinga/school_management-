@extends('layouts.app')

@section('title', 'Gestion des Notes')
@section('page-title', 'Mes Notes Saisies')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <i class="fas fa-star me-2"></i>Historique des Notes Saisies
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Cours</th>
                            <th>Classe</th>
                            <th>Élève</th>
                            <th>Type Examen</th>
                            <th>Note</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($notes as $note)
                        <tr>
                            <td>{{ $note->date_saisie->format('d/m/Y') }}</td>
                            <td>{{ $note->cours->matiere->nom_matiere }}</td>
                            <td>
                                <span class="badge bg-info">{{ $note->inscription->classe->nom_classe }}</span>
                            </td>
                            <td>{{ $note->inscription->etudiant->nom_complet }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ $note->typeExamen->libelle }}</span>
                            </td>
                            <td>
                                <span class="badge fs-6 {{ $note->valeur_note >= 10 ? 'bg-success' : 'bg-danger' }}">
                                    {{ number_format($note->valeur_note, 2) }}/20
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('prof.notes.edit', $note->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                <p class="mb-0">Aucune note saisie</p>
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
@endsection