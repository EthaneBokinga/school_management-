@extends('layouts.app')

@section('title', 'Modifier Devoir')
@section('page-title', 'Modifier le Devoir')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-edit me-2"></i>Modification du Devoir
                </div>
                <div class="card-body">
                    <form action="{{ route('prof.devoirs.update', $devoir->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="alert alert-info">
                            <strong>Cours:</strong> {{ $devoir->cours->matiere->nom_matiere }} - {{ $devoir->cours->classe->nom_classe }}
                        </div>

                        <div class="mb-3">
                            <label for="titre" class="form-label">Titre du Devoir <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('titre') is-invalid @enderror" 
                                   id="titre" name="titre" value="{{ old('titre', $devoir->titre) }}" required>
                            @error('titre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description / Consignes <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="5" required>{{ old('description', $devoir->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="date_limite" class="form-label">Date Limite <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('date_limite') is-invalid @enderror" 
                                   id="date_limite" name="date_limite" 
                                   value="{{ old('date_limite', $devoir->date_limite->format('Y-m-d')) }}" required>
                            @error('date_limite')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('prof.devoirs.index') }}" class="btn btn-secondary">
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