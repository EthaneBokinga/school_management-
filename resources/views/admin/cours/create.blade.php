@extends('layouts.app')

@section('title', 'Nouveau Cours')
@section('page-title', 'Ajouter un Cours')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-plus-circle me-2"></i>Formulaire d'Ajout de Cours
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Année scolaire active:</strong> {{ $anneeActive->libelle }}
                    </div>

                    <form action="{{ route('admin.cours.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="matiere_id" class="form-label">Matière <span class="text-danger">*</span></label>
                            <select class="form-select @error('matiere_id') is-invalid @enderror" 
                                    id="matiere_id" name="matiere_id" required>
                                <option value="">-- Sélectionner une matière --</option>
                                @foreach($matieres as $matiere)
                                <option value="{{ $matiere->id }}" {{ old('matiere_id') == $matiere->id ? 'selected' : '' }}>
                                    {{ $matiere->nom_matiere }} ({{ $matiere->code_matiere }}) - Coef: {{ $matiere->coefficient }}
                                </option>
                                @endforeach
                            </select>
                            @error('matiere_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="enseignant_id" class="form-label">Enseignant <span class="text-danger">*</span></label>
                            <select class="form-select @error('enseignant_id') is-invalid @enderror" 
                                    id="enseignant_id" name="enseignant_id" required>
                                <option value="">-- Sélectionner un enseignant --</option>
                                @foreach($enseignants as $enseignant)
                                <option value="{{ $enseignant->id }}" {{ old('enseignant_id') == $enseignant->id ? 'selected' : '' }}>
                                    {{ $enseignant->nom_complet }} - {{ $enseignant->specialite }}
                                </option>
                                @endforeach
                            </select>
                            @error('enseignant_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="classe_id" class="form-label">Classe <span class="text-danger">*</span></label>
                            <select class="form-select @error('classe_id') is-invalid @enderror" 
                                    id="classe_id" name="classe_id" required>
                                <option value="">-- Sélectionner une classe --</option>
                                @foreach($classes as $classe)
                                <option value="{{ $classe->id }}" {{ old('classe_id') == $classe->id ? 'selected' : '' }}>
                                    {{ $classe->nom_classe }} ({{ $classe->niveau }})
                                </option>
                                @endforeach
                            </select>
                            @error('classe_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Note:</strong> Vous pourrez configurer l'emploi du temps après la création du cours.
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.cours.index') }}" class="btn btn-secondary">
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