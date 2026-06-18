<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $annonce->prenom_personne }} {{ $annonce->nom_personne }} - SafeTrace</title>
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

    <section class="py-10 px-6">
        <div class="max-w-4xl mx-auto">
            <a href="/annonces" class="flex items-center gap-2 font-medium mb-6 hover:underline" style="color: #00897b">← Retour aux annonces</a>

            <div class="bg-white rounded-2xl shadow-lg p-8">

                <div class="flex justify-between items-start mb-8">
                    <div>
                        <h1 class="text-3xl font-bold mb-2" style="color: #004d40">{{ $annonce->prenom_personne }} {{ $annonce->nom_personne }}</h1>
                        <span class="bg-red-100 text-red-600 text-sm px-4 py-1 rounded-full font-medium">{{ ucfirst($annonce->statut) }}</span>
                    </div>
                    @auth
                        @if(Auth::id() == $annonce->user_id)
                        <div class="flex gap-2">
                            <a href="/annonces/{{ $annonce->id }}/edit" class="btn-primary text-white px-4 py-2 rounded-xl font-medium text-sm">✏️ Modifier</a>
                            @if($annonce->statut == 'en_cours')
                            <form method="POST" action="/annonces/{{ $annonce->id }}/retrouve">
                                @csrf
                                <button type="submit" onclick="return confirm('Marquer comme retrouvée ?')" class="bg-green-600 text-white px-4 py-2 rounded-xl font-medium text-sm hover:bg-green-700">✅ Retrouvée</button>
                            </form>
                            @endif
                            <form method="POST" action="/annonces/{{ $annonce->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Confirmer la suppression ?')" class="bg-red-600 text-white px-4 py-2 rounded-xl font-medium text-sm hover:bg-red-700">🗑️ Supprimer</button>
                            </form>
                        </div>
                        @endif
                    @endauth
                </div>

                @if($annonce->photos->first())
                <div class="mb-8">
                    <img src="{{ Storage::url($annonce->photos->first()->url_photo) }}" class="w-72 h-72 object-cover rounded-2xl shadow-md">
                </div>
                @endif

                <div class="grid grid-cols-2 gap-8 mb-8">
                    <div class="bg-gray-50 rounded-2xl p-6">
                        <h2 class="font-bold mb-4 text-lg" style="color: #004d40">👤 Informations personnelles</h2>
                        @if($annonce->date_naissance)
                        <p class="text-gray-600 mb-2"><span class="font-medium">Âge :</span> {{ \Carbon\Carbon::parse($annonce->date_naissance)->age }} ans</p>
                        @endif
                        <p class="text-gray-600 mb-2"><span class="font-medium">Sexe :</span> {{ ucfirst($annonce->sexe) }}</p>
                        @if($annonce->taille)
                        <p class="text-gray-600 mb-2"><span class="font-medium">Taille :</span> {{ $annonce->taille }} cm</p>
                        @endif
                    </div>
                    <div class="bg-gray-50 rounded-2xl p-6">
                        <h2 class="font-bold mb-4 text-lg" style="color: #004d40">📍 Disparition</h2>
                        <p class="text-gray-600 mb-2"><span class="font-medium">Date :</span> {{ \Carbon\Carbon::parse($annonce->date_disparition)->format('d/m/Y') }}</p>
                        <p class="text-gray-600 mb-2"><span class="font-medium">Localisation :</span> {{ $annonce->derniere_localisation }}</p>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-2xl p-6 mb-6">
                    <h2 class="font-bold mb-3 text-lg" style="color: #004d40">📝 Description physique</h2>
                    <p class="text-gray-600">{{ $annonce->description_physique }}</p>
                </div>

                @if($annonce->signes_particuliers)
                <div class="bg-gray-50 rounded-2xl p-6 mb-6">
                    <h2 class="font-bold mb-3 text-lg" style="color: #004d40">⚡ Signes particuliers</h2>
                    <p class="text-gray-600">{{ $annonce->signes_particuliers }}</p>
                </div>
                @endif

                <div class="border-t pt-6 mb-6">
                    <h2 class="font-bold mb-4 text-lg" style="color: #004d40">💬 Vous avez vu cette personne ?</h2>
                    <a href="/annonces/{{ $annonce->id }}/temoignages/create" class="inline-flex items-center gap-2 bg-green-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-green-700 transition">
                        💬 Laisser un témoignage
                    </a>
                </div>

                <div class="border-t pt-6 mb-6">
                    <h2 class="font-bold mb-4 text-lg" style="color: #004d40">Témoignages ({{ $annonce->temoignages->count() }})</h2>
                    @forelse($annonce->temoignages as $temoignage)
                    <div class="bg-teal-50 rounded-xl p-4 mb-3 border border-teal-100">
                        <p class="text-gray-700 mb-2">{{ $temoignage->contenu }}</p>
                        <p class="text-gray-500 text-sm">📍 {{ $temoignage->localisation_vue }}</p>
                        <p class="text-gray-500 text-sm">📅 {{ \Carbon\Carbon::parse($temoignage->date_observation)->format('d/m/Y') }}</p>
                        @auth
                        @if(Auth::id() == $annonce->user_id)
                        <form method="POST" action="/annonces/{{ $annonce->id }}/temoignages/{{ $temoignage->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Supprimer ce témoignage ?')" class="text-red-500 text-xs hover:underline mt-2">🗑️ Supprimer</button>
                        </form>
                        @endif
                        @endauth
                    </div>
                    @empty
                    <p class="text-gray-400">Aucun témoignage pour le moment.</p>
                    @endforelse
                </div>

                @if($annonce->correspondances->count() > 0)
                <div class="border-t pt-6 mb-6">
                    <h2 class="font-bold mb-4 text-lg" style="color: #004d40">🔍 Correspondances détectées ({{ $annonce->correspondances->count() }})</h2>
                    @foreach($annonce->correspondances as $correspondance)
                    @if($correspondance->temoignage)
                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-3">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-bold text-yellow-800">Score : {{ $correspondance->score_similarite }}/100</span>
                            <span class="bg-yellow-200 text-yellow-800 text-xs px-3 py-1 rounded-full">{{ ucfirst($correspondance->statut) }}</span>
                        </div>
                        <p class="text-gray-700 text-sm">{{ $correspondance->temoignage->contenu }}</p>
                        <p class="text-gray-500 text-sm">📍 {{ $correspondance->temoignage->localisation_vue }}</p>
                        <p class="text-gray-500 text-sm">📅 {{ \Carbon\Carbon::parse($correspondance->temoignage->date_observation)->format('d/m/Y') }}</p>
                    </div>
                    @endif
                    @endforeach
                </div>
                @endif

                <div class="border-t pt-6">
                    <h2 class="font-bold mb-4 text-lg" style="color: #004d40">📢 Partager cette annonce</h2>
                    <div class="flex gap-3">
                        <a href="https://wa.me/?text=Personne disparue : {{ $annonce->prenom_personne }} {{ $annonce->nom_personne }} - {{ url('/annonces/'.$annonce->id) }}" target="_blank" class="bg-green-500 text-white px-5 py-2 rounded-xl font-medium hover:bg-green-600 transition">WhatsApp</a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ url('/annonces/'.$annonce->id) }}" target="_blank" class="bg-blue-600 text-white px-5 py-2 rounded-xl font-medium hover:bg-blue-700 transition">Facebook</a>
                    </div>
                </div>

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