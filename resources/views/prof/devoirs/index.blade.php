@extends('layouts.app')

@section('title', 'Mes Devoirs')
@section('page-title', 'Gestion des Devoirs')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            <i class="fas fa-tasks me-2"></i>Mes Devoirs Programmés
        </h4>
        <a href="{{ route('prof.devoirs.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Programmer un Devoir
        </a>
    </div>

    <!-- Filtres -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <select class="form-select" id="filterStatut">
                        <option value="">Tous les statuts</option>
                        <option value="À venir">À venir</option>
                        <option value="En cours">En cours</option>
                        <option value="Terminé">Terminé</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @forelse($devoirs as $devoir)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 devoir-card" data-statut="{{ \Carbon\Carbon::parse($devoir->date_limite)->isPast() ? 'Terminé' : (\Carbon\Carbon::parse($devoir->date_limite)->isToday() ? 'En cours' : 'À venir') }}">
                <div class="card-header {{ \Carbon\Carbon::parse($devoir->date_limite)->isPast() ? 'bg-secondary' : 'bg-primary' }} text-white">
                    <div class="d-flex justify-content-between align-items-start">
                        <h6 class="mb-0">{{ $devoir->titre }}</h6>
                        <span class="badge bg-light text-dark">
                            {{ $devoir->cours->classe->nom_classe }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <p class="mb-2">
                        <i class="fas fa-book text-primary me-2"></i>
                        <strong>{{ $devoir->cours->matiere->nom_matiere }}</strong>
                    </p>
                    <p class="text-muted small mb-3">{{ Str::limit($devoir->description, 100) }}</p>
                    
                    <div class="mb-2">
                        <i class="fas fa-calendar-alt me-2 {{ \Carbon\Carbon::parse($devoir->date_limite)->isPast() ? 'text-secondary' : 'text-danger' }}"></i>
                        <strong>Date limite:</strong> {{ \Carbon\Carbon::parse($devoir->date_limite)->format('d/m/Y') }}
                    </div>
                    
                    @if(\Carbon\Carbon::parse($devoir->date_limite)->isPast())
                        <span class="badge bg-secondary">Terminé</span>
                    @elseif(\Carbon\Carbon::parse($devoir->date_limite)->isToday())
                        <span class="badge bg-warning">Aujourd'hui !</span>
                    @else
                        <span class="badge bg-success">Dans {{ \Carbon\Carbon::parse($devoir->date_limite)->diffForHumans() }}</span>
                    @endif
                </div>
                <div class="card-footer bg-light">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('prof.devoirs.show', $devoir->id) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i> Voir
                        </a>
                        <div>
                            <a href="{{ route('prof.devoirs.edit', $devoir->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $devoir->id }})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    
                    <form id="delete-form-{{ $devoir->id }}" action="{{ route('prof.devoirs.destroy', $devoir->id) }}" method="POST" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-clipboard fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">Aucun devoir programmé</h5>
                    <p class="text-muted">Cliquez sur "Programmer un Devoir" pour commencer</p>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    <div class="mt-3">
        {{ $devoirs->links() }}
    </div>
</div>

@push('scripts')
<script>
function confirmDelete(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce devoir?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}

// Filtre par statut
document.getElementById('filterStatut').addEventListener('change', function() {
    const statut = this.value;
    const cards = document.querySelectorAll('.devoir-card');
    
    cards.forEach(card => {
        if (!statut || card.dataset.statut === statut) {
            card.closest('.col-md-6').style.display = '';
        } else {
            card.closest('.col-md-6').style.display = 'none';
        }
    });
});
</script>
@endpush
@endsection