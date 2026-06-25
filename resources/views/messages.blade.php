<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messagerie - SafeTrace</title>
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
            <a href="/messages" class="font-semibold" style="color: #00897b">Messagerie</a>
            @endauth
        </div>
        <div class="flex gap-3 items-center">
            @auth
                <span class="font-semibold px-4 py-2 rounded-full text-white text-sm" style="background: linear-gradient(135deg, #00897b, #0097a7)">👤 {{ Auth::user()->name }}</span>
                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit" class="border-2 px-4 py-2 rounded-full font-medium text-sm" style="border-color: #00897b; color: #00897b">Déconnexion</button>
                </form>
            @endauth
        </div>
    </nav>

    <section class="py-6 px-6" style="background: linear-gradient(135deg, #004d40, #006064)">
        <div class="max-w-5xl mx-auto">
            <h1 class="text-3xl font-bold text-white">💬 Messagerie</h1>
            <p class="text-teal-200 mt-1">Vos conversations avec les témoins</p>
        </div>
    </section>

    <section class="py-10 px-6">
        <div class="max-w-5xl mx-auto">

            @if(session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-3 rounded-xl mb-6 font-medium">
                ✅ {{ session('success') }}
            </div>
            @endif

            <!-- MESSAGES REÇUS -->
            <div class="bg-white rounded-2xl shadow-md p-6 mb-8">
                <h2 class="text-xl font-bold mb-4" style="color: #004d40">📥 Messages reçus ({{ $messages_recus->count() }})</h2>

                @forelse($messages_recus as $message)
                <div class="border rounded-xl p-4 mb-3 {{ !$message->lu ? 'border-teal-300 bg-teal-50' : 'border-gray-100' }}">
                    <div class="flex justify-between items-start">
                        <div>
                            @if(!$message->lu)
                            <span class="bg-teal-500 text-white text-xs px-2 py-1 rounded-full font-medium mb-2 inline-block">Nouveau</span>
                            @endif
                            <p class="font-bold" style="color: #004d40">De : {{ $message->sender->name }}</p>
                            @if($message->annonce)
                            <p class="text-gray-500 text-sm">Concernant : {{ $message->annonce->prenom_personne }} {{ $message->annonce->nom_personne }}</p>
                            @endif
                            <p class="text-gray-700 mt-2">{{ $message->contenu }}</p>
                            <p class="text-gray-400 text-xs mt-2">{{ \Carbon\Carbon::parse($message->created_at)->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="flex gap-2">
                            @if(!$message->lu)
                            <form method="POST" action="/messages/{{ $message->id }}/lu">
                                @csrf
                                <button type="submit" class="text-teal-600 text-xs hover:underline">✓ Marquer lu</button>
                            </form>
                            @endif
                            <a href="/messages/create/{{ $message->sender_id }}" class="btn-primary text-white px-3 py-1 rounded-lg text-xs font-medium">Répondre</a>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-gray-400 text-center py-4">Aucun message reçu</p>
                @endforelse
            </div>

            <!-- MESSAGES ENVOYÉS -->
            <div class="bg-white rounded-2xl shadow-md p-6">
                <h2 class="text-xl font-bold mb-4" style="color: #004d40">📤 Messages envoyés ({{ $messages_envoyes->count() }})</h2>

                @forelse($messages_envoyes as $message)
                <div class="border border-gray-100 rounded-xl p-4 mb-3">
                    <p class="font-bold" style="color: #004d40">À : {{ $message->receiver->name }}</p>
                    @if($message->annonce)
                    <p class="text-gray-500 text-sm">Concernant : {{ $message->annonce->prenom_personne }} {{ $message->annonce->nom_personne }}</p>
                    @endif
                    <p class="text-gray-700 mt-2">{{ $message->contenu }}</p>
                    <p class="text-gray-400 text-xs mt-2">{{ \Carbon\Carbon::parse($message->created_at)->format('d/m/Y H:i') }}</p>
                </div>
                @empty
                <p class="text-gray-400 text-center py-4">Aucun message envoyé</p>
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