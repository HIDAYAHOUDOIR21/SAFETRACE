<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annonces - SafeTrace</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        .card-hover { transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .card-hover:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0,0,0,0.12); }
        .btn-primary { background: linear-gradient(135deg, #00897b, #00695c); transition: all 0.3s ease; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(0,137,123,0.3); }
    </style>
</head>
<body class="bg-gray-50">

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
            <a href="/" class="text-gray-600 font-medium hover:text-teal-700">Accueil</a>
            <a href="/annonces" class="font-semibold" style="color: #00897b">Annonces</a>
            <a href="/carte" class="text-gray-600 font-medium hover:text-teal-700">Carte</a>
            @auth
            <a href="/mes-annonces" class="text-gray-600 font-medium hover:text-teal-700">Mon tableau de bord</a>
            @endauth
        </div>
        <div class="flex gap-3 items-center">
            @auth
                <span class="font-semibold px-4 py-2 rounded-full text-white text-sm" style="background: linear-gradient(135deg, #00897b, #0097a7)">👤 {{ Auth::user()->name }}</span>
                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit" class="border-2 px-4 py-2 rounded-full font-medium text-sm" style="border-color: #00897b; color: #00897b">Déconnexion</button>
                </form>
            @else
                <a href="/login" class="border-2 px-4 py-2 rounded-full font-medium text-sm" style="border-color: #00897b; color: #00897b">Connexion</a>
                <a href="/register" class="btn-primary text-white px-5 py-2 rounded-full font-semibold text-sm">S'inscrire</a>
            @endauth
        </div>
    </nav>

    <section class="py-10 px-6" style="background: linear-gradient(135deg, #004d40, #006064)">
        <div class="max-w-6xl mx-auto">
            <h1 class="text-3xl font-bold text-white mb-6">🔍 Annonces de personnes disparues</h1>
            <form method="GET" action="/annonces">
                <div class="flex gap-4 flex-wrap">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher par nom..." class="px-4 py-3 rounded-xl text-gray-800 flex-1 focus:outline-none">
                    <select name="region" class="px-4 py-3 rounded-xl text-gray-800">
                        <option value="">Toutes les régions</option>
                        <option value="Tanger" {{ request('region') == 'Tanger' ? 'selected' : '' }}>Tanger</option>
                        <option value="Tétouan" {{ request('region') == 'Tétouan' ? 'selected' : '' }}>Tétouan</option>
                        <option value="Al Hoceima" {{ request('region') == 'Al Hoceima' ? 'selected' : '' }}>Al Hoceima</option>
                        <option value="Casablanca" {{ request('region') == 'Casablanca' ? 'selected' : '' }}>Casablanca</option>
                        <option value="Rabat" {{ request('region') == 'Rabat' ? 'selected' : '' }}>Rabat</option>
                        <option value="Salé" {{ request('region') == 'Salé' ? 'selected' : '' }}>Salé</option>
                        <option value="Marrakech" {{ request('region') == 'Marrakech' ? 'selected' : '' }}>Marrakech</option>
                        <option value="Fès" {{ request('region') == 'Fès' ? 'selected' : '' }}>Fès</option>
                        <option value="Meknès" {{ request('region') == 'Meknès' ? 'selected' : '' }}>Meknès</option>
                        <option value="Agadir" {{ request('region') == 'Agadir' ? 'selected' : '' }}>Agadir</option>
                        <option value="Oujda" {{ request('region') == 'Oujda' ? 'selected' : '' }}>Oujda</option>
                        <option value="Kenitra" {{ request('region') == 'Kenitra' ? 'selected' : '' }}>Kenitra</option>
                        <option value="Laâyoune" {{ request('region') == 'Laâyoune' ? 'selected' : '' }}>Laâyoune</option>
                        <option value="Dakhla" {{ request('region') == 'Dakhla' ? 'selected' : '' }}>Dakhla</option>
                        <option value="Béni Mellal" {{ request('region') == 'Béni Mellal' ? 'selected' : '' }}>Béni Mellal</option>
                        <option value="Nador" {{ request('region') == 'Nador' ? 'selected' : '' }}>Nador</option>
                        <option value="Settat" {{ request('region') == 'Settat' ? 'selected' : '' }}>Settat</option>
                        <option value="Safi" {{ request('region') == 'Safi' ? 'selected' : '' }}>Safi</option>
                        <option value="Mohammedia" {{ request('region') == 'Mohammedia' ? 'selected' : '' }}>Mohammedia</option>
                        <option value="El Jadida" {{ request('region') == 'El Jadida' ? 'selected' : '' }}>El Jadida</option>
                    </select>
                    <select name="sexe" class="px-4 py-3 rounded-xl text-gray-800">
                        <option value="">Tous les sexes</option>
                        <option value="homme" {{ request('sexe') == 'homme' ? 'selected' : '' }}>Homme</option>
                        <option value="femme" {{ request('sexe') == 'femme' ? 'selected' : '' }}>Femme</option>
                    </select>
                    <button type="submit" class="bg-white font-bold px-6 py-3 rounded-xl hover:shadow-lg transition" style="color: #004d40">🔍 Filtrer</button>
                    @if(request('search') || request('region') || request('sexe'))
                    <a href="/annonces" class="bg-red-500 text-white px-4 py-3 rounded-xl hover:bg-red-600">✕ Réinitialiser</a>
                    @endif
                </div>
            </form>
        </div>
    </section>

    <section class="py-10 px-6">
        <div class="max-w-6xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <p class="text-gray-600 font-medium">{{ $annonces->count() }} annonce(s) trouvée(s)</p>
                <a href="/annonces/create" class="btn-primary text-white px-6 py-3 rounded-xl font-semibold">+ Publier une annonce</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($annonces as $annonce)
                <div class="card-hover bg-white rounded-2xl shadow-md overflow-hidden">
                    <div class="h-52 bg-gray-100 flex items-center justify-center overflow-hidden relative">
                        @if($annonce->photos->first())
                            <img src="{{ Storage::url($annonce->photos->first()->url_photo) }}" class="w-full h-full object-cover">
                        @else
                            <div class="flex flex-col items-center" style="color: #b2dfdb">
                                <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <p class="text-sm mt-1">Pas de photo</p>
                            </div>
                        @endif
                        <div class="absolute top-3 right-3 bg-red-500 text-white text-xs px-3 py-1 rounded-full font-medium">En cours</div>
                    </div>
                    <div class="p-5">
                        <h3 class="font-bold text-lg mb-1" style="color: #004d40">{{ $annonce->prenom_personne }} {{ $annonce->nom_personne }}</h3>
                        @if($annonce->date_naissance)
                        <p class="text-gray-500 text-sm mb-1">{{ \Carbon\Carbon::parse($annonce->date_naissance)->age }} ans • {{ ucfirst($annonce->sexe) }}</p>
                        @endif
                        <p class="text-gray-500 text-sm flex items-center gap-1">📍 {{ $annonce->derniere_localisation }}</p>
                        <p class="text-gray-500 text-sm flex items-center gap-1">📅 Disparu le {{ \Carbon\Carbon::parse($annonce->date_disparition)->format('d/m/Y') }}</p>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <a href="/annonces/{{ $annonce->id }}" class="flex items-center justify-center gap-2 w-full py-2 rounded-xl font-semibold text-white transition" style="background: linear-gradient(135deg, #00897b, #0097a7)">
                                Voir les détails →
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-center py-20">
                    <svg class="w-20 h-20 mx-auto mb-4" style="color: #b2dfdb" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-gray-400 text-xl font-medium">Aucune annonce trouvée</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <footer class="py-8 px-6 text-white mt-10" style="background: #002a2a">
        <div class="max-w-5xl mx-auto flex justify-between items-center">
            <span class="font-bold text-lg">SafeTrace</span>
            <p style="color: #80cbc4">© 2026 SafeTrace — Tous droits réservés</p>
            <div class="flex gap-6">
                <a href="/annonces" style="color: #80cbc4" class="hover:text-white transition">Annonces</a>
                <a href="/carte" style="color: #80cbc4" class="hover:text-white transition">Carte</a>
            </div>
        </div>
    </footer>

</body>
</html>