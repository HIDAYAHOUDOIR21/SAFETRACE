<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envoyer un message - SafeTrace</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        .btn-primary { background: linear-gradient(135deg, #00897b, #00695c); transition: all 0.3s ease; }
        .input-style { border: 2px solid #e5e7eb; border-radius: 12px; padding: 10px 16px; width: 100%; transition: border-color 0.3s; }
        .input-style:focus { outline: none; border-color: #00897b; }
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
            <a href="/messages" class="text-gray-600 font-medium hover:text-teal-700">Messagerie</a>
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
            @endauth
        </div>
    </nav>

    <section class="py-6 px-6" style="background: linear-gradient(135deg, #004d40, #006064)">
        <div class="max-w-3xl mx-auto">
            <h1 class="text-3xl font-bold text-white">✉️ Envoyer un message</h1>
            <p class="text-teal-200 mt-1">Contactez un témoin ou un utilisateur</p>
        </div>
    </section>

    <section class="py-10 px-6">
        <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-lg p-8">

            <a href="/messages" class="flex items-center gap-2 font-medium mb-6 hover:underline" style="color: #00897b">← Retour à la messagerie</a>

            <div class="rounded-2xl p-4 mb-6" style="background: linear-gradient(135deg, #e0f2f1, #e0f7fa); border-left: 4px solid #00897b">
                <p class="font-bold" style="color: #004d40">Destinataire : {{ $destinataire->name }}</p>
                @if($annonce)
                <p class="text-gray-600 text-sm">Concernant : {{ $annonce->prenom_personne }} {{ $annonce->nom_personne }}</p>
                @endif
            </div>

            <form action="/messages" method="POST">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $destinataire->id }}">
                @if($annonce)
                <input type="hidden" name="annonce_id" value="{{ $annonce->id }}">
                @endif

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Votre message *</label>
                    <textarea name="contenu" required rows="6" placeholder="Écrivez votre message ici..." class="input-style"></textarea>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="btn-primary text-white px-8 py-3 rounded-xl font-bold flex-1">
                        ✅ Envoyer le message
                    </button>
                    <a href="/messages" class="border-2 text-gray-600 px-8 py-3 rounded-xl font-medium text-center hover:bg-gray-50" style="border-color: #e5e7eb">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </section>

    <footer class="py-8 px-6 text-white mt-4" style="background: #002a2a">
        <div class="max-w-5xl mx-auto text-center">
            <p style="color: #80cbc4">© 2026 SafeTrace — Tous droits réservés</p>
        </div>
    </footer>

</body>
</html>