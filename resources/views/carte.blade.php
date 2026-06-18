<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carte - SafeTrace</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        * { font-family: 'Poppins', sans-serif; }
        #map { height: 600px; border-radius: 16px; }
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
            <a href="/carte" class="font-semibold" style="color: #00897b">Carte</a>
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

    <section class="py-6 px-6" style="background: linear-gradient(135deg, #004d40, #006064)">
        <div class="max-w-6xl mx-auto">
            <h1 class="text-3xl font-bold text-white mb-2">🗺️ Carte des personnes disparues</h1>
            <p class="text-teal-200">Cliquez sur un marqueur pour voir les détails de l'annonce.</p>
        </div>
    </section>

    <section class="py-8 px-6">
        <div class="max-w-6xl mx-auto">
            <div id="map" class="shadow-xl"></div>
        </div>
    </section>

    <footer class="py-8 px-6 text-white mt-4" style="background: #002a2a">
        <div class="max-w-5xl mx-auto text-center">
            <p style="color: #80cbc4">© 2026 SafeTrace — Tous droits réservés</p>
        </div>
    </footer>

    <script>
        var map = L.map('map').setView([31.7917, -7.0926], 6);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);
        var annonces = @json($annonces);
        annonces.forEach(function(annonce) {
            if(annonce.latitude && annonce.longitude) {
                var marker = L.marker([annonce.latitude, annonce.longitude]).addTo(map);
                marker.bindPopup(
                    '<b>' + annonce.prenom_personne + ' ' + annonce.nom_personne + '</b><br>' +
                    '📍 ' + annonce.derniere_localisation + '<br>' +
                    '<a href="/annonces/' + annonce.id + '" style="color:#00897b;">Voir détails →</a>'
                );
            }
        });
    </script>

</body>
</html>