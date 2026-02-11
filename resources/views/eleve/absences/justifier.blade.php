@extends('layouts.app')

@section('title', 'Justifier Absence')
@section('page-title', 'Justifier mon Absence')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <i class="fas fa-file-upload me-2"></i>Justifier mon Absence
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <strong>Date de l'absence:</strong> {{ \Carbon\Carbon::parse($absence->date_absence)->format('d/m/Y') }}<br>
                        <strong>Cours:</strong> {{ $absence->cours->matiere->nom_matiere ?? 'Non spécifié' }}
                    </div>

                    <form action="{{ route('eleve.absences.store-justification', $absence->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="motif_justification" class="form-label">Motif de l'Absence <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('motif_justification') is-invalid @enderror" 
                                      id="motif_justification" name="motif_justification" rows="5" required>{{ old('motif_justification') }}</textarea>
                            @error('motif_justification')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Expliquez la raison de votre absence (maladie, rendez-vous médical, etc.)</small>
                        </div>

                        <div class="mb-3">
                            <label for="fichier_justificatif" class="form-label">Pièce Justificative (optionnel)</label>
                            <input type="file" class="form-control @error('fichier_justificatif') is-invalid @enderror" 
                                   id="fichier_justificatif" name="fichier_justificatif" 
                                   accept=".pdf,.jpg,.jpeg,.png">
                            @error('fichier_justificatif')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Certificat médical, justificatif de rendez-vous, etc. (PDF, JPG, PNG - Max: 5MB)</small>
                        </div>

                        <div class="alert alert-warning">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Important:</strong> Votre justification sera examinée par l'administration. Vous serez notifié une fois validée.
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('eleve.absences.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Retour
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-paper-plane me-2"></i>Envoyer la Justification
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection