@extends('layouts.app')

@section('title', 'Programmer un Examen')
@section('page-title', 'Programmer un Examen')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-plus-circle me-2"></i>Nouvel Examen
                </div>
                <div class="card-body">
                    <form action="{{ route('prof.examens.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="cours_id" class="form-label">Cours <span class="text-danger">*</span></label>
                                <select class="form-select @error('cours_id') is-invalid @enderror" id="cours_id" name="cours_id" required>
                                    <option value="">-- Sélectionner --</option>
                                    @foreach($cours as $c)
                                    <option value="{{ $c->id }}" {{ old('cours_id') == $c->id ? 'selected' : '' }}>
                                        {{ $c->matiere->nom_matiere }} - {{ $c->classe->nom_classe }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('cours_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="type_examen_id" class="form-label">Type d'Examen <span class="text-danger">*</span></label>
                                <select class="form-select @error('type_examen_id') is-invalid @enderror" id="type_examen_id" name="type_examen_id" required>
                                    <option value="">-- Sélectionner --</option>
                                    @foreach($typesExamens as $type)
                                    <option value="{{ $type->id }}" {{ old('type_examen_id') == $type->id ? 'selected' : '' }}>
                                        {{ $type->libelle }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('type_examen_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="titre" class="form-label">Titre de l'Examen <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('titre') is-invalid @enderror" 
                                   id="titre" name="titre" value="{{ old('titre') }}" 
                                   placeholder="Ex: Examen de fin de trimestre" required>
                            @error('titre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description / Chapitres concernés</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="date_examen" class="form-label">Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('date_examen') is-invalid @enderror" 
                                       id="date_examen" name="date_examen" value="{{ old('date_examen') }}" 
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                                @error('date_examen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="heure_debut" class="form-label">Heure Début <span class="text-danger">*</span></label>
                                <input type="time" class="form-control @error('heure_debut') is-invalid @enderror" 
                                       id="heure_debut" name="heure_debut" value="{{ old('heure_debut', '08:00') }}" required>
                                @error('heure_debut')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="heure_fin" class="form-label">Heure Fin <span class="text-danger">*</span></label>
                                <input type="time" class="form-control @error('heure_fin') is-invalid @enderror" 
                                       id="heure_fin" name="heure_fin" value="{{ old('heure_fin', '10:00') }}" required>
                                @error('heure_fin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="salle_id" class="form-label">Salle</label>
                            <select class="form-select @error('salle_id') is-invalid @enderror" id="salle_id" name="salle_id">
                                <option value="">-- Non définie --</option>
                                @foreach($salles as $salle)
                                <option value="{{ $salle->id }}" {{ old('salle_id') == $salle->id ? 'selected' : '' }}>
                                    {{ $salle->nom_salle }}
                                </option>
                                @endforeach
                            </select>
                            @error('salle_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-warning">
                            <i class="fas fa-bell me-2"></i>
                            <strong>Notification:</strong> Tous les élèves de la classe recevront une notification automatique.
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('prof.examens.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Retour
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Programmer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection