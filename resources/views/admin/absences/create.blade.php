@extends('layouts.app')

@section('title', 'Nouvelle Absence')
@section('page-title', 'Enregistrer une Absence')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user-times me-2"></i>Formulaire d'Enregistrement d'Absence
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.absences.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="inscription_id" class="form-label">Étudiant <span class="text-danger">*</span></label>
                            <select class="form-select @error('inscription_id') is-invalid @enderror" 
                                    id="inscription_id" name="inscription_id" required>
                                <option value="">-- Sélectionner un étudiant --</option>
                                @foreach($inscriptions as $inscription)
                                <option value="{{ $inscription->id }}" {{ old('inscription_id') == $inscription->id ? 'selected' : '' }}>
                                    {{ $inscription->etudiant->nom_complet }} 
                                    ({{ $inscription->etudiant->matricule }}) - 
                                    {{ $inscription->classe->nom_classe }}
                                </option>
                                @endforeach
                            </select>
                            @error('inscription_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="cours_id" class="form-label">Cours (optionnel)</label>
                            <select class="form-select @error('cours_id') is-invalid @enderror" 
                                    id="cours_id" name="cours_id">
                                <option value="">-- Absence générale (non liée à un cours) --</option>
                                @foreach($cours as $c)
                                <option value="{{ $c->id }}" {{ old('cours_id') == $c->id ? 'selected' : '' }}>
                                    {{ $c->matiere->nom_matiere }} - {{ $c->classe->nom_classe }}
                                </option>
                                @endforeach
                            </select>
                            @error('cours_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Laissez vide si l'absence n'est pas liée à un cours spécifique</small>
                        </div>

                        <div class="mb-3">
                            <label for="date_absence" class="form-label">Date d'Absence <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('date_absence') is-invalid @enderror" 
                                   id="date_absence" name="date_absence" value="{{ old('date_absence', date('Y-m-d')) }}" required>
                            @error('date_absence')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Statut <span class="text-danger">*</span></label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="est_justifie" id="justifie" value="1" {{ old('est_justifie') == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="justifie">
                                        <i class="fas fa-check-circle text-success me-1"></i>Justifiée
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="est_justifie" id="non_justifie" value="0" {{ old('est_justifie', '0') == '0' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="non_justifie">
                                        <i class="fas fa-times-circle text-danger me-1"></i>Non justifiée
                                    </label>
                                </div>
                            </div>
                            @error('est_justifie')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            L'étudiant recevra une notification de cette absence.
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.absences.index') }}" class="btn btn-secondary">
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