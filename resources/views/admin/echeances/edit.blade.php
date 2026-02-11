@extends('layouts.app')

@section('title', 'Modifier Échéance')
@section('page-title', 'Modifier l\'Échéance de Paiement')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>Modifier Échéance: {{ $echeance->mois }}
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Info de l'inscription -->
                    <div class="alert alert-info mb-4">
                        <strong><i class="fas fa-user me-2"></i>Étudiant:</strong> 
                        {{ $echeance->inscription->etudiant->nom_complet }}
                        <br>
                        <strong><i class="fas fa-school me-2"></i>Classe:</strong> 
                        {{ $echeance->inscription->classe->nom_classe }}
                    </div>

                    <form action="{{ route('admin.echeances.update', $echeance->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="mois" class="form-label">Mois <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('mois') is-invalid @enderror" 
                                id="mois" name="mois" value="{{ old('mois', $echeance->mois) }}"
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
                                            id="montant_echeance" name="montant_echeance" 
                                            value="{{ old('montant_echeance', $echeance->montant_echeance) }}" required>
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
                                        id="date_limite" name="date_limite" 
                                        value="{{ old('date_limite', $echeance->date_limite->format('Y-m-d')) }}" required>
                                    @error('date_limite')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-light border">
                            <strong>État du paiement:</strong>
                            <div class="mt-2">
                                <p class="mb-1">
                                    <span class="badge 
                                        {{ $echeance->statut == 'Payé' ? 'bg-success' : '' }}
                                        {{ $echeance->statut == 'En attente' ? 'bg-warning' : '' }}">
                                        {{ $echeance->statut }}
                                    </span>
                                </p>
                                <p class="mb-0 small text-muted">
                                    Montant payé: <strong>{{ number_format($echeance->montant_paye, 0, ',', ' ') }} FCFA</strong>
                                </p>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Mettre à jour
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
