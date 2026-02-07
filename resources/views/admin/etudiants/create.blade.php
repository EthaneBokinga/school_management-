@extends('layouts.app')

@section('title', 'Nouvel Étudiant')
@section('page-title', 'Ajouter un Étudiant')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user-plus me-2"></i>Formulaire d'Ajout d'Étudiant
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.etudiants.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="matricule" class="form-label">Matricule <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('matricule') is-invalid @enderror" 
                                       id="matricule" name="matricule" value="{{ old('matricule') }}" 
                                       placeholder="ETU2024XXX" required>
                                @error('matricule')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="sexe" class="form-label">Sexe <span class="text-danger">*</span></label>
                                <select class="form-select @error('sexe') is-invalid @enderror" id="sexe" name="sexe" required>
                                    <option value="">-- Sélectionner --</option>
                                    <option value="M" {{ old('sexe') == 'M' ? 'selected' : '' }}>Masculin</option>
                                    <option value="F" {{ old('sexe') == 'F' ? 'selected' : '' }}>Féminin</option>
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
                                       id="nom" name="nom" value="{{ old('nom') }}" required>
                                @error('nom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="prenom" class="form-label">Prénom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('prenom') is-invalid @enderror" 
                                       id="prenom" name="prenom" value="{{ old('prenom') }}" required>
                                @error('prenom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="date_naissance" class="form-label">Date de Naissance <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('date_naissance') is-invalid @enderror" 
                                   id="date_naissance" name="date_naissance" value="{{ old('date_naissance') }}" required>
                            @error('date_naissance')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="create_account" name="create_account" value="1" {{ old('create_account') ? 'checked' : '' }}>
                                <label class="form-check-label" for="create_account">
                                    Créer un compte utilisateur pour cet étudiant
                                </label>
                            </div>
                            <small class="text-muted">Email: <strong>[matricule]@eleve.school.cg</strong> | Mot de passe: <strong>password</strong></small>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.etudiants.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Retour
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection