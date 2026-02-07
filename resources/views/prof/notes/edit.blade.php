@extends('layouts.app')

@section('title', 'Modifier Note')
@section('page-title', 'Modifier une Note')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-edit me-2"></i>Modification de Note
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <strong>Élève:</strong> {{ $note->inscription->etudiant->nom_complet }}<br>
                        <strong>Cours:</strong> {{ $note->cours->matiere->nom_matiere }}<br>
                        <strong>Classe:</strong> {{ $note->inscription->classe->nom_classe }}
                    </div>

                    <form action="{{ route('prof.notes.update', $note->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="type_examen_id" class="form-label">Type d'Examen <span class="text-danger">*</span></label>
                            <select class="form-select @error('type_examen_id') is-invalid @enderror" 
                                    id="type_examen_id" name="type_examen_id" required>
                                @foreach($typesExamens as $type)
                                <option value="{{ $type->id }}" {{ $note->type_examen_id == $type->id ? 'selected' : '' }}>
                                    {{ $type->libelle }}
                                </option>
                                @endforeach
                            </select>
                            @error('type_examen_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="valeur_note" class="form-label">Note / 20 <span class="text-danger">*</span></label>
                            <input type="number" 
                                   class="form-control @error('valeur_note') is-invalid @enderror" 
                                   id="valeur_note" 
                                   name="valeur_note" 
                                   value="{{ old('valeur_note', $note->valeur_note) }}" 
                                   min="0" 
                                   max="20" 
                                   step="0.01" 
                                   required>
                            @error('valeur_note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('prof.notes.index') }}" class="btn btn-secondary">
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