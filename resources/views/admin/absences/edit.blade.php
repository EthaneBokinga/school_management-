@extends('layouts.app')

@section('title', 'Modifier Absence')
@section('page-title', 'Modifier l\'Absence')

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
                        <strong>Étudiant:</strong> {{ $absence->inscription->etudiant->nom_complet }}<br>
                        <strong>Classe:</strong> {{ $absence->inscription->classe->nom_classe }}
                    </div>

                    <form action="{{ route('admin.absences.update', $absence->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="date_absence" class="form-label">Date d'Absence <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('date_absence') is-invalid @enderror" 
                                   id="date_absence" name="date_absence" 
                                   value="{{ old('date_absence', $absence->date_absence->format('Y-m-d')) }}" required>
                            @error('date_absence')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Statut <span class="text-danger">*</span></label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="est_justifie" id="justifie" value="1" 
                                           {{ old('est_justifie', $absence->est_justifie) == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="justifie">
                                        <i class="fas fa-check-circle text-success me-1"></i>Justifiée
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="est_justifie" id="non_justifie" value="0" 
                                           {{ old('est_justifie', $absence->est_justifie) == '0' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="non_justifie">
                                        <i class="fas fa-times-circle text-danger me-1"></i>Non justifiée
                                    </label>
                                </div>
                            </div>
                            @error('est_justifie')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.absences.index') }}" class="btn btn-secondary">
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