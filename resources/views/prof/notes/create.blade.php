@extends('layouts.app')

@section('title', 'Saisir des Notes')
@section('page-title', 'Saisir des Notes')

@section('content')
<div class="container-fluid">
    <div class="mb-3">
        <a href="{{ route('prof.cours.show', $cours->id) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Retour au cours
        </a>
    </div>

    <!-- Information du cours -->
    <div class="card mb-4 bg-primary text-white">
        <div class="card-body">
            <h5 class="mb-0">{{ $cours->matiere->nom_matiere }} - {{ $cours->classe->nom_classe }}</h5>
            <p class="mb-0 opacity-75">Coefficient: {{ $cours->matiere->coefficient }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <i class="fas fa-edit me-2"></i>Formulaire de Saisie des Notes
        </div>
        <div class="card-body">
            <form action="{{ route('prof.notes.store') }}" method="POST" id="notesForm">
                @csrf
                <input type="hidden" name="cours_id" value="{{ $cours->id }}">

                <div class="mb-4">
                    <label for="type_examen_id" class="form-label">Type d'Examen <span class="text-danger">*</span></label>
                    <select class="form-select @error('type_examen_id') is-invalid @enderror" 
                            id="type_examen_id" name="type_examen_id" required>
                        <option value="">-- Sélectionner --</option>
                        @foreach($typesExamens as $type)
                        <option value="{{ $type->id }}">{{ $type->libelle }}</option>
                        @endforeach
                    </select>
                    @error('type_examen_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Instructions:</strong> Saisissez les notes sur 20. Laissez vide si l'élève était absent.
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th>Matricule</th>
                                <th>Nom Complet</th>
                                <th style="width: 150px;">Note / 20 <span class="text-danger">*</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inscriptions as $index => $inscription)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $inscription->etudiant->matricule }}</td>
                                <td>
                                    <strong>{{ $inscription->etudiant->nom_complet }}</strong>
                                    <input type="hidden" name="notes[{{ $index }}][inscription_id]" value="{{ $inscription->id }}">
                                </td>
                                <td>
                                    <input type="number" 
                                           class="form-control note-input" 
                                           name="notes[{{ $index }}][valeur_note]" 
                                           min="0" 
                                           max="20" 
                                           step="0.01"
                                           placeholder="Ex: 15.5">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="alert alert-warning mt-3">
                    <i class="fas fa-bell me-2"></i>
                    Les élèves recevront une notification dès que vous enregistrerez leurs notes.
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('prof.cours.show', $cours->id) }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Annuler
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-2"></i>Enregistrer les Notes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('notesForm').addEventListener('submit', function(e) {
    const noteInputs = document.querySelectorAll('.note-input');
    let hasAtLeastOneNote = false;
    let allValid = true;

    noteInputs.forEach(input => {
        const value = parseFloat(input.value);
        
        if (input.value !== '') {
            hasAtLeastOneNote = true;
            
            if (isNaN(value) || value < 0 || value > 20) {
                allValid = false;
                input.classList.add('is-invalid');
            } else {
                input.classList.remove('is-invalid');
            }
        }
    });

    if (!hasAtLeastOneNote) {
        e.preventDefault();
        alert('Veuillez saisir au moins une note.');
        return false;
    }

    if (!allValid) {
        e.preventDefault();
        alert('Certaines notes sont invalides. Les notes doivent être comprises entre 0 et 20.');
        return false;
    }

    return confirm('Êtes-vous sûr de vouloir enregistrer ces notes? Les élèves recevront une notification.');
});
</script>
@endpush
@endsection