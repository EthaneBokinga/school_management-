@extends('layouts.app')

@section('title', 'Réinscription Étudiant')
@section('page-title', 'Réinscription de l\'Étudiant')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <!-- Infos Étudiant -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user-graduate me-2"></i>{{ $etudiant->nom_complet }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Matricule:</strong> {{ $etudiant->matricule }}</p>
                            <p><strong>Email:</strong> {{ $etudiant->email }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Sexe:</strong> {{ $etudiant->sexe == 'M' ? 'Masculin' : 'Féminin' }}</p>
                            <p><strong>Date de Naissance:</strong> {{ $etudiant->date_naissance->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Historique Inscriptions -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-history me-2"></i>Historique d'inscriptions
                    </h5>
                </div>
                <div class="card-body">
                    @if($etudiant->inscriptions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>Année</th>
                                        <th>Classe</th>
                                        <th>Type</th>
                                        <th>Statut Paiement</th>
                                        <th>Date Inscription</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($etudiant->inscriptions as $insc)
                                        <tr>
                                            <td><span class="badge bg-info">{{ $insc->annee->libelle }}</span></td>
                                            <td>{{ $insc->classe->nom_classe }}</td>
                                            <td>{{ $insc->type_inscription }}</td>
                                            <td>
                                                <span class="badge 
                                                    {{ $insc->statut_paiement == 'Réglé' ? 'bg-success' : '' }}
                                                    {{ $insc->statut_paiement == 'Partiel' ? 'bg-warning' : '' }}
                                                    {{ $insc->statut_paiement == 'En attente' ? 'bg-danger' : '' }}">
                                                    {{ $insc->statut_paiement }}
                                                </span>
                                            </td>
                                            <td>{{ $insc->date_inscription->format('d/m/Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Aucune inscription antérieure
                        </div>
                    @endif
                </div>
            </div>

            <!-- Formulaire Réinscription -->
            @if($dejaInscrit)
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Attention:</strong> Cet étudiant est déjà inscrit pour l'année {{ $anneeActive->libelle }}
                </div>
            @else
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-edit me-2"></i>Formulaire de Réinscription
                        </h5>
                        <small class="text-muted">Année: <strong>{{ $anneeActive->libelle }}</strong></small>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.etudiants.store-reinscription', $etudiant->id) }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="classe_id" class="form-label">Classe <span class="text-danger">*</span></label>
                                <select class="form-select @error('classe_id') is-invalid @enderror" 
                                    id="classe_id" name="classe_id" required>
                                    <option value="">-- Sélectionner une classe --</option>
                                    @foreach($classes as $classe)
                                        <option value="{{ $classe->id }}" {{ old('classe_id') == $classe->id ? 'selected' : '' }}>
                                            {{ $classe->nom_classe }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('classe_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="statut_paiement" class="form-label">Statut de Paiement <span class="text-danger">*</span></label>
                                <select class="form-select @error('statut_paiement') is-invalid @enderror" 
                                    id="statut_paiement" name="statut_paiement" required>
                                    <option value="">-- Sélectionner un statut --</option>
                                    <option value="Réglé" {{ old('statut_paiement') == 'Réglé' ? 'selected' : '' }}>Réglé</option>
                                    <option value="Partiel" {{ old('statut_paiement') == 'Partiel' ? 'selected' : '' }}>Partiel</option>
                                    <option value="En attente" {{ old('statut_paiement') == 'En attente' ? 'selected' : '' }}>En attente</option>
                                </select>
                                @error('statut_paiement')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-check me-2"></i>Confirmer la réinscription
                                </button>
                                <a href="{{ route('admin.etudiants.show', $etudiant->id) }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-2"></i>Annuler
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
