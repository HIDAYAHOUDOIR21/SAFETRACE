<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - SafeTrace</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body style="background: #f0fdfa">

    <nav class="bg-white shadow-lg px-8 py-4 flex justify-between items-center">
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
        <span class="font-bold text-lg px-4 py-2 rounded-full text-white" style="background: linear-gradient(135deg, #004d40, #006064)">⚙️ Panel Administration</span>
        <form method="POST" action="/logout">
            @csrf
            <button type="submit" class="border-2 px-4 py-2 rounded-full font-medium" style="border-color: #00897b; color: #00897b">Déconnexion</button>
        </form>
    </nav>

    <section class="py-10 px-6">
        <div class="max-w-6xl mx-auto">

            <h1 class="text-3xl font-bold mb-8" style="color: #004d40">Tableau de bord Admin</h1>

            @if(session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-3 rounded-xl mb-6 font-medium">
                ✅ {{ session('success') }}
            </div>
            @endif

            <div class="grid grid-cols-3 gap-6 mb-10">
                <div class="bg-white rounded-2xl shadow-md p-6 text-center" style="border-top: 4px solid #0097a7">
                    <p class="text-gray-500 font-medium mb-2">Total utilisateurs</p>
                    <p class="text-5xl font-extrabold" style="color: #0097a7">{{ $total_users }}</p>
                </div>
                <div class="bg-white rounded-2xl shadow-md p-6 text-center" style="border-top: 4px solid #00897b">
                    <p class="text-gray-500 font-medium mb-2">Total annonces</p>
                    <p class="text-5xl font-extrabold" style="color: #00897b">{{ $total_annonces }}</p>
                </div>
                <div class="bg-white rounded-2xl shadow-md p-6 text-center" style="border-top: 4px solid #22c55e">
                    <p class="text-gray-500 font-medium mb-2">Personnes retrouvées</p>
                    <p class="text-5xl font-extrabold text-green-500">{{ $total_retrouvees }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-md p-6 mb-8">
                <h2 class="text-xl font-bold mb-6" style="color: #004d40">⏳ Annonces en attente ({{ $annonces_en_attente->count() }})</h2>
                @forelse($annonces_en_attente as $annonce)
                <div class="border border-gray-100 rounded-xl p-4 mb-3 flex justify-between items-center hover:shadow-md transition">
                    <div>
                        <h3 class="font-bold mb-1" style="color: #004d40">{{ $annonce->prenom_personne }} {{ $annonce->nom_personne }}</h3>
                        <p class="text-gray-500 text-sm">📍 {{ $annonce->derniere_localisation }}</p>
                        <p class="text-gray-500 text-sm">📅 {{ \Carbon\Carbon::parse($annonce->date_disparition)->format('d/m/Y') }}</p>
                        <p class="text-gray-400 text-xs mt-1">Publiée le {{ \Carbon\Carbon::parse($annonce->created_at)->format('d/m/Y') }}</p>
                    </div>
                    <div class="flex gap-2">
                        <a href="/annonces/{{ $annonce->id }}" target="_blank" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-xl hover:bg-gray-200 text-sm font-medium">👁️ Voir</a>
                        <form method="POST" action="/admin/annonces/{{ $annonce->id }}/valider">
                            @csrf
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-xl hover:bg-green-700 text-sm font-medium">✅ Valider</button>
                        </form>
                        <form method="POST" action="/admin/annonces/{{ $annonce->id }}/refuser">
                            @csrf
                            <button type="submit" onclick="return confirm('Supprimer cette annonce ?')" class="bg-red-600 text-white px-4 py-2 rounded-xl hover:bg-red-700 text-sm font-medium">❌ Refuser</button>
                        </form>
                    </div>
                </div>
                @empty
                <p class="text-gray-400 text-center py-4">✓ Aucune annonce en attente.</p>
                @endforelse
            </div>

            <div class="bg-white rounded-2xl shadow-md p-6">
                <h2 class="text-xl font-bold mb-6" style="color: #004d40">✅ Annonces validées ({{ $annonces_validees->count() }})</h2>
                @forelse($annonces_validees as $annonce)
                <div class="border border-gray-100 rounded-xl p-4 mb-3 flex justify-between items-center hover:shadow-md transition">
                    <div>
                        <h3 class="font-bold mb-1" style="color: #004d40">{{ $annonce->prenom_personne }} {{ $annonce->nom_personne }}</h3>
                        <p class="text-gray-500 text-sm">📍 {{ $annonce->derniere_localisation }}</p>
                        <span class="bg-green-100 text-green-600 text-xs px-3 py-1 rounded-full font-medium">{{ ucfirst($annonce->statut) }}</span>
                    </div>
                    <div class="flex gap-2">
                        <a href="/annonces/{{ $annonce->id }}" target="_blank" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-xl hover:bg-gray-200 text-sm font-medium">👁️ Voir</a>
                        <form method="POST" action="/admin/annonces/{{ $annonce->id }}/refuser">
                            @csrf
                            <button type="submit" onclick="return confirm('Supprimer ?')" class="bg-red-600 text-white px-4 py-2 rounded-xl hover:bg-red-700 text-sm font-medium">🗑️ Supprimer</button>
                        </form>
                    </div>
                </div>
                @empty
                <p class="text-gray-400 text-center py-4">Aucune annonce validée.</p>
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