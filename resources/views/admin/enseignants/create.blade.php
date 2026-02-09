@extends('layouts.app')

@section('title', 'Nouvel Enseignant')
@section('page-title', 'Ajouter un Enseignant')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user-plus me-2"></i>Formulaire d'Ajout d'Enseignant
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.enseignants.store') }}" method="POST">
                        @csrf

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
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" 
                                   placeholder="exemple@school.cg" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="specialite" class="form-label">Spécialité <span class="text-danger">*</span></label>
                            <select class="form-select @error('specialite') is-invalid @enderror" id="specialite" name="specialite" required>
                                <option value="">-- Sélectionner --</option>
                                <option value="Mathématiques" {{ old('specialite') == 'Mathématiques' ? 'selected' : '' }}>Mathématiques</option>
                                <option value="Français" {{ old('specialite') == 'Français' ? 'selected' : '' }}>Français</option>
                                <option value="Anglais" {{ old('specialite') == 'Anglais' ? 'selected' : '' }}>Anglais</option>
                                <option value="Physique-Chimie" {{ old('specialite') == 'Physique-Chimie' ? 'selected' : '' }}>Physique-Chimie</option>
                                <option value="SVT" {{ old('specialite') == 'SVT' ? 'selected' : '' }}>SVT</option>
                                <option value="Histoire-Géographie" {{ old('specialite') == 'Histoire-Géographie' ? 'selected' : '' }}>Histoire-Géographie</option>
                                <option value="Philosophie" {{ old('specialite') == 'Philosophie' ? 'selected' : '' }}>Philosophie</option>
                                <option value="EPS" {{ old('specialite') == 'EPS' ? 'selected' : '' }}>EPS</option>
                                <option value="Informatique" {{ old('specialite') == 'Informatique' ? 'selected' : '' }}>Informatique</option>
                                <option value="Arts Plastiques" {{ old('specialite') == 'Arts Plastiques' ? 'selected' : '' }}>Arts Plastiques</option>
                            </select>
                            @error('specialite')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="create_account" name="create_account" value="1" {{ old('create_account') ? 'checked' : '' }}>
                                <label class="form-check-label" for="create_account">
                                    Créer un compte utilisateur pour cet enseignant
                                </label>
                            </div>
                            <small class="text-muted">Mot de passe par défaut: <strong>password</strong></small>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.enseignants.index') }}" class="btn btn-secondary">
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