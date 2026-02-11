@extends('layouts.app')

@section('title', 'Nouvelle Année Scolaire')
@section('page-title', 'Créer une Année Scolaire')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-plus me-2"></i>Nouvelle Année Scolaire
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.annees.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="libelle" class="form-label">Libellé <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('libelle') is-invalid @enderror" 
                                id="libelle" name="libelle" value="{{ old('libelle') }}"
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
                                        id="date_debut" name="date_debut" value="{{ old('date_debut') }}"
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
                                        id="date_fin" name="date_fin" value="{{ old('date_fin') }}"
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
                                <option value="À venir" {{ old('statut') == 'À venir' ? 'selected' : '' }}>À venir</option>
                                <option value="En cours" {{ old('statut') == 'En cours' ? 'selected' : '' }}>En cours</option>
                                <option value="Terminée" {{ old('statut') == 'Terminée' ? 'selected' : '' }}>Terminée</option>
                            </select>
                            @error('statut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Créer l'année
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
