@extends('layouts.app')

@section('title', 'Détails Absence')
@section('page-title', 'Détails de l\'Absence')

@section('content')
<div class="container-fluid">
    <div class="mb-3">
        <a href="{{ route('admin.absences.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Retour
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-{{ $absence->est_justifie ? 'success' : 'danger' }} text-white">
                    <i class="fas fa-user-times me-2"></i>Informations de l'Absence
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 200px;">Date d'Absence:</th>
                            <td>
                                <strong>{{ \Carbon\Carbon::parse($absence->date_absence)->format('d/m/Y') }}</strong>
                                <br>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($absence->date_absence)->diffForHumans() }}</small>
                            </td>
                        </tr>
                        <tr>
                            <th>Étudiant:</th>
                            <td>
                                <strong>{{ $absence->inscription->etudiant->nom_complet }}</strong>
                                <br>
                                <small class="text-muted">{{ $absence->inscription->etudiant->matricule }}</small>
                            </td>
                        </tr>
                        <tr>
                            <th>Classe:</th>
                            <td>
                                <span class="badge bg-info">{{ $absence->inscription->classe->nom_classe }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Cours:</th>
                            <td>
                                @if($absence->cours)
                                    <strong>{{ $absence->cours->matiere->nom_matiere }}</strong>
                                    <br>
                                    <small class="text-muted">Enseignant: {{ $absence->cours->enseignant->nom_complet }}</small>
                                @else
                                    <span class="text-muted">Absence générale (non liée à un cours)</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Statut:</th>
                            <td>
                                @if($absence->est_justifie)
                                    <span class="badge bg-success fs-6">
                                        <i class="fas fa-check-circle me-1"></i>Absence Justifiée
                                    </span>
                                @else
                                    <span class="badge bg-danger fs-6">
                                        <i class="fas fa-times-circle me-1"></i>Absence Non Justifiée
                                    </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Enregistrée le:</th>
                            <td>{{ $absence->created_at->format('d/m/Y à H:i') }}</td>
                        </tr>
                    </table>

                    <hr>

                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.absences.edit', $absence->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Modifier
                        </a>
                        <form action="{{ route('admin.absences.destroy', $absence->id) }}" method="POST" 
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette absence?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash me-2"></i>Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection