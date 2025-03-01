<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - GlowUp</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="max-w-sm w-full bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Se connecter</h2>

        <!-- Formulaire de Connexion -->
        <form action="#" method="POST">
            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-600">Email</label>
                <input type="email" id="email" name="email" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-pink-600" placeholder="exemple@domaine.com" required>
            </div>

            <!-- Mot de passe -->
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-600">Mot de passe</label>
                <input type="password" id="password" name="password" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-pink-600" placeholder="********" required>
            </div>

            <!-- Bouton de connexion -->
            <button type="submit" class="w-full py-2 bg-pink-600 text-white rounded-md hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-500">Se connecter</button>

            <!-- Lien vers la page d'inscription -->
            <p class="mt-4 text-center text-sm text-gray-500">
                Pas encore de compte ? 
                <a href="register.html" class="text-pink-600 hover:text-pink-700">S'inscrire</a>
            </p>
        </form>
    </div>
</body>
</html>
