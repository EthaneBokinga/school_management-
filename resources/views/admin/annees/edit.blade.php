@extends('layouts.app')

@section('title', 'Éditer Année Scolaire')
@section('page-title', 'Modifier l\'Année Scolaire')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>Modifier: {{ $annee->libelle }}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.annees.update', $annee->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="libelle" class="form-label">Libellé <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('libelle') is-invalid @enderror" 
                                id="libelle" name="libelle" value="{{ old('libelle', $annee->libelle) }}"
                                placeholder="Ex: 2024-2025" required>
                            @error('libelle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="date_debut" class="form-label">Date de Début <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('date_debut') is-invalid @enderror" 
                                        id="date_debut" name="date_debut" value="{{ old('date_debut', $annee->date_debut->format('Y-m-d')) }}"
                                        required>
                                    @error('date_debut')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="date_fin" class="form-label">Date de Fin <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('date_fin') is-invalid @enderror" 
                                        id="date_fin" name="date_fin" value="{{ old('date_fin', $annee->date_fin->format('Y-m-d')) }}"
                                        required>
                                    @error('date_fin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="statut" class="form-label">Statut <span class="text-danger">*</span></label>
                            <select class="form-select @error('statut') is-invalid @enderror" 
                                id="statut" name="statut" required>
                                <option value="">-- Sélectionner un statut --</option>
                                <option value="À venir" {{ old('statut', $annee->statut) == 'À venir' ? 'selected' : '' }}>À venir</option>
                                <option value="En cours" {{ old('statut', $annee->statut) == 'En cours' ? 'selected' : '' }}>En cours</option>
                                <option value="Terminée" {{ old('statut', $annee->statut) == 'Terminée' ? 'selected' : '' }}>Terminée</option>
                            </select>
                            @error('statut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-info mb-3">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>État d'activation:</strong>
                            @if($annee->est_active)
                                <span class="badge bg-success ms-2">Année active</span>
                            @else
                                <span class="badge bg-secondary ms-2">Année inactive</span>
                                <p class="mt-2 mb-0 small">Cette année n'est pas l'année courante. Cliquez sur "Activer" dans la liste pour l'activer.</p>
                            @endif
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Mettre à jour
                            </button>
                            <a href="{{ route('admin.annees.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
