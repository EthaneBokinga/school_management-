@extends('layouts.app')

@section('title', 'Mes Devoirs')
@section('page-title', 'Mes Devoirs')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <div class="card bg-gradient-warning text-white">
            <div class="card-body">
                <h4 class="mb-0"><i class="fas fa-tasks me-2"></i>Mes Devoirs</h4>
                <p class="mb-0 opacity-75">
                    {{ $inscription->classe->nom_classe }} - {{ $inscription->annee->libelle }}
                </p>
            </div>
        </div>
    </div>

    <!-- Devoirs à venir -->
    <div class="mb-4">
        <h5 class="mb-3">
            <i class="fas fa-clock text-warning me-2"></i>Devoirs à Venir
            <span class="badge bg-warning ms-2">{{ $devoirsAVenir->count() }}</span>
        </h5>

        @if($devoirsAVenir->count() > 0)
        <div class="row">
            @foreach($devoirsAVenir as $devoir)
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card h-100 border-warning">
                    <div class="card-header bg-warning text-white">
                        <div class="d-flex justify-content-between align-items-start">
                            <h6 class="mb-0">{{ $devoir->titre }}</h6>
                            @if(\Carbon\Carbon::parse($devoir->date_limite)->isToday())
                                <span class="badge bg-danger">Aujourd'hui !</span>
                            @elseif(\Carbon\Carbon::parse($devoir->date_limite)->isTomorrow())
                                <span class="badge bg-warning">Demain</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="mb-2">
                            <i class="fas fa-book text-primary me-2"></i>
                            <strong>{{ $devoir->cours->matiere->nom_matiere }}</strong>
                        </p>
                        <p class="mb-2 small text-muted">
                            <i class="fas fa-user me-1"></i>
                            {{ $devoir->cours->enseignant->nom_complet }}
                        </p>
                        
                        <hr>
                        
                        <div class="mb-2">
                            <strong>Consignes:</strong>
                            <p class="mb-0 small">{{ Str::limit($devoir->description, 150) }}</p>
                        </div>
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-calendar-alt text-danger me-1"></i>
                                <small><strong>{{ \Carbon\Carbon::parse($devoir->date_limite)->format('d/m/Y') }}</strong></small>
                            </div>
                            <div>
                                <span class="badge bg-info">
                                    {{ \Carbon\Carbon::parse($devoir->date_limite)->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light">
                        <button class="btn btn-sm btn-primary w-100" data-bs-toggle="modal" data-bs-target="#detailModal{{ $devoir->id }}">
                            <i class="fas fa-eye me-1"></i>Voir Détails
                        </button>
                    </div>
                </div>

                <!-- Modal détails -->
                <div class="modal fade" id="detailModal{{ $devoir->id }}" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-warning text-white">
                                <h5 class="modal-title">{{ $devoir->titre }}</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Matière:</strong> {{ $devoir->cours->matiere->nom_matiere }}</p>
                                <p><strong>Enseignant:</strong> {{ $devoir->cours->enseignant->nom_complet }}</p>
                                <p><strong>Date limite:</strong> {{ \Carbon\Carbon::parse($devoir->date_limite)->format('d/m/Y') }}</p>
                                
                                <hr>
                                
                                <h6>Consignes:</h6>
                                <p class="text-muted">{{ $devoir->description }}</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            Aucun devoir à venir. Profitez-en !
        </div>
        @endif
    </div>

    <!-- Devoirs passés -->
    <div>
        <h5 class="mb-3">
            <i class="fas fa-check-circle text-secondary me-2"></i>Devoirs Passés
            <span class="badge bg-secondary ms-2">{{ $devoirsPasses->count() }}</span>
        </h5>

        @if($devoirsPasses->count() > 0)
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Titre</th>
                                <th>Matière</th>
                                <th>Date Limite</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($devoirsPasses->take(10) as $devoir)
                            <tr>
                                <td>{{ $devoir->titre }}</td>
                                <td>{{ $devoir->cours->matiere->nom_matiere }}</td>
                                <td>{{ \Carbon\Carbon::parse($devoir->date_limite)->format('d/m/Y') }}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#detailModal{{ $devoir->id }}">
                                        <i class="fas fa-eye"></i> Voir
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal pour devoirs passés -->
                            <div class="modal fade" id="detailModal{{ $devoir->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-secondary text-white">
                                            <h5 class="modal-title">{{ $devoir->titre }}</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Matière:</strong> {{ $devoir->cours->matiere->nom_matiere }}</p>
                                            <p><strong>Date limite:</strong> {{ \Carbon\Carbon::parse($devoir->date_limite)->format('d/m/Y') }}</p>
                                            <hr>
                                            <p>{{ $devoir->description }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @else
        <div class="alert alert-secondary">
            Aucun devoir passé.
        </div>
        @endif
    </div>
</div>

<style>
.bg-gradient-warning {
    background: linear-gradient(135deg, #f6c23e 0%, #d4a017 100%);
}
</style>
@endsection