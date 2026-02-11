@extends('layouts.app')

@section('title', 'Upload Ressource')
@section('page-title', 'Upload une Ressource')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-upload me-2"></i>Formulaire d'Upload
                </div>
                <div class="card-body">
                    <form action="{{ route('prof.ressources.store') }}" method="POST" enctype="multipart/form-data">
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
                            <label for="titre" class="form-label">Titre du Document <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('titre') is-invalid @enderror" 
                                   id="titre" name="titre" value="{{ old('titre') }}" 
                                   placeholder="Ex: Cours sur les équations du second degré" required>
                            @error('titre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="fichier" class="form-label">Fichier <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('fichier') is-invalid @enderror" 
                                   id="fichier" name="fichier" required 
                                   accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip,.rar">
                            @error('fichier')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                Formats acceptés: PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, ZIP, RAR (Max: 20MB)
                            </small>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Info:</strong> Les élèves de la classe sélectionnée pourront télécharger ce document.
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('prof.ressources.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Retour
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload me-2"></i>Upload
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection