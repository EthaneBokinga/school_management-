@extends('layouts.app')

@section('title', 'Modifier Inscription')
@section('page-title', 'Modifier l\'Inscription')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-edit me-2"></i>Formulaire de Modification
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <strong>Étudiant:</strong> {{ $inscription->etudiant->nom_complet }}<br>
                        <strong>Année scolaire:</strong> {{ $inscription->annee->libelle }}
                    </div>

                    <form action="{{ route('admin.inscriptions.update', $inscription->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="classe_id" class="form-label">Classe <span class="text-danger">*</span></label>
                            <select class="form-select @error('classe_id') is-invalid @enderror" 
                                    id="classe_id" name="classe_id" required>
                                <option value="">-- Sélectionner une classe --</option>
                                @foreach($classes as $classe)
                                <option value="{{ $classe->id }}" {{ old('classe_id', $inscription->classe_id) == $classe->id ? 'selected' : '' }}>
                                    {{ $classe->nom_classe }} ({{ $classe->niveau }})
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
                                <option value="">-- Sélectionner --</option>
                                <option value="Réglé" {{ old('statut_paiement', $inscription->statut_paiement) == 'Réglé' ? 'selected' : '' }}>Réglé</option>
                                <option value="Partiel" {{ old('statut_paiement', $inscription->statut_paiement) == 'Partiel' ? 'selected' : '' }}>Partiel</option>
                                <option value="En attente" {{ old('statut_paiement', $inscription->statut_paiement) == 'En attente' ? 'selected' : '' }}>En attente</option>
                            </select>
                            @error('statut_paiement')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.inscriptions.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Retour
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection