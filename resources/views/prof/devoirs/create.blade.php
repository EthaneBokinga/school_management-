@extends('layouts.app')

@section('title', 'Programmer un Devoir')
@section('page-title', 'Programmer un Devoir')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-plus-circle me-2"></i>Nouveau Devoir
                </div>
                <div class="card-body">
                    <form action="{{ route('prof.devoirs.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="cours_id" class="form-label">Cours <span class="text-danger">*</span></label>
                            <select class="form-select @error('cours_id') is-invalid @enderror" id="cours_id" name="cours_id" required>
                                <option value="">-- Sélectionner un cours --</option>
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

                        <div class="mb-3">
                            <label for="titre" class="form-label">Titre du Devoir <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('titre') is-invalid @enderror" 
                                   id="titre" name="titre" value="{{ old('titre') }}" 
                                   placeholder="Ex: Exercices sur les fonctions" required>
                            @error('titre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description / Consignes <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Décrivez le devoir, les exercices à faire, les consignes, etc.</small>
                        </div>

                        <div class="mb-3">
                            <label for="date_limite" class="form-label">Date Limite <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('date_limite') is-invalid @enderror" 
                                   id="date_limite" name="date_limite" value="{{ old('date_limite') }}" 
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                            @error('date_limite')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-bell me-2"></i>
                            <strong>Info:</strong> Tous les élèves de la classe recevront une notification.
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('prof.devoirs.index') }}" class="btn btn-secondary">
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