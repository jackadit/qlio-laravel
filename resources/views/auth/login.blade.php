<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - QLIO</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-100 flex items-center justify-center">
    <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-lg">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Connexion</h1>
            <p class="text-gray-600">Identifiez-vous pour accéder à la plateforme</p>
        </div>

        @if($errors->any())
            <div class="mb-4 px-4 py-3 bg-red-100 text-red-700 rounded-lg">
                {{ $errors->first('login') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.attempt') }}" class="space-y-6">
            @csrf

            <div>
                <label for="login" class="block text-sm font-medium text-gray-700 mb-1">Identifiant</label>
                <input type="text" id="login" name="login" value="{{ old('login') }}" autofocus
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                       required>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                <input type="password" id="password" name="password"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                       required>
            </div>

            <button type="submit" class="w-full py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Se connecter
            </button>
        </form>
    </div>
</body>
</html>
