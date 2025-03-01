<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - GlowUp</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="max-w-sm w-full bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Créer un compte</h2>

        <!-- Formulaire d'inscription -->
        <form action="#" method="POST">
            <!-- Nom complet -->
            <div class="mb-4">
                <label for="full_name" class="block text-sm font-medium text-gray-600">Nom complet</label>
                <input type="text" id="full_name" name="full_name" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-pink-600" placeholder="Votre nom complet" required>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-600">Email</label>
                <input type="email" id="email" name="email" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-pink-600" placeholder="exemple@domaine.com" required>
            </div>

            <!-- Mot de passe -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-600">Mot de passe</label>
                <input type="password" id="password" name="password" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-pink-600" placeholder="********" required>
            </div>

            <!-- Confirmer le mot de passe -->
            <div class="mb-6">
                <label for="confirm_password" class="block text-sm font-medium text-gray-600">Confirmer le mot de passe</label>
                <input type="password" id="confirm_password" name="confirm_password" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-pink-600" placeholder="********" required>
            </div>

            <!-- Bouton d'inscription -->
            <button type="submit" class="w-full py-2 bg-pink-600 text-white rounded-md hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-500">S'inscrire</button>

            <!-- Lien vers la page de connexion -->
            <p class="mt-4 text-center text-sm text-gray-500">
                Vous avez déjà un compte ? 
                <a href="login.html" class="text-pink-600 hover:text-pink-700">Se connecter</a>
            </p>
        </form>
    </div>
</body>
</html>
