@extends('layouts.app')

@section('title', 'Nouveau Paiement')
@section('page-title', 'Enregistrer un Paiement')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-money-bill-wave me-2"></i>Formulaire d'Enregistrement de Paiement
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.paiements.store') }}" method="POST" id="paiementForm">
                        @csrf

                        <div class="mb-3">
                            <label for="inscription_id" class="form-label">Étudiant / Inscription <span class="text-danger">*</span></label>
                            <select class="form-select @error('inscription_id') is-invalid @enderror" 
                                    id="inscription_id" name="inscription_id" required onchange="updateFraisInfo()">
                                <option value="">-- Sélectionner un étudiant --</option>
                                @foreach($inscriptions as $inscription)
                                <option value="{{ $inscription->id }}" 
                                        data-frais="{{ $inscription->classe->frais_scolarite }}"
                                        data-paye="{{ $inscription->montant_total_paye }}"
                                        {{ old('inscription_id') == $inscription->id ? 'selected' : '' }}>
                                    {{ $inscription->etudiant->nom_complet }} 
                                    ({{ $inscription->etudiant->matricule }}) - 
                                    {{ $inscription->classe->nom_classe }} - 
                                    Statut: {{ $inscription->statut_paiement }}
                                </option>
                                @endforeach
                            </select>
                            @error('inscription_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Informations de paiement -->
                        <div id="fraisInfo" class="alert alert-info d-none">
                            <h6 class="alert-heading">Informations de Paiement</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <small class="text-muted">Frais de Scolarité:</small>
                                    <p class="mb-0 fw-bold" id="fraisTotaux">-</p>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted">Déjà Payé:</small>
                                    <p class="mb-0 fw-bold text-success" id="dejaPaye">-</p>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted">Reste à Payer:</small>
                                    <p class="mb-0 fw-bold text-danger" id="resteAPayer">-</p>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="montant_paye" class="form-label">Montant à Payer (FCFA) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('montant_paye') is-invalid @enderror" 
                                   id="montant_paye" name="montant_paye" value="{{ old('montant_paye') }}" 
                                   placeholder="Exemple: 50000" required min="0" step="1">
                            @error('montant_paye')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Entrez le montant en francs CFA</small>
                        </div>

                        <div class="alert alert-warning">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Note:</strong> Le statut de paiement de l'inscription sera automatiquement mis à jour.
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.paiements.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Retour
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Enregistrer le Paiement
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
function updateFraisInfo() {
    const select = document.getElementById('inscription_id');
    const selectedOption = select.options[select.selectedIndex];
    
    if (selectedOption.value) {
        const fraisTotaux = parseFloat(selectedOption.getAttribute('data-frais'));
        const dejaPaye = parseFloat(selectedOption.getAttribute('data-paye'));
        const resteAPayer = fraisTotaux - dejaPaye;
        
        document.getElementById('fraisInfo').classList.remove('d-none');
        document.getElementById('fraisTotaux').textContent = formatNumber(fraisTotaux) + ' FCFA';
        document.getElementById('dejaPaye').textContent = formatNumber(dejaPaye) + ' FCFA';
        document.getElementById('resteAPayer').textContent = formatNumber(resteAPayer) + ' FCFA';
        
        // Suggérer le montant restant
        document.getElementById('montant_paye').setAttribute('max', resteAPayer);
    } else {
        document.getElementById('fraisInfo').classList.add('d-none');
    }
}

function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
}
</script>
@endpush
@endsection