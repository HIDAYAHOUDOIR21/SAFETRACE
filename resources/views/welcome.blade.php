<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SafeTrace - Recherche de Personnes Disparues</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        .gradient-hero {
            background: linear-gradient(135deg, rgba(0,77,77,0.92) 0%, rgba(0,128,128,0.85) 50%, rgba(0,100,80,0.92) 100%);
        }
        .hero-bg {
            background-image: url('https://images.unsplash.com/photo-1529156069898-49953e39b3ac?w=1600&q=80');
            background-size: cover;
            background-position: center;
        }
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
        }
        .nav-link {
            position: relative;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: #00897b;
            transition: width 0.3s ease;
        }
        .nav-link:hover::after {
            width: 100%;
        }
        .btn-primary {
            background: linear-gradient(135deg, #00897b, #00695c);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #00695c, #004d40);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,137,123,0.3);
        }
        .btn-secondary {
            background: linear-gradient(135deg, #0097a7, #00838f);
            transition: all 0.3s ease;
        }
        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,151,167,0.3);
        }
        .stat-card {
            background: linear-gradient(135deg, #ffffff, #f0fdfa);
            border-left: 4px solid #00897b;
        }
        .section-divider {
            height: 4px;
            background: linear-gradient(90deg, #00897b, #0097a7, #00897b);
        }
    </style>
</head>
<body class="bg-gray-50">

    <!-- NAVBAR -->
    <nav class="bg-white shadow-lg px-8 py-4 flex justify-between items-center sticky top-0 z-50">
        <a href="/" class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #00897b, #0097a7)">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <div>
                <span class="text-2xl font-bold" style="color: #004d40">Safe</span><span class="text-2xl font-bold" style="color: #0097a7">Trace</span>
                <p class="text-xs text-gray-400 -mt-1">Recherche de personnes disparues</p>
            </div>
        </a>
        <div class="flex gap-8">
            <a href="/" class="nav-link font-semibold" style="color: #00897b">Accueil</a>
            <a href="/annonces" class="nav-link text-gray-600 font-medium hover:text-teal-700">Annonces</a>
            <a href="/carte" class="nav-link text-gray-600 font-medium hover:text-teal-700">Carte</a>
            @auth
            <a href="/mes-annonces" class="nav-link text-gray-600 font-medium hover:text-teal-700">Mon tableau de bord</a>
            @endauth
        </div>
        <div class="flex gap-3 items-center">
            @auth
                <span class="font-semibold px-4 py-2 rounded-full text-white text-sm" style="background: linear-gradient(135deg, #00897b, #0097a7)">👤 {{ Auth::user()->name }}</span>
                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit" class="border-2 px-4 py-2 rounded-full font-medium text-sm transition" style="border-color: #00897b; color: #00897b" onmouseover="this.style.background='#00897b';this.style.color='white'" onmouseout="this.style.background='transparent';this.style.color='#00897b'">Déconnexion</button>
                </form>
            @else
                <a href="/login" class="border-2 px-4 py-2 rounded-full font-medium text-sm transition" style="border-color: #00897b; color: #00897b">Connexion</a>
                <a href="/register" class="btn-primary text-white px-5 py-2 rounded-full font-semibold text-sm">S'inscrire</a>
            @endauth
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero-bg relative">
        <div class="gradient-hero py-32 px-6">
            <div class="max-w-4xl mx-auto text-center text-white">
                <div class="inline-flex items-center gap-2 bg-white bg-opacity-20 rounded-full px-4 py-2 mb-6">
                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                    <span class="text-sm font-medium">Plateforme active — Aidez à retrouver des proches</span>
                </div>
                <h1 class="text-5xl font-extrabold mb-6 leading-tight">
                    Ensemble, retrouvons<br>
                    <span style="color: #80cbc4">les personnes disparues</span>
                </h1>
                <p class="text-xl mb-10 text-teal-100 max-w-2xl mx-auto">Chaque témoignage peut changer une vie. Rejoignez notre communauté et aidez les familles à retrouver leurs proches.</p>
                <div class="flex justify-center gap-4 max-w-2xl mx-auto mb-8">
                    <form action="/annonces" method="GET" class="flex gap-3 w-full">
                        <input type="text" name="search" placeholder="Rechercher par nom, localisation..." class="flex-1 px-6 py-4 rounded-full text-gray-800 shadow-xl focus:outline-none focus:ring-4" style="focus:ring-color: #80cbc4">
                        <button type="submit" class="btn-secondary text-white px-8 py-4 rounded-full font-bold shadow-xl">🔍 Rechercher</button>
                    </form>
                </div>
                <div class="flex justify-center gap-6">
                    <a href="/annonces/create" class="btn-primary text-white px-8 py-3 rounded-full font-bold shadow-lg">+ Publier une annonce</a>
                    <a href="/annonces" class="bg-white bg-opacity-20 text-white px-8 py-3 rounded-full font-bold hover:bg-opacity-30 transition">Voir les annonces →</a>
                </div>
            </div>
        </div>
    </section>

    <div class="section-divider"></div>

    <!-- STATISTIQUES -->
    <section class="py-16 px-6 bg-white">
        <div class="max-w-5xl mx-auto">
            <h2 class="text-3xl font-bold text-center mb-2" style="color: #004d40">Notre impact en chiffres</h2>
            <p class="text-center text-gray-500 mb-10">Ensemble, nous faisons la différence chaque jour</p>
            <div class="grid grid-cols-3 gap-8">
                <div class="stat-card card-hover rounded-2xl p-8 text-center shadow-md">
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4" style="background: linear-gradient(135deg, #e0f2f1, #b2dfdb)">
                        <svg class="w-9 h-9" style="color: #00897b" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <p class="text-5xl font-extrabold mb-1" style="color: #00897b">{{ $total_annonces }}</p>
                    <p class="text-gray-500 font-medium">Annonces actives</p>
                </div>
                <div class="stat-card card-hover rounded-2xl p-8 text-center shadow-md" style="border-left-color: #43a047">
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4" style="background: linear-gradient(135deg, #e8f5e9, #c8e6c9)">
                        <svg class="w-9 h-9 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-5xl font-extrabold mb-1 text-green-600">{{ $total_retrouvees }}</p>
                    <p class="text-gray-500 font-medium">Personnes retrouvées</p>
                </div>
                <div class="stat-card card-hover rounded-2xl p-8 text-center shadow-md" style="border-left-color: #0097a7">
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4" style="background: linear-gradient(135deg, #e0f7fa, #b2ebf2)">
                        <svg class="w-9 h-9" style="color: #0097a7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-5xl font-extrabold mb-1" style="color: #0097a7">{{ $cette_semaine }}</p>
                    <p class="text-gray-500 font-medium">Cette semaine</p>
                </div>
            </div>
        </div>
    </section>

    <!-- COMMENT CA MARCHE -->
    <section class="py-16 px-6" style="background: linear-gradient(135deg, #e0f2f1, #e0f7fa)">
        <div class="max-w-5xl mx-auto text-center">
            <h2 class="text-3xl font-bold mb-2" style="color: #004d40">Comment ça marche ?</h2>
            <p class="text-gray-500 mb-12">SafeTrace utilise l'intelligence collective pour retrouver les personnes disparues</p>
            <div class="grid grid-cols-3 gap-8">
                <div class="card-hover bg-white rounded-2xl p-8 shadow-md relative">
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-lg" style="background: linear-gradient(135deg, #00897b, #0097a7)">1</div>
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 mt-4" style="background: linear-gradient(135deg, #e0f2f1, #b2dfdb)">
                        <svg class="w-9 h-9" style="color: #00897b" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2" style="color: #004d40">Publiez une annonce</h3>
                    <p class="text-gray-500 text-sm">Décrivez la personne disparue avec une photo et les détails de la disparition.</p>
                </div>
                <div class="card-hover bg-white rounded-2xl p-8 shadow-md relative">
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-lg" style="background: linear-gradient(135deg, #00897b, #0097a7)">2</div>
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 mt-4" style="background: linear-gradient(135deg, #e0f7fa, #b2ebf2)">
                        <svg class="w-9 h-9" style="color: #0097a7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2" style="color: #004d40">Recevez des témoignages</h3>
                    <p class="text-gray-500 text-sm">La communauté soumet des témoignages si elle a aperçu la personne.</p>
                </div>
                <div class="card-hover bg-white rounded-2xl p-8 shadow-md relative">
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-lg" style="background: linear-gradient(135deg, #00897b, #0097a7)">3</div>
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 mt-4" style="background: linear-gradient(135deg, #e8f5e9, #c8e6c9)">
                        <svg class="w-9 h-9 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2" style="color: #004d40">Retrouvez la personne</h3>
                    <p class="text-gray-500 text-sm">Notre algorithme analyse les témoignages et détecte les correspondances automatiquement.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-16 px-6 text-white text-center" style="background: linear-gradient(135deg, #004d40, #006064)">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-3xl font-bold mb-4">Vous connaissez quelqu'un qui a disparu ?</h2>
            <p class="text-teal-200 mb-8 text-lg">Publiez une annonce en quelques minutes et mobilisez la communauté.</p>
            <a href="/annonces/create" class="inline-block bg-white font-bold text-lg px-10 py-4 rounded-full hover:shadow-xl transition" style="color: #004d40">
                Publier une annonce →
            </a>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="py-8 px-6 text-white" style="background: #002a2a">
        <div class="max-w-5xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #00897b, #0097a7)">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <span class="font-bold text-lg">SafeTrace</span>
            </div>
            <p style="color: #80cbc4">© 2026 SafeTrace — Tous droits réservés</p>
            <div class="flex gap-6">
                <a href="/annonces" style="color: #80cbc4" class="hover:text-white transition">Annonces</a>
                <a href="/carte" style="color: #80cbc4" class="hover:text-white transition">Carte</a>
                <a href="/register" style="color: #80cbc4" class="hover:text-white transition">S'inscrire</a>
            </div>
        </div>
    </footer>

</body>
</html>