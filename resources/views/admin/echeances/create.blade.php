@extends('layouts.app')

@section('title', 'Nouvelle Échéance')
@section('page-title', 'Créer une Échéance de Paiement')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-plus me-2"></i>Nouvelle Échéance de Paiement
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.echeances.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="inscription_id" class="form-label">Inscriptions <span class="text-danger">*</span></label>
                            <select class="form-select @error('inscription_id') is-invalid @enderror" 
                                id="inscription_id" name="inscription_id" required>
                                <option value="">-- Sélectionner une inscription --</option>
                                @foreach($inscriptions as $inscription)
                                    <option value="{{ $inscription->id }}" {{ old('inscription_id') == $inscription->id ? 'selected' : '' }}>
                                        {{ $inscription->etudiant->nom_complet }} - {{ $inscription->classe->nom_classe }}
                                    </option>
                                @endforeach
                            </select>
                            @error('inscription_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="mois" class="form-label">Mois <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('mois') is-invalid @enderror" 
                                id="mois" name="mois" value="{{ old('mois') }}"
                                placeholder="Ex: Octobre 2024-2025" required>
                            @error('mois')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="montant_echeance" class="form-label">Montant <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" class="form-control @error('montant_echeance') is-invalid @enderror" 
                                            id="montant_echeance" name="montant_echeance" value="{{ old('montant_echeance') }}" required>
                                        <span class="input-group-text">FCFA</span>
                                    </div>
                                    @error('montant_echeance')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="date_limite" class="form-label">Date Limite <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('date_limite') is-invalid @enderror" 
                                        id="date_limite" name="date_limite" value="{{ old('date_limite') }}" required>
                                    @error('date_limite')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Astuce:</strong> Vous pouvez aussi générer automatiquement 10 échéances mensuelles directement sur la fiche d'inscription.
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Créer l'échéance
                            </button>
                            <a href="{{ route('admin.echeances.index') }}" class="btn btn-secondary">
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
