<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publier une annonce - SafeTrace</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        * { font-family: 'Poppins', sans-serif; }
        .btn-primary { background: linear-gradient(135deg, #00897b, #00695c); transition: all 0.3s ease; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(0,137,123,0.3); }
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

    <section class="py-6 px-6" style="background: linear-gradient(135deg, #004d40, #006064)">
        <div class="max-w-3xl mx-auto">
            <h1 class="text-3xl font-bold text-white">📝 Publier une annonce</h1>
            <p class="text-teal-200 mt-1">Remplissez les informations sur la personne disparue.</p>
        </div>
    </section>

    <section class="py-10 px-6">
        <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-lg p-8">

            <form action="/annonces" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-8">
                    <h2 class="text-lg font-bold mb-4 flex items-center gap-2" style="color: #004d40">
                        <span class="w-8 h-8 rounded-full text-white text-sm flex items-center justify-center font-bold" style="background: #00897b">1</span>
                        Informations personnelles
                    </h2>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nom *</label>
                            <input type="text" name="nom_personne" required class="input-style">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Prénom *</label>
                            <input type="text" name="prenom_personne" required class="input-style">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Date de naissance</label>
                            <input type="date" name="date_naissance" class="input-style">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Sexe *</label>
                            <select name="sexe" required class="input-style">
                                <option value="">Sélectionner</option>
                                <option value="homme">Homme</option>
                                <option value="femme">Femme</option>
                                <option value="inconnu">Inconnu</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Taille (cm)</label>
                        <input type="number" name="taille" placeholder="Ex: 175" class="input-style">
                    </div>
                </div>

                <div class="mb-8">
                    <h2 class="text-lg font-bold mb-4 flex items-center gap-2" style="color: #004d40">
                        <span class="w-8 h-8 rounded-full text-white text-sm flex items-center justify-center font-bold" style="background: #00897b">2</span>
                        Description physique
                    </h2>
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Description physique *</label>
                        <textarea name="description_physique" required rows="4" placeholder="Couleur des cheveux, des yeux, morphologie..." class="input-style"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Signes particuliers</label>
                        <textarea name="signes_particuliers" rows="2" placeholder="Cicatrices, tatouages, lunettes..." class="input-style"></textarea>
                    </div>
                </div>

                <div class="mb-8">
                    <h2 class="text-lg font-bold mb-4 flex items-center gap-2" style="color: #004d40">
                        <span class="w-8 h-8 rounded-full text-white text-sm flex items-center justify-center font-bold" style="background: #00897b">3</span>
                        Informations sur la disparition
                    </h2>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Date de disparition *</label>
                            <input type="date" name="date_disparition" required class="input-style">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Dernière localisation *</label>
                            <input type="text" name="derniere_localisation" required placeholder="Ex: Tanger, Maroc" class="input-style">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Cliquez sur la carte pour indiquer la localisation exacte</label>
                        <div id="map-picker" style="height: 300px; border-radius: 12px; border: 2px solid #e5e7eb;"></div>
                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">
                        <p class="text-xs text-gray-400 mt-2" id="coords-text">📍 Aucun point sélectionné</p>
                    </div>
                </div>

                <div class="mb-8">
                    <h2 class="text-lg font-bold mb-4 flex items-center gap-2" style="color: #004d40">
                        <span class="w-8 h-8 rounded-full text-white text-sm flex items-center justify-center font-bold" style="background: #00897b">4</span>
                        Photo
                    </h2>
                    <input type="file" name="photo" accept="image/*" class="input-style">
                    <p class="text-xs text-gray-400 mt-2">Format JPG, PNG ou WEBP. Maximum 5 Mo.</p>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="btn-primary text-white px-8 py-3 rounded-xl font-bold flex-1 text-center">
                        ✅ Publier l'annonce
                    </button>
                    <a href="/annonces" class="border-2 text-gray-600 px-8 py-3 rounded-xl font-medium text-center hover:bg-gray-50" style="border-color: #e5e7eb">
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

    <script>
        var map = L.map('map-picker').setView([31.7917, -7.0926], 6);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
        var marker;
        map.on('click', function(e) {
            if(marker) map.removeLayer(marker);
            marker = L.marker(e.latlng).addTo(map);
            document.getElementById('latitude').value = e.latlng.lat;
            document.getElementById('longitude').value = e.latlng.lng;
            document.getElementById('coords-text').textContent = '📍 Position : ' + e.latlng.lat.toFixed(4) + ', ' + e.latlng.lng.toFixed(4);
        });
    </script>

</body>
</html>