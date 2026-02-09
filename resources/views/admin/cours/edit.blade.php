@extends('layouts.app')

@section('title', 'Modifier Cours')
@section('page-title', 'Modifier le Cours')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-edit me-2"></i>Formulaire de Modification
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.cours.update', $cours->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="matiere_id" class="form-label">Matière <span class="text-danger">*</span></label>
                            <select class="form-select @error('matiere_id') is-invalid @enderror" 
                                    id="matiere_id" name="matiere_id" required>
                                <option value="">-- Sélectionner une matière --</option>
                                @foreach($matieres as $matiere)
                                <option value="{{ $matiere->id }}" {{ old('matiere_id', $cours->matiere_id) == $matiere->id ? 'selected' : '' }}>
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
                                <option value="{{ $enseignant->id }}" {{ old('enseignant_id', $cours->enseignant_id) == $enseignant->id ? 'selected' : '' }}>
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
                                <option value="{{ $classe->id }}" {{ old('classe_id', $cours->classe_id) == $classe->id ? 'selected' : '' }}>
                                    {{ $classe->nom_classe }} ({{ $classe->niveau }})
                                </option>
                                @endforeach
                            </select>
                            @error('classe_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.cours.index') }}" class="btn btn-secondary">
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