<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon tableau de bord - SafeTrace</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        .btn-primary { background: linear-gradient(135deg, #00897b, #00695c); transition: all 0.3s ease; }
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
            </div>
        </a>
        <div class="flex gap-8">
            <a href="/" class="text-gray-600 font-medium hover:text-teal-700">Accueil</a>
            <a href="/annonces" class="text-gray-600 font-medium hover:text-teal-700">Annonces</a>
            <a href="/carte" class="text-gray-600 font-medium hover:text-teal-700">Carte</a>
            <a href="/mes-annonces" class="font-semibold" style="color: #00897b">Mon tableau de bord</a>
        </div>
        <div class="flex gap-3 items-center">
            <span class="font-semibold px-4 py-2 rounded-full text-white text-sm" style="background: linear-gradient(135deg, #00897b, #0097a7)">👤 {{ Auth::user()->name }}</span>
            <form method="POST" action="/logout">
                @csrf
                <button type="submit" class="border-2 px-4 py-2 rounded-full font-medium text-sm" style="border-color: #00897b; color: #00897b">Déconnexion</button>
            </form>
        </div>
    </nav>

    <section class="py-10 px-6">
        <div class="max-w-5xl mx-auto">

            <h1 class="text-3xl font-bold mb-8" style="color: #004d40">Mon tableau de bord</h1>

            @if(session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-3 rounded-xl mb-6 font-medium">
                ✅ {{ session('success') }}
            </div>
            @endif

            @if($notifications->count() > 0)
            <div class="bg-white rounded-2xl shadow-md p-6 mb-8">
                <h2 class="text-xl font-bold mb-4" style="color: #004d40">🔔 Notifications ({{ $notifications->count() }})</h2>
                @foreach($notifications as $notification)
                <div class="border-l-4 p-4 mb-3 rounded-r-xl {{ $notification->type == 'correspondance' ? 'border-yellow-400 bg-yellow-50' : 'border-teal-400 bg-teal-50' }}">
                    <p class="text-gray-700 font-medium">{{ $notification->message }}</p>
                    <p class="text-gray-400 text-xs mt-1">{{ \Carbon\Carbon::parse($notification->created_at)->format('d/m/Y H:i') }}</p>
                </div>
                @endforeach
                <form method="POST" action="/notifications/lire">
                    @csrf
                    <button type="submit" class="text-sm font-medium mt-2 hover:underline" style="color: #00897b">✓ Marquer tout comme lu</button>
                </form>
            </div>
            @endif

            <div class="grid grid-cols-3 gap-6 mb-10">
                <div class="bg-white rounded-2xl shadow-md p-6 text-center" style="border-top: 4px solid #00897b">
                    <p class="text-gray-500 font-medium mb-2">Mes annonces</p>
                    <p class="text-5xl font-extrabold" style="color: #00897b">{{ $mes_annonces->count() }}</p>
                </div>
                <div class="bg-white rounded-2xl shadow-md p-6 text-center" style="border-top: 4px solid #ef4444">
                    <p class="text-gray-500 font-medium mb-2">En cours</p>
                    <p class="text-5xl font-extrabold text-red-500">{{ $mes_annonces->where('statut', 'en_cours')->count() }}</p>
                </div>
                <div class="bg-white rounded-2xl shadow-md p-6 text-center" style="border-top: 4px solid #22c55e">
                    <p class="text-gray-500 font-medium mb-2">Retrouvées</p>
                    <p class="text-5xl font-extrabold text-green-500">{{ $mes_annonces->where('statut', 'retrouve_vivant')->count() }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-md p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold" style="color: #004d40">Mes annonces</h2>
                    <a href="/annonces/create" class="btn-primary text-white px-5 py-2 rounded-xl font-semibold text-sm">+ Nouvelle annonce</a>
                </div>

                @forelse($mes_annonces as $annonce)
                <div class="border border-gray-100 rounded-xl p-4 mb-3 flex justify-between items-center hover:shadow-md transition">
                    <div>
                        <h3 class="font-bold mb-1" style="color: #004d40">{{ $annonce->prenom_personne }} {{ $annonce->nom_personne }}</h3>
                        <p class="text-gray-500 text-sm">📍 {{ $annonce->derniere_localisation }}</p>
                        <div class="flex gap-2 mt-2">
                            @if($annonce->valide_admin)
                                <span class="bg-green-100 text-green-600 text-xs px-3 py-1 rounded-full font-medium">✓ Validée</span>
                            @else
                                <span class="bg-yellow-100 text-yellow-600 text-xs px-3 py-1 rounded-full font-medium">⏳ En attente</span>
                            @endif
                            <span class="bg-gray-100 text-gray-600 text-xs px-3 py-1 rounded-full">{{ ucfirst($annonce->statut) }}</span>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <a href="/annonces/{{ $annonce->id }}" class="bg-gray-100 text-gray-700 px-3 py-2 rounded-xl hover:bg-gray-200 text-sm font-medium">Voir</a>
                        <a href="/annonces/{{ $annonce->id }}/edit" class="text-white px-3 py-2 rounded-xl text-sm font-medium" style="background: #0097a7">Modifier</a>
                        <form method="POST" action="/annonces/{{ $annonce->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Supprimer ?')" class="bg-red-100 text-red-600 px-3 py-2 rounded-xl text-sm font-medium hover:bg-red-200">Supprimer</button>
                        </form>
                    </div>
                </div>
                @empty
                <p class="text-gray-400 text-center py-8">Vous n'avez pas encore publié d'annonce.</p>
                @endforelse
            </div>

        </div>
    </section>

    <footer class="py-8 px-6 text-white mt-10" style="background: #002a2a">
        <div class="max-w-5xl mx-auto text-center">
            <p style="color: #80cbc4">© 2026 SafeTrace — Tous droits réservés</p>
        </div>
    </footer>

</body>
</html>