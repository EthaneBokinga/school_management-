@extends('layouts.app')

@section('title', 'Modifier Étudiant')
@section('page-title', 'Modifier l\'Étudiant')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-edit me-2"></i>Formulaire de Modification
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.etudiants.update', $etudiant->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="matricule" class="form-label">Matricule <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('matricule') is-invalid @enderror" 
                                       id="matricule" name="matricule" value="{{ old('matricule', $etudiant->matricule) }}" required>
                                @error('matricule')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="sexe" class="form-label">Sexe <span class="text-danger">*</span></label>
                                <select class="form-select @error('sexe') is-invalid @enderror" id="sexe" name="sexe" required>
                                    <option value="">-- Sélectionner --</option>
                                    <option value="M" {{ old('sexe', $etudiant->sexe) == 'M' ? 'selected' : '' }}>Masculin</option>
                                    <option value="F" {{ old('sexe', $etudiant->sexe) == 'F' ? 'selected' : '' }}>Féminin</option>
                                </select>
                                @error('sexe')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                                       id="nom" name="nom" value="{{ old('nom', $etudiant->nom) }}" required>
                                @error('nom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="prenom" class="form-label">Prénom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('prenom') is-invalid @enderror" 
                                       id="prenom" name="prenom" value="{{ old('prenom', $etudiant->prenom) }}" required>
                                @error('prenom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="date_naissance" class="form-label">Date de Naissance <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('date_naissance') is-invalid @enderror" 
                                   id="date_naissance" name="date_naissance" 
                                   value="{{ old('date_naissance', $etudiant->date_naissance ? $etudiant->date_naissance->format('Y-m-d') : '') }}" required>
                            @error('date_naissance')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="statut_actuel" class="form-label">Statut <span class="text-danger">*</span></label>
                            <select class="form-select @error('statut_actuel') is-invalid @enderror" id="statut_actuel" name="statut_actuel" required>
                                <option value="Inscrit" {{ old('statut_actuel', $etudiant->statut_actuel) == 'Inscrit' ? 'selected' : '' }}>Inscrit</option>
                                <option value="Diplomé" {{ old('statut_actuel', $etudiant->statut_actuel) == 'Diplomé' ? 'selected' : '' }}>Diplomé</option>
                                <option value="Quitté" {{ old('statut_actuel', $etudiant->statut_actuel) == 'Quitté' ? 'selected' : '' }}>Quitté</option>
                            </select>
                            @error('statut_actuel')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.etudiants.index') }}" class="btn btn-secondary">
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