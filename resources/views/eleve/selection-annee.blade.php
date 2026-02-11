@extends('layouts.app')

@section('title', 'Sélection Année')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Sélectionnez une Année Scolaire</h4>
                </div>
                <div class="card-body p-4">
                    <!-- Profil étudiant -->
                    <div class="text-center mb-4">
                        <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 100px; height: 100px;">
                            <i class="fas fa-user-graduate fa-3x text-white"></i>
                        </div>
                        <h5>{{ $etudiant->nom_complet }}</h5>
                        <p class="text-muted mb-0">{{ $etudiant->matricule }}</p>
                        <p class="text-muted">
                            <i class="fas fa-{{ $etudiant->sexe == 'M' ? 'mars' : 'venus' }} me-1"></i>
                            {{ $etudiant->sexe == 'M' ? 'Masculin' : 'Féminin' }}
                        </p>
                    </div>

                    <hr>

                    <h6 class="mb-3 text-center">Choisissez l'année que vous souhaitez consulter :</h6>

                    @if($inscriptions->count() > 0)
                    <div class="row">
                        @foreach($inscriptions as $inscription)
                        <div class="col-md-6 mb-3">
                            <form action="{{ route('eleve.selectionner-annee') }}" method="POST">
                                @csrf
                                <input type="hidden" name="inscription_id" value="{{ $inscription->id }}">
                                
                                <button type="submit" class="btn btn-outline-primary w-100 p-4 annee-card {{ $inscription->annee->est_active ? 'border-success' : '' }}">
                                    <div class="text-start">
                                        <h5 class="mb-2">
                                            {{ $inscription->annee->libelle }}
                                            @if($inscription->annee->est_active)
                                                <span class="badge bg-success float-end">En cours</span>
                                            @endif
                                        </h5>
                                        <p class="mb-1">
                                            <i class="fas fa-school me-2"></i>
                                            <strong>Classe:</strong> {{ $inscription->classe->nom_classe }}
                                        </p>
                                        <p class="mb-1">
                                            <i class="fas fa-calendar me-2"></i>
                                            <strong>Du:</strong> {{ $inscription->annee->date_debut->format('d/m/Y') }} 
                                            au {{ $inscription->annee->date_fin->format('d/m/Y') }}
                                        </p>
                                        <p class="mb-0">
                                            <i class="fas fa-money-bill me-2"></i>
                                            <strong>Paiement:</strong> 
                                            <span class="badge 
                                                {{ $inscription->statut_paiement == 'Réglé' ? 'bg-success' : '' }}
                                                {{ $inscription->statut_paiement == 'Partiel' ? 'bg-warning' : '' }}
                                                {{ $inscription->statut_paiement == 'En attente' ? 'bg-danger' : '' }}">
                                                {{ $inscription->statut_paiement }}
                                            </span>
                                        </p>
                                    </div>
                                </button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="alert alert-warning text-center">
                        <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                        <p class="mb-0">Aucune inscription trouvée. Contactez l'administration.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.annee-card {
    transition: all 0.3s;
    border-width: 2px !important;
}

.annee-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.annee-card.border-success {
    border-width: 3px !important;
}
</style>
@endsection