<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitTrack Pro - Application d'Entraînement Professionnelle</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a0ca3;
        }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .hero {
            min-height: 90vh;
            display: flex;
            align-items: center;
            color: white;
        }
        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
        }
        .hero-subtitle {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        .btn-custom {
            background: white;
            color: var(--primary);
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s;
            margin: 5px;
        }
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        }
        .btn-outline-custom {
            background: transparent;
            border: 2px solid white;
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s;
            margin: 5px;
        }
        .btn-outline-custom:hover {
            background: white;
            color: var(--primary);
            transform: translateY(-2px);
        }
        .feature-card {
            background: rgba(255,255,255,0.95);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s;
            height: 100%;
        }
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }
        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }
        .feature-icon i {
            font-size: 2rem;
            color: white;
        }
        .stat-card {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            color: white;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg py-3">
        <div class="container">
            <a class="navbar-brand text-white fw-bold fs-3" href="/">
                <i class="fas fa-dumbbell me-2"></i>FitTrack Pro
            </a>
            <button class="navbar-toggler bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link text-white" href="#features">Fonctionnalités</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#about">À propos</a></li>
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                <a class="btn btn-custom" href="{{ url('/dashboard') }}">Tableau de bord</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="btn btn-outline-custom" href="{{ route('login') }}">Connexion</a>
                            </li>
                            <li class="nav-item ms-2">
                                <a class="btn btn-custom" href="{{ route('register') }}">Inscription</a>
                            </li>
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <h1 class="hero-title">Transformez votre entraînement<br>avec <span class="fw-bold">FitTrack Pro</span></h1>
                    <p class="hero-subtitle">La plateforme professionnelle pour créer des programmes d'entraînement personnalisés et suivre vos performances en temps réel.</p>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-custom btn-lg">Accéder au tableau de bord</a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-custom btn-lg me-3">Commencer gratuitement</a>
                            <a href="{{ route('login') }}" class="btn btn-outline-custom btn-lg">Se connecter</a>
                        @endauth
                    @endif
                </div>
                <div class="col-lg-6 text-center" data-aos="fade-left">
                    <i class="fas fa-dumbbell fa-8x text-white opacity-75"></i>
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="py-5">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="text-white display-5 fw-bold">Fonctionnalités puissantes</h2>
                <p class="text-white-50">Tout ce dont vous avez besoin pour gérer vos entraînements</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-calendar-alt"></i></div>
                        <h4>Programmes personnalisés</h4>
                        <p class="text-muted">Créez des programmes sur mesure adaptés à chaque niveau et objectif.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-chart-line"></i></div>
                        <h4>Suivi des performances</h4>
                        <p class="text-muted">Analysez vos progrès avec des graphiques et statistiques avancés.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-users"></i></div>
                        <h4>Gestion des coachs</h4>
                        <p class="text-muted">Les coachs peuvent créer et assigner des programmes à leurs athlètes.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-3" data-aos="fade-up">
                    <div class="stat-card"><div class="display-4 fw-bold">500+</div><div>Exercices</div></div>
                </div>
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-card"><div class="display-4 fw-bold">1000+</div><div>Utilisateurs</div></div>
                </div>
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-card"><div class="display-4 fw-bold">50+</div><div>Coachs</div></div>
                </div>
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-card"><div class="display-4 fw-bold">98%</div><div>Satisfaction</div></div>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-4 text-center text-white-50">
        <div class="container">
            <small>&copy; 2026 FitTrack Pro. Tous droits réservés.</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ duration: 1000, once: true });</script>
</body>
</html>