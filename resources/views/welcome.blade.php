<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>School Manager - Système de Gestion Scolaire</title>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
        
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 100px 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        
        .feature-card {
            transition: transform 0.3s;
            height: 100%;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
        }
        
        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-graduation-cap me-2"></i>School Manager
            </a>
            <div class="ms-auto">
                @auth
                    <a href="{{ url('/home') }}" class="btn btn-outline-light">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light me-2">
                        <i class="fas fa-sign-in-alt me-2"></i>Connexion
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">
                        Système de Gestion Scolaire Moderne
                    </h1>
                    <p class="lead mb-4">
                        Une solution complète pour gérer votre établissement scolaire : 
                        inscriptions, notes, absences, paiements et bien plus encore.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="{{ route('login') }}" class="btn btn-light btn-lg">
                            <i class="fas fa-sign-in-alt me-2"></i>Se Connecter
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <i class="fas fa-school" style="font-size: 15rem; opacity: 0.2;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="container my-5 py-5">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold">Fonctionnalités Principales</h2>
            <p class="lead text-muted">Tout ce dont vous avez besoin pour gérer votre école efficacement</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card feature-card border-0 shadow">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon text-primary">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <h5 class="card-title">Gestion des Élèves</h5>
                        <p class="card-text text-muted">
                            Inscriptions, réinscriptions, suivi académique complet et historique détaillé.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card feature-card border-0 shadow">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon text-success">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <h5 class="card-title">Gestion des Enseignants</h5>
                        <p class="card-text text-muted">
                            Attribution des cours, emploi du temps, saisie des notes et absences.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card feature-card border-0 shadow">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon text-info">
                            <i class="fas fa-star"></i>
                        </div>
                        <h5 class="card-title">Notes & Bulletins</h5>
                        <p class="card-text text-muted">
                            Saisie des notes, calcul automatique des moyennes, export PDF des bulletins.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card feature-card border-0 shadow">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon text-warning">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <h5 class="card-title">Gestion Financière</h5>
                        <p class="card-text text-muted">
                            Suivi des paiements, états financiers, relances automatiques.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card feature-card border-0 shadow">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon text-danger">
                            <i class="fas fa-user-times"></i>
                        </div>
                        <h5 class="card-title">Suivi des Absences</h5>
                        <p class="card-text text-muted">
                            Enregistrement des absences, justifications, statistiques détaillées.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card feature-card border-0 shadow">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon text-secondary">
                            <i class="fas fa-bell"></i>
                        </div>
                        <h5 class="card-title">Notifications</h5>
                        <p class="card-text text-muted">
                            Alertes en temps réel pour notes, absences, paiements et événements.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer py-4" style="background:#2f2f2f;color:#e9ecef;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-1">School Manager</h5>
                    <p class="mb-0" style="opacity:0.85;">Système de gestion scolaire complet développé avec Laravel.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="https://wa.me/066941947" target="_blank" rel="noopener noreferrer" class="btn btn-success btn-sm me-2">
                        <i class="fab fa-whatsapp me-1"></i>WhatsApp
                    </a>
                    <a href="https://www.facebook.com/" target="_blank" rel="noopener noreferrer" class="btn btn-primary btn-sm me-2" style="background:#1877f2;border-color:#1877f2;">
                        <i class="fab fa-facebook-f me-1"></i>Facebook
                    </a>
                    <a href="mailto:bokingaethanenathan@gmail.com" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-envelope me-1"></i>bokingaethanenathan@gmail.com
                    </a>
                    <p class="text-light mt-2 mb-0">© 2026 School Manager. Tous droits réservés.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>