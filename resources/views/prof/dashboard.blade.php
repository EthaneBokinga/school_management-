@extends('layouts.app')

@section('title', 'Dashboard Professeur')
@section('page-title', 'Tableau de Bord Professeur')

@section('content')
<div class="container-fluid">
    <!-- Message de bienvenue -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Bienvenue, {{ $enseignant->nom_complet }}</h3>
                            <p class="mb-0 opacity-75">{{ $enseignant->specialite }}</p>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chalkboard-teacher fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card stat-card primary h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Mes Cours
                            </div>
                            <div class="h5 mb-0 font-weight-bold">{{ $totalCours }}</div>
                            <small class="text-muted">Année {{ $anneeActive->libelle }}</small>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card stat-card success h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Classes
                            </div>
                            <div class="h5 mb-0 font-weight-bold">{{ $totalClasses }}</div>
                            <small class="text-muted">Classes différentes</small>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-school fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card stat-card warning h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Devoirs à Venir
                            </div>
                            <div class="h5 mb-0 font-weight-bold">{{ count($devoirsAVenir) }}</div>
                            <small class="text-muted">À corriger</small>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tasks fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mes cours -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-list me-2"></i>Mes Cours
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Matière</th>
                                    <th>Classe</th>
                                    <th>Emploi du Temps</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mesCours as $cours)
                                <tr>
                                    <td>
                                        <i class="fas fa-book text-primary me-2"></i>
                                        <strong>{{ $cours->matiere->nom_matiere }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $cours->classe->nom_classe }}</span>
                                    </td>
                                    <td>
                                        @if($cours->emploisDuTemps->count() > 0)
                                            <small class="text-muted">
                                                @foreach($cours->emploisDuTemps->take(2) as $emploi)
                                                    <span class="badge bg-secondary me-1">
                                                        {{ $emploi->jour_semaine }} {{ date('H:i', strtotime($emploi->heure_debut)) }}
                                                    </span>
                                                @endforeach
                                            </small>
                                        @else
                                            <small class="text-muted">Non défini</small>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('prof.cours.show', $cours->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i> Voir
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">
                                        Aucun cours assigné
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($mesCours->count() > 0)
                    <div class="text-end mt-3">
                        <a href="{{ route('prof.cours.index') }}" class="btn btn-outline-primary">
                            Voir tous mes cours <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Devoirs à venir -->
            <div class="card mb-4">
                <div class="card-header bg-warning text-white">
                    <i class="fas fa-clipboard-list me-2"></i>Devoirs à Venir
                </div>
                <div class="card-body">
                    @forelse($devoirsAVenir as $devoir)
                    <div class="mb-3 pb-3 border-bottom">
                        <h6 class="mb-1">{{ $devoir->titre }}</h6>
                        <small class="text-muted d-block mb-1">
                            {{ $devoir->cours->classe->nom_classe }} - {{ $devoir->cours->matiere->nom_matiere }}
                        </small>
                        <small class="text-danger">
                            <i class="fas fa-calendar-alt me-1"></i>
                            Date limite: {{ \Carbon\Carbon::parse($devoir->date_limite)->format('d/m/Y') }}
                        </small>
                    </div>
                    @empty
                    <p class="text-muted text-center mb-0">Aucun devoir à venir</p>
                    @endforelse
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-bolt me-2"></i>Actions Rapides
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('prof.notes.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-star me-2"></i>Saisir des Notes
                        </a>
                        <a href="{{ route('prof.absences.index') }}" class="btn btn-outline-warning">
                            <i class="fas fa-user-times me-2"></i>Gérer les Absences
                        </a>
                        <a href="{{ route('prof.cours.index') }}" class="btn btn-outline-info">
                            <i class="fas fa-book me-2"></i>Voir mes Cours
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
}
</style>
@endsection