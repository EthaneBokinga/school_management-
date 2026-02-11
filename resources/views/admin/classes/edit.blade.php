@extends('layouts.app')

@section('title', 'Modifier Classe')
@section('page-title', 'Modifier la Classe')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-edit me-2"></i>Formulaire de Modification
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.classes.update', $classe->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nom_classe" class="form-label">Nom de la Classe <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nom_classe') is-invalid @enderror" 
                                   id="nom_classe" name="nom_classe" value="{{ old('nom_classe', $classe->nom_classe) }}" required>
                            @error('nom_classe')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
    <label for="niveau" class="form-label">Niveau <span class="text-danger">*</span></label>
    <select class="form-select @error('niveau') is-invalid @enderror" id="niveau" name="niveau" required onchange="toggleAutreNiveau()">
        <option value="">-- Sélectionner --</option>
        <option value="6ème" {{ old('niveau', $classe->niveau ?? '') == '6ème' ? 'selected' : '' }}>6ème</option>
        <option value="5ème" {{ old('niveau', $classe->niveau ?? '') == '5ème' ? 'selected' : '' }}>5ème</option>
        <option value="4ème" {{ old('niveau', $classe->niveau ?? '') == '4ème' ? 'selected' : '' }}>4ème</option>
        <option value="3ème" {{ old('niveau', $classe->niveau ?? '') == '3ème' ? 'selected' : '' }}>3ème</option>
        <option value="Seconde" {{ old('niveau', $classe->niveau ?? '') == 'Seconde' ? 'selected' : '' }}>Seconde</option>
        <option value="Première" {{ old('niveau', $classe->niveau ?? '') == 'Première' ? 'selected' : '' }}>Première</option>
        <option value="Terminale" {{ old('niveau', $classe->niveau ?? '') == 'Terminale' ? 'selected' : '' }}>Terminale</option>
        <option value="CP" {{ old('niveau', $classe->niveau ?? '') == 'CP' ? 'selected' : '' }}>CP (Cours Préparatoire)</option>
        <option value="CE1" {{ old('niveau', $classe->niveau ?? '') == 'CE1' ? 'selected' : '' }}>CE1</option>
        <option value="CE2" {{ old('niveau', $classe->niveau ?? '') == 'CE2' ? 'selected' : '' }}>CE2</option>
        <option value="CM1" {{ old('niveau', $classe->niveau ?? '') == 'CM1' ? 'selected' : '' }}>CM1</option>
        <option value="CM2" {{ old('niveau', $classe->niveau ?? '') == 'CM2' ? 'selected' : '' }}>CM2</option>
        <option value="Autre">Autre (préciser)</option>
    </select>
    @error('niveau')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- Champ caché qui apparaît si "Autre" est sélectionné -->
<div class="mb-3 d-none" id="autreNiveauDiv">
    <label for="autre_niveau" class="form-label">Précisez le niveau <span class="text-danger">*</span></label>
    <input type="text" class="form-control" id="autre_niveau" name="autre_niveau" placeholder="Ex: Maternelle, BTS1, etc.">
</div>

@push('scripts')
<script>
function toggleAutreNiveau() {
    const select = document.getElementById('niveau');
    const autreDiv = document.getElementById('autreNiveauDiv');
    const autreInput = document.getElementById('autre_niveau');
    
    if (select.value === 'Autre') {
        autreDiv.classList.remove('d-none');
        autreInput.required = true;
    } else {
        autreDiv.classList.add('d-none');
        autreInput.required = false;
        autreInput.value = '';
    }
}

// Check on page load
window.addEventListener('DOMContentLoaded', toggleAutreNiveau);
</script>
@endpush

                        <div class="mb-3">
                            <label for="frais_scolarite" class="form-label">Frais de Scolarité (FCFA) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('frais_scolarite') is-invalid @enderror" 
                                   id="frais_scolarite" name="frais_scolarite" value="{{ old('frais_scolarite', $classe->frais_scolarite) }}" required min="0">
                            @error('frais_scolarite')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.classes.index') }}" class="btn btn-secondary">
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