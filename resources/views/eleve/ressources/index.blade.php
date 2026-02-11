@extends('layouts.app')

@section('title', 'Ressources Pédagogiques')
@section('page-title', 'Ressources Pédagogiques')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-book me-2"></i>Ressources Pédagogiques
                    </h5>
                </div>
                <div class="card-body">
                    @if($ressourcesParMatiere->isEmpty())
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Aucune ressource disponible pour le moment.
                        </div>
                    @else
                        @foreach($ressourcesParMatiere as $matiere => $ressources)
                            <div class="mb-4">
                                <h6 class="border-bottom pb-2 mb-3">
                                    <i class="fas fa-folder me-2"></i>{{ $matiere }}
                                </h6>
                                <div class="row">
                                    @foreach($ressources as $ressource)
                                        <div class="col-md-6 mb-3">
                                            <div class="card border-left-primary h-100">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-start">
                                                        <div>
                                                            <h6 class="font-weight-bold mb-1">{{ $ressource->titre }}</h6>
                                                            <p class="text-muted small mb-2">
                                                                {{ $ressource->cours->enseignant->prenom }} {{ $ressource->cours->enseignant->nom }}
                                                            </p>
                                                            <p class="small">{{ Str::limit($ressource->description, 100) }}</p>
                                                        </div>
                                                    </div>
                                                    @if($ressource->url_fichier)
                                                        <a href="{{ asset('storage/' . $ressource->url_fichier) }}" download class="btn btn-sm btn-primary">
                                                            <i class="fas fa-download me-1"></i>Télécharger
                                                        </a>
                                                    @endif
                                                    <small class="text-muted d-block mt-2">
                                                        {{ $ressource->created_at->format('d/m/Y H:i') }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .border-left-primary {
        border-left: 0.25rem solid #4e73df !important;
    }
</style>
@endsection
