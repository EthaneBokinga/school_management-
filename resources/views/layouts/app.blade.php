<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'School Management') }} - @yield('title')</title>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #858796;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
        }
        
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fc;
        }
        
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 1rem;
            transition: all 0.3s;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .sidebar .nav-link i {
            margin-right: 0.5rem;
            font-size: 0.85rem;
        }
        
        .navbar {
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        
        .card {
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            margin-bottom: 1.5rem;
        }
        
        .card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
            font-weight: 700;
            color: var(--primary-color);
        }
        
        .stat-card {
            border-left: 0.25rem solid;
        }
        
        .stat-card.primary {
            border-left-color: var(--primary-color);
        }
        
        .stat-card.success {
            border-left-color: var(--success-color);
        }
        
        .stat-card.info {
            border-left-color: var(--info-color);
        }
        
        .stat-card.warning {
            border-left-color: var(--warning-color);
        }
        
        .stat-card.danger {
            border-left-color: var(--danger-color);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2653d4;
        }
        
        .table {
            color: #858796;
        }
        
        .table thead th {
            border-bottom: 2px solid #e3e6f0;
            font-weight: 700;
            color: var(--primary-color);
        }
        
        .badge-status {
            padding: 0.4rem 0.8rem;
            font-size: 0.75rem;
            font-weight: 700;
        }
        
        .notification-badge {
            position: absolute;
            top: 0;
            right: 0;
            background-color: var(--danger-color);
            color: white;
            border-radius: 50%;
            padding: 0.2rem 0.5rem;
            font-size: 0.7rem;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div id="app">
        @auth
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                <nav class="col-md-2 d-md-block sidebar px-0">
                    <div class="position-sticky pt-3">
                        <div class="text-center mb-4">
                            <h5 class="text-white fw-bold">School Manager</h5>
                            <small class="text-white-50">{{ auth()->user()->role->nom_role }}</small>
                        </div>
                        
                        <ul class="nav flex-column">
                            @if(auth()->user()->isAdmin())
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-tachometer-alt"></i> Dashboard
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('admin.classes.*') ? 'active' : '' }}" href="{{ route('admin.classes.index') }}">
                                        <i class="fas fa-school"></i> Classes
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('admin.etudiants.*') ? 'active' : '' }}" href="{{ route('admin.etudiants.index') }}">
                                        <i class="fas fa-user-graduate"></i> Étudiants
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('admin.enseignants.*') ? 'active' : '' }}" href="{{ route('admin.enseignants.index') }}">
                                        <i class="fas fa-chalkboard-teacher"></i> Enseignants
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('admin.inscriptions.*') ? 'active' : '' }}" href="{{ route('admin.inscriptions.index') }}">
                                        <i class="fas fa-clipboard-list"></i> Inscriptions
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('admin.cours.*') ? 'active' : '' }}" href="{{ route('admin.cours.index') }}">
                                        <i class="fas fa-book"></i> Cours
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('admin.notes.*') ? 'active' : '' }}" href="{{ route('admin.notes.index') }}">
                                        <i class="fas fa-star"></i> Notes
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('admin.paiements.*') ? 'active' : '' }}" href="{{ route('admin.paiements.index') }}">
                                        <i class="fas fa-money-bill-wave"></i> Paiements
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('admin.absences.*') ? 'active' : '' }}" href="{{ route('admin.absences.index') }}">
                                        <i class="fas fa-user-times"></i> Absences
                                    </a>
                                </li>
                            @endif
                            
                            @if(auth()->user()->isProf())
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('prof.dashboard') ? 'active' : '' }}" href="{{ route('prof.dashboard') }}">
                                        <i class="fas fa-tachometer-alt"></i> Dashboard
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('prof.cours.*') ? 'active' : '' }}" href="{{ route('prof.cours.index') }}">
                                        <i class="fas fa-book"></i> Mes Cours
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('prof.notes.*') ? 'active' : '' }}" href="{{ route('prof.notes.index') }}">
                                        <i class="fas fa-star"></i> Notes
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('prof.absences.*') ? 'active' : '' }}" href="{{ route('prof.absences.index') }}">
                                        <i class="fas fa-user-times"></i> Absences
                                    </a>
                                </li>
                            @endif
                            
                            @if(auth()->user()->isEleve())
                             <!-- Bouton changement d'année -->
    <li class="nav-item mb-2">
        <a class="nav-link text-white bg-info" href="{{ route('eleve.selection-annee') }}">
            <i class="fas fa-sync-alt me-2"></i>Changer d'Année
        </a>
    </li>
    
    @if(session('inscription_selectionnee'))
        @php
            $inscriptionActive = \App\Models\Inscription::find(session('inscription_selectionnee'));
        @endphp
        <li class="nav-item mb-3">
            <div class="alert alert-info m-2 p-2 small">
                <strong>Année consultée:</strong><br>
                {{ $inscriptionActive->annee->libelle }}<br>
                <small>{{ $inscriptionActive->classe->nom_classe }}</small>
            </div>
        </li>
    @endif
    
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('eleve.dashboard') ? 'active' : '' }}" 
           href="{{ route('eleve.dashboard') }}">
            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
        </a>
    </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('eleve.dashboard') ? 'active' : '' }}" href="{{ route('eleve.dashboard') }}">
                                        <i class="fas fa-tachometer-alt"></i> Dashboard
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('eleve.notes.*') ? 'active' : '' }}" href="{{ route('eleve.notes.index') }}">
                                        <i class="fas fa-star"></i> Mes Notes
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('eleve.emploi.*') ? 'active' : '' }}" href="{{ route('eleve.emploi.index') }}">
                                        <i class="fas fa-calendar-alt"></i> Emploi du temps
                                    </a>
                                </li>
                            @endif
                            
                            <li class="nav-item mt-3">
                                <a class="nav-link {{ request()->routeIs('notifications.*') ? 'active' : '' }}" href="{{ route('notifications.index') }}">
                                    <i class="fas fa-bell"></i> Notifications
                                    <span class="notification-badge" id="notification-count"></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>

                <!-- Main Content -->
                <main class="col-md-10 ms-sm-auto px-md-4">
                    <!-- Top Navbar -->
                    <nav class="navbar navbar-expand-lg navbar-light bg-white mb-4 mt-3">
                        <div class="container-fluid">
                            <span class="navbar-brand mb-0 h1">@yield('page-title', 'Dashboard')</span>
                            
                            <div class="d-flex align-items-center">
                                <span class="me-3">{{ auth()->user()->name }}</span>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="fas fa-sign-out-alt"></i> Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                    </nav>

                    <!-- Messages Flash avec Toasts -->
