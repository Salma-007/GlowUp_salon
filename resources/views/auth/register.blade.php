@extends('layouts.auth')

@section('title', 'Inscription')

@section('content')
<div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl p-8 w-full max-w-md">
    <div class="text-center mb-8">
        <span class="text-3xl font-bold text-indigo-600">GlowUp</span>
        <p class="text-gray-600 mt-2">Créez votre compte chez nous</p>
    </div>

    <form class="space-y-6">
        <div>
            <label for="fullname" class="block text-sm font-medium text-gray-700">Nom complet</label>
            <div class="mt-1">
                <input type="text" id="fullname" name="fullname" required
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-300"
                       placeholder="Jean Dupont">
            </div>
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <div class="mt-1">
                <input type="email" id="email" name="email" required
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-300"
                       placeholder="votre@email.com">
            </div>
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
            <div class="mt-1">
                <input type="password" id="password" name="password" required
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-300"
                       placeholder="••••••••">
            </div>
        </div>

        <div>
            <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirmez le mot de passe</label>
            <div class="mt-1">
                <input type="password" id="confirm_password" name="confirm_password" required
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-300"
                       placeholder="••••••••">
            </div>
        </div>

        <div>
            <button type="submit"
                    class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 transition duration-300">
                S'inscrire
            </button>
        </div>
    </form>

    <div class="mt-6 text-center">
        <p class="text-gray-600">Déjà un compte ? <a href="/login" class="text-indigo-600 hover:text-indigo-700 font-semibold">Se connecter</a></p>
    </div>
</div>
@endsection