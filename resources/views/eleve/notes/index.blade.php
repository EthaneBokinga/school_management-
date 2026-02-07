@extends('layouts.app')

@section('title', 'Mes Notes')
@section('page-title', 'Mes Notes et Résultats')

@section('content')
<div class="container-fluid">
    @if(!$inscription)
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle me-2"></i>
            Vous n'avez pas d'inscription active pour cette année scolaire.
        </div>
    @else
    <!-- En-tête avec moyenne générale -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card bg-gradient-success text-white">
                <div class="card-body">
                    <h4 class="mb-0">Année Scolaire {{ $inscription->annee->libelle }}</h4>
                    <p class="mb-0 opacity-75">{{ $inscription->classe->nom_classe }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-white border-success">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-1">Moyenne Générale</h6>
                    <h2 class="mb-0 {{ $moyenneGenerale >= 10 ? 'text-success' : 'text-danger' }}">
                        {{ $moyenneGenerale ? number_format($moyenneGenerale, 2) : 'N/A' }}/20
                    </h2>
                    <a href="{{ route('eleve.notes.bulletin') }}" class="btn btn-sm btn-success mt-2">
                        <i class="fas fa-download me-1"></i>Télécharger Bulletin
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Notes par matière -->
    <div class="row">
        @forelse($notesParMatiere as $matiere => $notes)
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-book me-2"></i>{{ $matiere }}</span>
                    <span class="badge bg-white text-primary">
                        Coef: {{ $notes->first()->cours->matiere->coefficient }}
                    </span>
                </div>
                <div class="card-body">
                    <!-- Moyenne de la matière -->
                    <div class="alert alert-{{ $moyennesParMatiere[$matiere]['moyenne'] >= 10 ? 'success' : 'danger' }} mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <strong>Moyenne de la matière:</strong>
                            <span class="fs-5">{{ number_format($moyennesParMatiere[$matiere]['moyenne'], 2) }}/20</span>
                        </div>
                    </div>

                    <!-- Liste des notes -->
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Type d'Examen</th>
                                    <th>Note</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($notes as $note)
                                <tr>
                                    <td>{{ $note->typeExamen->libelle ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge {{ $note->valeur_note >= 10 ? 'bg-success' : 'bg-danger' }}">
                                            {{ number_format($note->valeur_note, 2) }}/20
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $note->date_saisie->format('d/m/Y') }}</small>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Graphique de progression (optionnel) -->
                    <div class="mt-3">
                        <small class="text-muted">
                            <i class="fas fa-chart-line me-1"></i>
                            {{ $notes->count() }} note(s) enregistrée(s)
                        </small>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">Aucune note enregistrée</h5>
                    <p class="text-muted">Les notes apparaîtront ici une fois saisies par vos professeurs.</p>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Récapitulatif global -->
    @if($notesParMatiere->count() > 0)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <i class="fas fa-chart-pie me-2"></i>Récapitulatif par Matière
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Matière</th>
                                    <th>Coefficient</th>
                                    <th>Nombre de Notes</th>
                                    <th>Moyenne</th>
                                    <th>Appréciation</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($moyennesParMatiere as $matiere => $data)
                                <tr>
                                    <td><strong>{{ $matiere }}</strong></td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $data['coefficient'] }}</span>
                                    </td>
                                    <td>{{ $data['notes']->count() }}</td>
                                    <td>
                                        <span class="badge fs-6 {{ $data['moyenne'] >= 10 ? 'bg-success' : 'bg-danger' }}">
                                            {{ number_format($data['moyenne'], 2) }}/20
                                        </span>
                                    </td>
                                    <td>
                                        @if($data['moyenne'] >= 16)
                                            <span class="badge bg-success">Très bien</span>
                                        @elseif($data['moyenne'] >= 14)
                                            <span class="badge bg-info">Bien</span>
                                        @elseif($data['moyenne'] >= 12)
                                            <span class="badge bg-primary">Assez bien</span>
                                        @elseif($data['moyenne'] >= 10)
                                            <span class="badge bg-warning">Passable</span>
                                        @else
                                            <span class="badge bg-danger">Insuffisant</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th colspan="3">Moyenne Générale</th>
                                    <th>
                                        <span class="badge fs-5 {{ $moyenneGenerale >= 10 ? 'bg-success' : 'bg-danger' }}">
                                            {{ number_format($moyenneGenerale, 2) }}/20
                                        </span>
                                    </th>
                                    <th>
                                        @if($moyenneGenerale >= 16)
                                            <span class="badge bg-success">Très bien</span>
                                        @elseif($moyenneGenerale >= 14)
                                            <span class="badge bg-info">Bien</span>
                                        @elseif($moyenneGenerale >= 12)
                                            <span class="badge bg-primary">Assez bien</span>
                                        @elseif($moyenneGenerale >= 10)
                                            <span class="badge bg-warning">Passable</span>
                                        @else
                                            <span class="badge bg-danger">Insuffisant</span>
                                        @endif
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endif
</div>

<style>
.bg-gradient-success {
    background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
}
</style>
@endsection