@if(session('success'))
<div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
    <div class="toast show align-items-center text-white bg-success border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>
@endif

@if(session('error'))
<div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
    <div class="toast show align-items-center text-white bg-danger border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>
@endif

@if(session('warning'))
<div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
    <div class="toast show align-items-center text-white bg-warning border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body">
                <i class="fas fa-exclamation-triangle me-2"></i>{{ session('warning') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>
@endif

@if($errors->any())
<div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
    <div class="toast show align-items-center text-white bg-danger border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body">
                <i class="fas fa-exclamation-circle me-2"></i>
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>
@endif

                    <!-- Alerts -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Page Content -->
                    @yield('content')
                </main>
            </div>
        </div>
        @else
        <main class="py-4">
            @yield('content')
        </main>
        @endauth
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery (pour faciliter les requêtes AJAX) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        // Charger le compteur de notifications
        @auth
        function loadNotificationCount() {
            fetch('{{ route("notifications.count") }}')
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('notification-count');
                    if (data.count > 0) {
                        badge.textContent = data.count;
                        badge.style.display = 'inline-block';
                    } else {
                        badge.style.display = 'none';
                    }
                });
        }
        
        // Charger au démarrage
        loadNotificationCount();
        
        // Actualiser toutes les 30 secondes
        setInterval(loadNotificationCount, 30000);
        @endauth
    </script>
    
    @stack('scripts')

    <script>
// Auto-hide toasts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    var toasts = document.querySelectorAll('.toast');
    toasts.forEach(function(toast) {
        setTimeout(function() {
            toast.classList.remove('show');
        }, 5000);
    });
});
</script>
</body>
</html>