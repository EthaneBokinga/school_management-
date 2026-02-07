@extends('layouts.app')

@section('title', 'Notifications')
@section('page-title', 'Mes Notifications')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-bell me-2"></i>Toutes mes notifications</span>
                    @if($notifications->where('lu', false)->count() > 0)
                    <span class="badge bg-danger">{{ $notifications->where('lu', false)->count() }} non lue(s)</span>
                    @endif
                </div>
                <div class="card-body p-0">
                    @forelse($notifications as $notification)
                    <div class="notification-item {{ !$notification->lu ? 'notification-unread' : '' }}" data-id="{{ $notification->id }}">
                        <div class="d-flex align-items-start p-3 border-bottom">
                            <div class="notification-icon me-3">
                                <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" 
                                     style="width: 50px; height: 50px;">
                                    <i class="fas fa-bell text-primary"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <h6 class="mb-0 {{ !$notification->lu ? 'fw-bold' : '' }}">
                                        {{ $notification->titre }}
                                    </h6>
                                    <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-1 text-muted">{{ $notification->message }}</p>
                                @if(!$notification->lu)
                                <button class="btn btn-sm btn-outline-primary mark-as-read" data-id="{{ $notification->id }}">
                                    <i class="fas fa-check me-1"></i>Marquer comme lu
                                </button>
                                @else
                                <small class="text-success">
                                    <i class="fas fa-check-circle me-1"></i>Lu
                                </small>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">Aucune notification</h5>
                        <p class="text-muted">Vous n'avez pas encore reçu de notifications.</p>
                    </div>
                    @endforelse
                </div>
                
                @if($notifications->count() > 0)
                <div class="card-footer">
                    {{ $notifications->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.notification-unread {
    background-color: #f0f8ff;
}

.notification-item {
    transition: background-color 0.3s;
}

.notification-item:hover {
    background-color: #f8f9fc;
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const markAsReadButtons = document.querySelectorAll('.mark-as-read');
    
    markAsReadButtons.forEach(button => {
        button.addEventListener('click', function() {
            const notificationId = this.getAttribute('data-id');
            
            fetch(`/notifications/${notificationId}/marquer-lu`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    const notificationItem = document.querySelector(`.notification-item[data-id="${notificationId}"]`);
                    notificationItem.classList.remove('notification-unread');
                    
                    this.outerHTML = '<small class="text-success"><i class="fas fa-check-circle me-1"></i>Lu</small>';
                    
                    // Actualiser le compteur
                    loadNotificationCount();
                }
            })
            .catch(error => console.error('Erreur:', error));
        });
    });
});
</script>
@endpush
@endsection