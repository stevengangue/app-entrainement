<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta name="description" content="FitTrack Pro - Plateforme professionnelle de gestion d'entraînement sportif">
    <title>FitTrack Pro | Plateforme d'Entraînement Professionnelle</title>
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root {
            --primary: #3b82f6;
            --primary-dark: #2563eb;
            --secondary: #8b5cf6;
            --dark: #0f172a;
            --gray: #64748b;
            --light: #f8fafc;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            overflow-x: hidden;
        }
        
        /* Navigation */
        .navbar {
            backdrop-filter: blur(10px);
            background: rgba(255,255,255,0.1);
            transition: all 0.3s ease;
            padding: 1rem 0;
        }
        
        .navbar.scrolled {
            background: rgba(15,23,42,0.95);
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
        }
        
        .nav-link {
            color: white !important;
            font-weight: 500;
            transition: all 0.3s;
            position: relative;
        }
        
        .nav-link:hover {
            opacity: 0.8;
            transform: translateY(-2px);
        }
        
        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            padding: 6rem 0 4rem 0;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><path fill="rgba(255,255,255,0.05)" d="M45.3,-77.8C59.9,-68.9,73.5,-56.3,81.8,-40.8C90.1,-25.3,93.1,-6.9,88.9,9.5C84.7,25.9,73.3,40.3,60.4,52.5C47.5,64.7,33.1,74.7,17.4,80.1C1.7,85.5,-15.3,86.3,-30.9,80.9C-46.5,75.5,-60.7,63.9,-71.2,49.8C-81.7,35.7,-88.5,19.1,-87.5,2.9C-86.5,-13.3,-77.7,-29.1,-66.4,-42.6C-55.1,-56.1,-41.3,-67.3,-26.8,-75.1C-12.3,-82.9,3.2,-87.4,20.4,-85.2C37.6,-83,56.4,-74.1,45.3,-77.8Z" transform="translate(100 100)"/></svg>') repeat;
            opacity: 0.1;
            pointer-events: none;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, #fff 0%, #e0e7ff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .hero-subtitle {
            font-size: 1.1rem;
            color: rgba(255,255,255,0.95);
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        
        /* Buttons */
        .btn-primary-custom {
            background: white;
            color: var(--primary);
            padding: 12px 32px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            color: var(--primary-dark);
            background: white;
        }
        
        .btn-outline-custom {
            background: transparent;
            border: 2px solid white;
            color: white;
            padding: 12px 32px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }
        
        .btn-outline-custom:hover {
            background: white;
            color: var(--primary);
            transform: translateY(-3px);
        }
        
        /* Feature Cards */
        .feature-card {
            background: white;
            border-radius: 24px;
            padding: 2rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            transform: scaleX(0);
            transition: transform 0.4s;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        
        .feature-card:hover::before {
            transform: scaleX(1);
        }
        
        .feature-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }
        
        .feature-icon i {
            font-size: 2rem;
            color: white;
        }
        
        .feature-card h4 {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: var(--dark);
        }
        
        .feature-card p {
            color: #4b5563;
            line-height: 1.6;
        }
        
        /* Stats Section */
        .stats-section {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border-radius: 40px;
            padding: 3rem;
            margin: 3rem 0;
        }
        
        .stat-item {
            text-align: center;
            border-right: 1px solid rgba(255,255,255,0.2);
        }
        
        .stat-item:last-child {
            border-right: none;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: white;
            line-height: 1;
        }
        
        .stat-label {
            color: rgba(255,255,255,0.9);
            margin-top: 0.5rem;
            font-weight: 500;
        }
        
        /* Testimonials */
        .testimonial-card {
            background: white;
            border-radius: 24px;
            padding: 2rem;
            position: relative;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            height: 100%;
        }
        
        .testimonial-card::before {
            content: '"';
            font-size: 4rem;
            position: absolute;
            top: -10px;
            left: 20px;
            color: var(--primary);
            opacity: 0.2;
            font-family: serif;
        }
        
        .testimonial-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            flex-shrink: 0;
        }
        
        .testimonial-card h5 {
            font-weight: 700;
            color: var(--dark);
        }
        
        .testimonial-card .text-muted {
            color: #6c757d !important;
        }
        
        /* CTA Section */
        .cta-section {
            text-align: center;
            padding: 4rem 2rem;
        }
        
        /* Footer */
        footer {
            background: #0f172a !important;
        }
        
        footer h5, footer h6 {
            font-weight: 700;
        }
        
        footer a {
            transition: all 0.3s;
        }
        
        footer a:hover {
            color: var(--primary) !important;
            transform: translateX(3px);
        }
        
        /* Animations */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .floating {
            animation: float 6s ease-in-out infinite;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .hero-title {
                font-size: 2.8rem;
            }
            
            .navbar-nav {
                margin-top: 1rem;
            }
            
            .nav-item {
                margin: 0.5rem 0;
            }
        }
        
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .hero-subtitle {
                font-size: 1rem;
            }
            
            .stat-item {
                border-right: none;
                border-bottom: 1px solid rgba(255,255,255,0.2);
                margin-bottom: 1.5rem;
                padding-bottom: 1.5rem;
            }
            
            .stat-item:last-child {
                border-bottom: none;
                margin-bottom: 0;
                padding-bottom: 0;
            }
            
            .stats-section {
                padding: 2rem;
            }
            
            .feature-card {
                margin-bottom: 1rem;
            }
            
            .testimonial-card {
                margin-bottom: 1.5rem;
            }
            
            .btn-primary-custom, .btn-outline-custom {
                padding: 10px 24px;
                font-size: 0.9rem;
            }
        }
        
        @media (max-width: 576px) {
            .hero-title {
                font-size: 1.8rem;
            }
            
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
            
            .stats-section {
                padding: 1.5rem;
            }
            
            .stat-number {
                font-size: 2rem;
            }
        }
        
        /* Text gradient fix */
        .text-gradient {
            background: linear-gradient(135deg, #fff, #e0e7ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(0,0,0,0.1);
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand text-white fw-bold fs-3" href="/">
                <i class="fas fa-dumbbell me-2"></i>FitTrack Pro
            </a>
            <button class="navbar-toggler bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-lg-3">
                    <li class="nav-item"><a class="nav-link" href="#features">Fonctionnalités</a></li>
                    <li class="nav-item"><a class="nav-link" href="#testimonials">Témoignages</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                <a class="btn btn-primary-custom" href="{{ url('/dashboard') }}">
                                    <i class="fas fa-chart-line"></i> Tableau de bord
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="btn btn-outline-custom" href="{{ route('login') }}">Connexion</a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btn-primary-custom" href="{{ route('register') }}">
                                    <i class="fas fa-user-plus"></i> Inscription
                                </a>
                            </li>
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="row align-items-center min-vh-100">
                <div class="col-lg-6" data-aos="fade-right" data-aos-duration="1000">
                    <h1 class="hero-title">
                        Transformez votre<br>
                        <span class="text-white">entraînement avec</span><br>
                        <span class="text-gradient">FitTrack Pro</span>
                    </h1>
                    <p class="hero-subtitle">
                        La plateforme intelligente qui révolutionne la gestion d'entraînement. 
                        Suivez vos progrès, analysez vos performances et atteignez vos objectifs.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="btn btn-primary-custom">
                                    <i class="fas fa-arrow-right"></i> Accéder au tableau de bord
                                </a>
                            @else
                                <a href="{{ route('register') }}" class="btn btn-primary-custom">
                                    <i class="fas fa-rocket"></i> Commencer gratuitement
                                </a>
                                <a href="{{ route('login') }}" class="btn btn-outline-custom">
                                    <i class="fas fa-sign-in-alt"></i> Se connecter
                                </a>
                            @endauth
                        @endif
                    </div>
                    
                    <!-- Trust badges -->
                    <div class="mt-5 d-flex gap-4 flex-wrap">
                        <div><i class="fas fa-shield-alt text-white"></i> <small class="text-white-50">Sécurisé</small></div>
                        <div><i class="fas fa-clock text-white"></i> <small class="text-white-50">Support 24/7</small></div>
                        <div><i class="fas fa-mobile-alt text-white"></i> <small class="text-white-50">Mobile Friendly</small></div>
                    </div>
                </div>
                <div class="col-lg-6 text-center" data-aos="fade-left" data-aos-duration="1000">
                    <div class="floating">
                        <i class="fas fa-dumbbell fa-8x text-white opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5">
        <div class="container py-5">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="text-white display-4 fw-bold mb-3">Fonctionnalités avancées</h2>
                <p class="text-white-50 fs-5">Découvrez tous les outils pour optimiser vos entraînements</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <h4>Programmes sur mesure</h4>
                        <p>Créez des programmes d'entraînement personnalisés adaptés à chaque niveau, objectif et contrainte physique.</p>
                        <a href="#" class="text-primary text-decoration-none mt-3 d-inline-block fw-semibold">En savoir plus →</a>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4>Analyses avancées</h4>
                        <p>Suivez votre progression avec des graphiques interactifs et des statistiques détaillées en temps réel.</p>
                        <a href="#" class="text-primary text-decoration-none mt-3 d-inline-block fw-semibold">En savoir plus →</a>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4>Gestion multi-rôles</h4>
                        <p>Interface dédiée pour administrateurs, coachs et athlètes avec des fonctionnalités spécifiques.</p>
                        <a href="#" class="text-primary text-decoration-none mt-3 d-inline-block fw-semibold">En savoir plus →</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <div class="container">
        <div class="stats-section" data-aos="zoom-in">
            <div class="row">
                <div class="col-md-3 stat-item">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Exercices disponibles</div>
                </div>
                <div class="col-md-3 stat-item">
                    <div class="stat-number">1 000+</div>
                    <div class="stat-label">Utilisateurs actifs</div>
                </div>
                <div class="col-md-3 stat-item">
                    <div class="stat-number">50+</div>
                    <div class="stat-label">Coachs certifiés</div>
                </div>
                <div class="col-md-3 stat-item">
                    <div class="stat-number">98%</div>
                    <div class="stat-label">Taux de satisfaction</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-5">
        <div class="container py-5">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="text-white display-4 fw-bold mb-3">Ce que nos utilisateurs disent</h2>
                <p class="text-white-50 fs-5">Ils ont choisi FitTrack Pro pour transformer leur entraînement</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="testimonial-card">
                        <div class="d-flex align-items-center mb-3">
                            <div class="testimonial-avatar">
                                <i class="fas fa-user text-white fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">Kevin Beryo</h5>
                                <small class="text-muted">Athlète professionnel</small>
                            </div>
                        </div>
                        <p class="text-muted">"FitTrack Pro a complètement transformé ma façon de m'entraîner. Les analyses sont précises et m'aident à progresser chaque semaine."</p>
                        <div class="text-warning">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="testimonial-card">
                        <div class="d-flex align-items-center mb-3">
                            <div class="testimonial-avatar">
                                <i class="fas fa-user text-white fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">Steve Ngangue</h5>
                                <small class="text-muted">Coach sportif</small>
                            </div>
                        </div>
                        <p class="text-muted">"Un outil indispensable pour gérer mes athlètes. La création de programmes est intuitive et le suivi est exceptionnel."</p>
                        <div class="text-warning">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="testimonial-card">
                        <div class="d-flex align-items-center mb-3">
                            <div class="testimonial-avatar">
                                <i class="fas fa-user text-white fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">Lesly Maevas</h5>
                                <small class="text-muted">Débutante</small>
                            </div>
                        </div>
                        <p class="text-muted">"Parfait pour les débutants comme moi ! Les programmes sont adaptés et je vois déjà mes progrès après seulement 3 semaines."</p>
                        <div class="text-warning">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="contact" class="py-5 mb-5">
        <div class="container">
            <div class="text-center" data-aos="fade-up">
                <h2 class="text-white display-5 fw-bold mb-4">Prêt à transformer votre entraînement ?</h2>
                <p class="text-white-50 fs-5 mb-4">Rejoignez plus de 1 000 utilisateurs qui utilisent FitTrack Pro</p>
                @if (Route::has('login') && !Auth::check())
                    <a href="{{ route('register') }}" class="btn btn-primary-custom btn-lg">
                        <i class="fas fa-gem"></i> Commencer maintenant - Gratuit
                    </a>
                @endif
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="text-white mb-3">FitTrack Pro</h5>
                    <p class="text-white-50">La plateforme intelligente pour une gestion d'entraînement optimale.</p>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-white-50"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="#" class="text-white-50"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="text-white-50"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="text-white-50"><i class="fab fa-linkedin fa-lg"></i></a>
                    </div>
                </div>
                <div class="col-md-2 mb-4">
                    <h6 class="text-white mb-3">Produit</h6>
                    <ul class="list-unstyled">
                        <li><a href="#features" class="text-white-50 text-decoration-none">Fonctionnalités</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">Tarifs</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">FAQ</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-4">
                    <h6 class="text-white mb-3">Entreprise</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white-50 text-decoration-none">À propos</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">Blog</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h6 class="text-white mb-3">Newsletter</h6>
                    <p class="text-white-50">Recevez nos conseils d'entraînement</p>
                    <div class="input-group">
                        <input type="email" class="form-control bg-dark text-white border-secondary" placeholder="Votre email">
                        <button class="btn btn-primary" type="button">S'inscrire</button>
                    </div>
                </div>
            </div>
            <hr class="bg-white-50">
            <div class="text-center text-white-50">
                <small>&copy; 2026 FitTrack Pro. Tous droits réservés. Développé avec FitTrack Pro pour la communauté sportive.</small>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });
        
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>