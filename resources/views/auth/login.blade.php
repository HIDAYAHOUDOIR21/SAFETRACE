<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - SafeTrace</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #004d40, #006064); }
        .input-style { border: 2px solid #e5e7eb; border-radius: 12px; padding: 12px 16px; width: 100%; transition: border-color 0.3s; }
        .input-style:focus { outline: none; border-color: #00897b; }
        .btn-primary { background: linear-gradient(135deg, #00897b, #00695c); transition: all 0.3s ease; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(0,137,123,0.3); }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-md">
        <!-- LOGO -->
        <div class="text-center mb-8">
            <a href="/" class="inline-flex items-center gap-3">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center" style="background: rgba(255,255,255,0.2)">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <div class="text-left">
                    <span class="text-3xl font-bold text-white">Safe</span><span class="text-3xl font-bold" style="color: #80cbc4">Trace</span>
                    <p class="text-teal-200 text-xs">Recherche de personnes disparues</p>
                </div>
            </a>
        </div>

        <!-- CARTE -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <h2 class="text-2xl font-bold mb-2" style="color: #004d40">Bon retour ! 👋</h2>
            <p class="text-gray-500 mb-6">Connectez-vous à votre compte SafeTrace</p>

            @if ($errors->any())
            <div class="bg-red-50 text-red-600 px-4 py-3 rounded-xl mb-4 text-sm">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
            @endif

            <form method="POST" action="/login">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Adresse email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="votre@email.com" class="input-style">
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Mot de passe</label>
                    <input type="password" name="password" required placeholder="••••••••" class="input-style">
                </div>
                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded">
                        Se souvenir de moi
                    </label>
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm font-medium hover:underline" style="color: #00897b">Mot de passe oublié ?</a>
                    @endif
                </div>
                <button type="submit" class="btn-primary text-white w-full py-3 rounded-xl font-bold text-lg">
                    Se connecter →
                </button>
            </form>

            <p class="text-center text-gray-500 mt-6 text-sm">
                Pas encore de compte ?
                <a href="/register" class="font-bold hover:underline" style="color: #00897b">S'inscrire</a>
            </p>
        </div>

        <p class="text-center text-teal-200 text-sm mt-6">© 2026 SafeTrace — Tous droits réservés</p>
    </div>

</body>
</html>