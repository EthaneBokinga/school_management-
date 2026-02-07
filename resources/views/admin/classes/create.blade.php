@extends('layouts.app')

@section('title', 'Nouvelle Classe')
@section('page-title', 'Ajouter une Classe')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-plus-circle me-2"></i>Formulaire d'Ajout de Classe
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.classes.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="nom_classe" class="form-label">Nom de la Classe <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nom_classe') is-invalid @enderror" 
                                   id="nom_classe" name="nom_classe" value="{{ old('nom_classe') }}" 
                                   placeholder="Ex: 6ème A" required>
                            @error('nom_classe')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="niveau" class="form-label">Niveau <span class="text-danger">*</span></label>
                            <select class="form-select @error('niveau') is-invalid @enderror" id="niveau" name="niveau" required>
                                <option value="">-- Sélectionner --</option>
                                <option value="6ème" {{ old('niveau') == '6ème' ? 'selected' : '' }}>6ème</option>
                                <option value="5ème" {{ old('niveau') == '5ème' ? 'selected' : '' }}>5ème</option>
                                <option value="4ème" {{ old('niveau') == '4ème' ? 'selected' : '' }}>4ème</option>
                                <option value="3ème" {{ old('niveau') == '3ème' ? 'selected' : '' }}>3ème</option>
                                <option value="Seconde" {{ old('niveau') == 'Seconde' ? 'selected' : '' }}>Seconde</option>
                                <option value="Première" {{ old('niveau') == 'Première' ? 'selected' : '' }}>Première</option>
                                <option value="Terminale" {{ old('niveau') == 'Terminale' ? 'selected' : '' }}>Terminale</option>
                            </select>
                            @error('niveau')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="frais_scolarite" class="form-label">Frais de Scolarité (FCFA) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('frais_scolarite') is-invalid @enderror" 
                                   id="frais_scolarite" name="frais_scolarite" value="{{ old('frais_scolarite') }}" 
                                   placeholder="150000" required min="0">
                            @error('frais_scolarite')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.classes.index') }}" class="btn btn-secondary">
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