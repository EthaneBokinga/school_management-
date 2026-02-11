@extends('layouts.app')

@section('title', 'Nouvelle Inscription')
@section('page-title', 'Enregistrer une Inscription')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user-plus me-2"></i>Formulaire d'Inscription
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Année scolaire active:</strong> {{ $anneeActive->libelle }}
                    </div>

                    <form action="{{ route('admin.inscriptions.store') }}" method="POST">
                        @csrf
<div class="mb-3">
    <label for="search_etudiant" class="form-label">Rechercher un Étudiant <span class="text-danger">*</span></label>
    <div class="input-group mb-2">
        <span class="input-group-text"><i class="fas fa-search"></i></span>
        <input type="text" class="form-control" id="search_etudiant" placeholder="Tapez le nom, prénom ou matricule...">
    </div>
    
    <select class="form-select @error('etudiant_id') is-invalid @enderror" 
            id="etudiant_id" name="etudiant_id" required size="8">
        <option value="">-- Tous les étudiants --</option>
        @foreach($etudiants as $etudiant)
        <option value="{{ $etudiant->id }}" {{ old('etudiant_id') == $etudiant->id ? 'selected' : '' }}
                data-search="{{ strtolower($etudiant->nom . ' ' . $etudiant->prenom . ' ' . $etudiant->matricule) }}">
            {{ $etudiant->nom_complet }} ({{ $etudiant->matricule }})
        </option>
        @endforeach
    </select>
    @error('etudiant_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

@push('scripts')
<script>
document.getElementById('search_etudiant').addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const select = document.getElementById('etudiant_id');
    const options = select.querySelectorAll('option');
    
    options.forEach(option => {
        if (option.value === '') return; // Skip first option
        
        const searchData = option.getAttribute('data-search');
        option.style.display = searchData.includes(searchTerm) ? '' : 'none';
    });
});
</script>
@endpush

                        <div class="mb-3">
                            <label for="classe_id" class="form-label">Classe <span class="text-danger">*</span></label>
                            <select class="form-select @error('classe_id') is-invalid @enderror" 
                                    id="classe_id" name="classe_id" required onchange="updateFrais()">
                                <option value="">-- Sélectionner une classe --</option>
                                @foreach($classes as $classe)
                                <option value="{{ $classe->id }}" 
                                        data-frais="{{ $classe->frais_scolarite }}"
                                        {{ old('classe_id') == $classe->id ? 'selected' : '' }}>
                                    {{ $classe->nom_classe }} ({{ $classe->niveau }})
                                </option>
                                @endforeach
                            </select>
                            @error('classe_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div id="fraisInfo" class="alert alert-secondary d-none">
                            <strong>Frais de scolarité:</strong> <span id="fraisMontant">-</span> FCFA
                        </div>

                        <div class="mb-3">
                            <label for="type_inscription" class="form-label">Type d'Inscription <span class="text-danger">*</span></label>
                            <select class="form-select @error('type_inscription') is-invalid @enderror" 
                                    id="type_inscription" name="type_inscription" required>
                                <option value="">-- Sélectionner --</option>
                                <option value="Nouvelle" {{ old('type_inscription') == 'Nouvelle' ? 'selected' : '' }}>Nouvelle Inscription</option>
                                <option value="Réinscription" {{ old('type_inscription') == 'Réinscription' ? 'selected' : '' }}>Réinscription</option>
                            </select>
                            @error('type_inscription')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="statut_paiement" class="form-label">Statut de Paiement <span class="text-danger">*</span></label>
                            <select class="form-select @error('statut_paiement') is-invalid @enderror" 
                                    id="statut_paiement" name="statut_paiement" required>
                                <option value="">-- Sélectionner --</option>
                                <option value="Réglé" {{ old('statut_paiement') == 'Réglé' ? 'selected' : '' }}>Réglé</option>
                                <option value="Partiel" {{ old('statut_paiement') == 'Partiel' ? 'selected' : '' }}>Partiel</option>
                                <option value="En attente" {{ old('statut_paiement') == 'En attente' ? 'selected' : '' }}>En attente</option>
                            </select>
                            @error('statut_paiement')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Important:</strong> Une notification sera automatiquement envoyée à l'étudiant après validation de l'inscription.
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.inscriptions.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Retour
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Enregistrer l'Inscription
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function updateFrais() {
    const select = document.getElementById('classe_id');
    const selectedOption = select.options[select.selectedIndex];
    
    if (selectedOption.value) {
        const frais = selectedOption.getAttribute('data-frais');
        document.getElementById('fraisInfo').classList.remove('d-none');
        document.getElementById('fraisMontant').textContent = formatNumber(frais);
    } else {
        document.getElementById('fraisInfo').classList.add('d-none');
    }
}

function formatNumber(num) {
    return parseFloat(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
}

// Charger les frais au chargement de la page si une classe est déjà sélectionnée
window.addEventListener('DOMContentLoaded', updateFrais);
</script>
@endpush
@endsection