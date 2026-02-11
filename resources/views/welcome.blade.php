<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>School Manager — Gestion Scolaire</title>

    <!-- Fonts premium -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --ink:      #0D1117;
            --ink-soft: #1C2333;
            --ink-mid:  #2D3748;
            --gold:     #C9A84C;
            --gold-lt:  #E2C97E;
            --cream:    #F5F0E8;
            --text:     #E8E2D9;
            --muted:    #8B95A6;
            --border:   rgba(201,168,76,.18);
            --glow:     rgba(201,168,76,.08);
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--ink);
            color: var(--text);
            overflow-x: hidden;
        }

        /* ─── BRUIT DE FOND ─── */
        body::before {
            content: '';
            position: fixed; inset: 0; z-index: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.03'/%3E%3C/svg%3E");
            pointer-events: none; opacity: .6;
        }

        /* ─── NAVBAR ─── */
        nav {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            display: flex; align-items: center; justify-content: space-between;
            padding: 1.25rem 4rem;
            border-bottom: 1px solid var(--border);
            background: rgba(13,17,23,.82);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
        }

        .nav-logo {
            display: flex; align-items: center; gap: .75rem;
            text-decoration: none;
        }

        .nav-logo-icon {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, var(--gold), var(--gold-lt));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: .9rem; color: var(--ink);
        }

        .nav-logo-text {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem; font-weight: 600;
            color: var(--cream); letter-spacing: .02em;
        }

        .nav-logo-text span { color: var(--gold); }

        .nav-cta {
            display: flex; align-items: center; gap: .5rem;
            padding: .6rem 1.6rem;
            background: transparent;
            border: 1px solid var(--gold);
            border-radius: 50px;
            color: var(--gold);
            font-family: 'DM Sans', sans-serif;
            font-size: .875rem; font-weight: 500;
            text-decoration: none;
            letter-spacing: .04em;
            transition: all .3s ease;
        }

        .nav-cta:hover {
            background: var(--gold);
            color: var(--ink);
            box-shadow: 0 0 28px rgba(201,168,76,.35);
        }

        /* ─── HERO ─── */
        .hero {
            position: relative; min-height: 100vh;
            display: flex; align-items: center;
            padding: 0 4rem;
            overflow: hidden;
        }

        /* Orbes de fond */
        .hero::after {
            content: '';
            position: absolute; top: -20%; right: -10%;
            width: 700px; height: 700px;
            background: radial-gradient(circle, rgba(201,168,76,.07) 0%, transparent 70%);
            border-radius: 50%; pointer-events: none;
            animation: pulse 8s ease-in-out infinite;
        }

        .orb-bottom {
            position: absolute; bottom: -10%; left: -5%;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(201,168,76,.04) 0%, transparent 70%);
            border-radius: 50%; pointer-events: none;
            animation: pulse 10s ease-in-out infinite reverse;
        }

        @keyframes pulse {
            0%,100% { transform: scale(1); opacity: 1; }
            50%      { transform: scale(1.08); opacity: .7; }
        }

        .hero-content {
            position: relative; z-index: 1;
            max-width: 680px;
            animation: fadeUp .9s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .hero-badge {
            display: inline-flex; align-items: center; gap: .5rem;
            padding: .4rem 1rem;
            border: 1px solid var(--border);
            border-radius: 50px;
            background: var(--glow);
            font-size: .78rem; color: var(--gold);
            letter-spacing: .08em; text-transform: uppercase;
            margin-bottom: 2rem;
            animation: fadeUp .9s .1s ease both;
        }

        .hero-badge::before {
            content: '';
            width: 6px; height: 6px;
            background: var(--gold);
            border-radius: 50%;
            animation: blink 2s ease-in-out infinite;
        }

        @keyframes blink {
            0%,100% { opacity: 1; } 50% { opacity: .3; }
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.8rem, 5vw, 4.2rem);
            font-weight: 700;
            line-height: 1.12;
            color: var(--cream);
            margin-bottom: 1.5rem;
            animation: fadeUp .9s .2s ease both;
        }

        .hero-title em {
            font-style: normal;
            background: linear-gradient(90deg, var(--gold), var(--gold-lt));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-desc {
            font-size: 1.05rem; font-weight: 300;
            color: var(--muted);
            line-height: 1.75;
            max-width: 520px;
            margin-bottom: 2.5rem;
            animation: fadeUp .9s .3s ease both;
        }

        .hero-actions {
            display: flex; align-items: center; gap: 1.25rem;
            animation: fadeUp .9s .4s ease both;
        }

        .btn-primary-gold {
            display: inline-flex; align-items: center; gap: .6rem;
            padding: .85rem 2.2rem;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-lt) 100%);
            color: var(--ink);
            font-family: 'DM Sans', sans-serif;
            font-size: .9rem; font-weight: 600;
            text-decoration: none;
            border-radius: 50px;
            letter-spacing: .03em;
            transition: all .3s ease;
            box-shadow: 0 4px 24px rgba(201,168,76,.28);
        }

        .btn-primary-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 36px rgba(201,168,76,.42);
        }

        .btn-ghost {
            display: inline-flex; align-items: center; gap: .5rem;
            color: var(--muted);
            font-size: .875rem; font-weight: 400;
            text-decoration: none;
            transition: color .25s;
        }

        .btn-ghost:hover { color: var(--cream); }

        /* ─── HERO VISUAL (droite) ─── */
        .hero-visual {
            position: absolute; right: 3rem; top: 50%;
            transform: translateY(-50%);
            z-index: 1;
            animation: fadeUp .9s .5s ease both;
        }

        .stat-cards-stack {
            display: flex; flex-direction: column; gap: 1rem;
            align-items: flex-end;
        }

        .stat-card {
            background: var(--ink-soft);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.1rem 1.4rem;
            display: flex; align-items: center; gap: 1rem;
            min-width: 220px;
            backdrop-filter: blur(8px);
            transition: transform .3s, box-shadow .3s;
        }

        .stat-card:hover {
            transform: translateX(-6px);
            box-shadow: 0 8px 30px rgba(0,0,0,.3);
        }

        .stat-card:nth-child(2) { margin-right: 1.5rem; }

        .stat-icon {
            width: 44px; height: 44px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem; flex-shrink: 0;
        }

        .stat-icon.gold { background: rgba(201,168,76,.15); color: var(--gold); }
        .stat-icon.teal { background: rgba(45,206,204,.12); color: #2DCECC; }
        .stat-icon.rose { background: rgba(240,101,149,.12); color: #F06595; }

        .stat-info small {
            display: block; font-size: .72rem;
            color: var(--muted); letter-spacing: .06em;
            text-transform: uppercase; margin-bottom: .2rem;
        }

        .stat-info strong {
            font-size: 1.15rem; font-weight: 600; color: var(--cream);
        }

        /* ─── DIVIDER ─── */
        .section-divider {
            position: relative;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--border), transparent);
            margin: 0 4rem;
        }

        /* ─── FEATURES ─── */
        .features {
            padding: 6rem 4rem;
            position: relative; z-index: 1;
        }

        .section-label {
            text-align: center;
            font-size: .75rem; letter-spacing: .14em;
            text-transform: uppercase; color: var(--gold);
            margin-bottom: .8rem;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.8rem, 3vw, 2.6rem);
            font-weight: 600;
            text-align: center;
            color: var(--cream);
            margin-bottom: .75rem;
        }

        .section-sub {
            text-align: center;
            color: var(--muted); font-weight: 300;
            max-width: 480px; margin: 0 auto 3.5rem;
            line-height: 1.7;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            max-width: 1100px; margin: 0 auto;
        }

        .feature-card {
            background: var(--ink-soft);
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 2rem;
            position: relative;
            overflow: hidden;
            transition: transform .35s, border-color .35s, box-shadow .35s;
        }

        .feature-card::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            opacity: 0;
            transition: opacity .35s;
        }

        .feature-card:hover {
            transform: translateY(-6px);
            border-color: rgba(201,168,76,.32);
            box-shadow: 0 16px 48px rgba(0,0,0,.35);
        }

        .feature-card:hover::before { opacity: 1; }

        .feature-num {
            font-family: 'Playfair Display', serif;
            font-size: 3rem; font-weight: 700;
            color: rgba(201,168,76,.1);
            line-height: 1;
            margin-bottom: .75rem;
            transition: color .35s;
        }

        .feature-card:hover .feature-num { color: rgba(201,168,76,.2); }

        .feature-icon-wrap {
            width: 46px; height: 46px;
            background: var(--glow);
            border: 1px solid var(--border);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            color: var(--gold); font-size: 1.05rem;
            margin-bottom: 1.1rem;
        }

        .feature-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.05rem; font-weight: 600;
            color: var(--cream); margin-bottom: .6rem;
        }

        .feature-desc {
            font-size: .875rem; color: var(--muted);
            line-height: 1.65; font-weight: 300;
        }

        /* ─── ROLES SECTION ─── */
        .roles {
            padding: 5rem 4rem;
            position: relative; z-index: 1;
        }

        .roles-grid {
            display: grid; grid-template-columns: repeat(3,1fr);
            gap: 1.5rem; max-width: 1100px; margin: 0 auto;
        }

        .role-card {
            border-radius: 20px;
            padding: 2.2rem;
            text-align: center;
            border: 1px solid var(--border);
            transition: transform .3s, box-shadow .3s;
            position: relative; overflow: hidden;
        }

        .role-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 50px rgba(0,0,0,.4);
        }

        .role-card.admin-card {
            background: linear-gradient(145deg, #1a2035 0%, var(--ink-soft) 100%);
        }

        .role-card.prof-card {
            background: linear-gradient(145deg, #0d1f1f 0%, var(--ink-soft) 100%);
        }

        .role-card.eleve-card {
            background: linear-gradient(145deg, #1f1020 0%, var(--ink-soft) 100%);
        }

        .role-avatar {
            width: 70px; height: 70px;
            border-radius: 50%;
            margin: 0 auto 1.2rem;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.6rem;
        }

        .role-avatar.admin { background: rgba(201,168,76,.15); color: var(--gold); border: 1.5px solid rgba(201,168,76,.3); }
        .role-avatar.prof  { background: rgba(45,206,204,.12); color: #2DCECC; border: 1.5px solid rgba(45,206,204,.3); }
        .role-avatar.eleve { background: rgba(240,101,149,.12); color: #F06595; border: 1.5px solid rgba(240,101,149,.3); }

        .role-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.15rem; font-weight: 600;
            color: var(--cream); margin-bottom: .5rem;
        }

        .role-desc {
            font-size: .85rem; color: var(--muted);
            line-height: 1.6; font-weight: 300;
        }

        .role-features {
            margin-top: 1.2rem;
            display: flex; flex-direction: column; gap: .5rem;
            text-align: left;
        }

        .role-feature-item {
            display: flex; align-items: center; gap: .6rem;
            font-size: .82rem; color: var(--muted);
        }

        .role-feature-item i { font-size: .65rem; color: var(--gold); }

        /* ─── CTA FINAL ─── */
        .cta-section {
            padding: 6rem 4rem;
            text-align: center;
            position: relative; z-index: 1;
        }

        .cta-box {
            max-width: 680px; margin: 0 auto;
            background: var(--ink-soft);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 4rem 3rem;
            position: relative;
            overflow: hidden;
        }

        .cta-box::before {
            content: '';
            position: absolute; top: 0; left: 50%; transform: translateX(-50%);
            width: 60%; height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
        }

        .cta-box-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.5rem, 3vw, 2.2rem);
            font-weight: 700; color: var(--cream);
            margin-bottom: .8rem;
        }

        .cta-box-sub {
            color: var(--muted); font-weight: 300;
            line-height: 1.7; margin-bottom: 2.2rem;
        }

        /* ─── FOOTER ─── */
        footer {
            padding: 2rem 4rem;
            border-top: 1px solid var(--border);
            display: flex; justify-content: space-between; align-items: center;
            position: relative; z-index: 1;
        }

        .footer-logo {
            font-family: 'Playfair Display', serif;
            font-size: 1rem; color: var(--muted);
        }

        .footer-logo span { color: var(--gold); }

        .footer-copy {
            font-size: .8rem; color: var(--muted);
            letter-spacing: .03em;
        }

        /* ─── RESPONSIVE ─── */
        @media (max-width: 1024px) {
            nav, .hero, .features, .roles, .cta-section, footer { padding-left: 2rem; padding-right: 2rem; }
            .features-grid, .roles-grid { grid-template-columns: 1fr 1fr; }
            .hero-visual { display: none; }
        }

        @media (max-width: 640px) {
            nav { padding: 1rem 1.5rem; }
            .hero { padding: 6rem 1.5rem 3rem; min-height: auto; }
            .features, .roles, .cta-section { padding: 4rem 1.5rem; }
            footer { flex-direction: column; gap: .75rem; text-align: center; }
            .features-grid, .roles-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<!-- ─── ORBE BAS ─── -->
<div class="orb-bottom"></div>

<!-- ─── NAVBAR ─── -->
<nav>
    <a href="#" class="nav-logo">
        <div class="nav-logo-icon">
            <i class="fas fa-graduation-cap"></i>
        </div>
        <span class="nav-logo-text">School<span>Manager</span></span>
    </a>
    @auth
        <a href="{{ url('/home') }}" class="nav-cta">
            <i class="fas fa-tachometer-alt"></i>
            Dashboard
        </a>
    @else
        <a href="{{ route('login') }}" class="nav-cta">
            <i class="fas fa-sign-in-alt"></i>
            Connexion
        </a>
    @endauth
</nav>

<!-- ─── HERO ─── -->
<section class="hero">
    <div class="hero-content">
        <div class="hero-badge">
            <span>Plateforme Éducative</span>
        </div>

        <h1 class="hero-title">
            Gérez votre école avec<br>
            une <em>précision absolue</em>
        </h1>

        <p class="hero-desc">
            Une solution complète et élégante pour les établissements modernes.
            Administration, enseignants et élèves — tous connectés, tout simplifié.
        </p>

        <div class="hero-actions">
            <a href="{{ route('login') }}" class="btn-primary-gold">
                <i class="fas fa-sign-in-alt"></i>
                Accéder à la plateforme
            </a>
            <a href="#fonctionnalites" class="btn-ghost">
                Découvrir
                <i class="fas fa-arrow-down"></i>
            </a>
        </div>
    </div>

    <!-- Cartes stats flottantes -->
    <div class="hero-visual">
        <div class="stat-cards-stack">
            <div class="stat-card">
                <div class="stat-icon gold">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <small>Étudiants gérés</small>
                    <strong>Multi-niveaux</strong>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon teal">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-info">
                    <small>Suivi académique</small>
                    <strong>Temps réel</strong>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon rose">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div class="stat-info">
                    <small>Accès sécurisé</small>
                    <strong>3 rôles distincts</strong>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="section-divider"></div>

<!-- ─── FEATURES ─── -->
<section class="features" id="fonctionnalites">
    <p class="section-label">Fonctionnalités</p>
    <h2 class="section-title">Tout ce dont vous avez besoin</h2>
    <p class="section-sub">Des outils pensés pour simplifier chaque aspect de la vie scolaire, sans compromis.</p>

    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-num">01</div>
            <div class="feature-icon-wrap"><i class="fas fa-user-graduate"></i></div>
            <div class="feature-name">Gestion des Élèves</div>
            <div class="feature-desc">Inscriptions, réinscriptions, suivi complet et historique académique année par année.</div>
        </div>
        <div class="feature-card">
            <div class="feature-num">02</div>
            <div class="feature-icon-wrap"><i class="fas fa-star"></i></div>
            <div class="feature-name">Notes & Bulletins</div>
            <div class="feature-desc">Saisie des notes, calcul automatique des moyennes avec coefficients, export PDF des bulletins.</div>
        </div>
        <div class="feature-card">
            <div class="feature-num">03</div>
            <div class="feature-icon-wrap"><i class="fas fa-money-bill-wave"></i></div>
            <div class="feature-name">Gestion Financière</div>
            <div class="feature-desc">Suivi des paiements, échéances mensuelles, états financiers et relances automatiques.</div>
        </div>
        <div class="feature-card">
            <div class="feature-num">04</div>
            <div class="feature-icon-wrap"><i class="fas fa-calendar-alt"></i></div>
            <div class="feature-name">Emplois du Temps</div>
            <div class="feature-desc">Planification hebdomadaire par classe et par enseignant, vue tableau et vue quotidienne.</div>
        </div>
        <div class="feature-card">
            <div class="feature-num">05</div>
            <div class="feature-icon-wrap"><i class="fas fa-folder-open"></i></div>
            <div class="feature-name">Ressources Pédagogiques</div>
            <div class="feature-desc">Upload de cours par les professeurs, téléchargement par les élèves par matière.</div>
        </div>
        <div class="feature-card">
            <div class="feature-num">06</div>
            <div class="feature-icon-wrap"><i class="fas fa-bell"></i></div>
            <div class="feature-name">Notifications</div>
            <div class="feature-desc">Alertes en temps réel pour notes, absences, devoirs et examens pour chaque utilisateur.</div>
        </div>
    </div>
</section>

<div class="section-divider"></div>

<!-- ─── ROLES ─── -->
<section class="roles">
    <p class="section-label">Espaces dédiés</p>
    <h2 class="section-title">Une interface pour chaque rôle</h2>
    <p class="section-sub">Chaque utilisateur accède à un espace personnalisé et sécurisé selon son profil.</p>

    <div class="roles-grid">
        <!-- Admin -->
        <div class="role-card admin-card">
            <div class="role-avatar admin">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="role-title">Administrateur</div>
            <div class="role-desc">Pilotage complet de l'établissement depuis un tableau de bord unifié.</div>
            <div class="role-features">
                <div class="role-feature-item"><i class="fas fa-circle"></i>Gestion des inscriptions</div>
                <div class="role-feature-item"><i class="fas fa-circle"></i>Suivi des paiements</div>
                <div class="role-feature-item"><i class="fas fa-circle"></i>Configuration des cours</div>
                <div class="role-feature-item"><i class="fas fa-circle"></i>Rapports & statistiques</div>
            </div>
        </div>

        <!-- Prof -->
        <div class="role-card prof-card">
            <div class="role-avatar prof">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div class="role-title">Professeur</div>
            <div class="role-desc">Gérez vos classes, notez vos élèves et partagez vos ressources.</div>
            <div class="role-features">
                <div class="role-feature-item"><i class="fas fa-circle"></i>Saisie des notes</div>
                <div class="role-feature-item"><i class="fas fa-circle"></i>Suivi des absences</div>
                <div class="role-feature-item"><i class="fas fa-circle"></i>Upload de cours</div>
                <div class="role-feature-item"><i class="fas fa-circle"></i>Programmation examens</div>
            </div>
        </div>

        <!-- Élève -->
        <div class="role-card eleve-card">
            <div class="role-avatar eleve">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div class="role-title">Élève</div>
            <div class="role-desc">Consultez vos résultats, cours et informations académiques à tout moment.</div>
            <div class="role-features">
                <div class="role-feature-item"><i class="fas fa-circle"></i>Consultation des notes</div>
                <div class="role-feature-item"><i class="fas fa-circle"></i>Emploi du temps</div>
                <div class="role-feature-item"><i class="fas fa-circle"></i>Téléchargement des cours</div>
                <div class="role-feature-item"><i class="fas fa-circle"></i>Justification d'absences</div>
            </div>
        </div>
    </div>
</section>

<!-- ─── CTA FINAL ─── -->
<section class="cta-section">
    <div class="cta-box">
        <h2 class="cta-box-title">Prêt à commencer ?</h2>
        <p class="cta-box-sub">
            Connectez-vous dès maintenant et accédez à votre espace personnalisé. 
            Administration, enseignants et élèves — chacun à sa place.
        </p>
        <a href="{{ route('login') }}" class="btn-primary-gold">
            <i class="fas fa-sign-in-alt"></i>
            Se connecter à la plateforme
        </a>
    </div>
</section>

<!-- ─── FOOTER ─── -->
<footer>
    <div class="footer-logo">School<span>Manager</span></div>
    <div class="footer-copy">© {{ date('Y') }} SchoolManager. Tous droits réservés.</div>
</footer>

</body>
</html>