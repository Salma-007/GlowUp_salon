@extends('layouts.auth')

@section('title', 'Inscription')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4 bg-gray-100">
    <!-- Conteneur de l'image de fond avec flou -->
    <div class="fixed inset-0 overflow-hidden z-0">
        <img src="{{ asset('storage/services/background_login.jpg') }}" 
             alt="Background" 
             class="w-full h-full object-cover blur-sm">
        <div class="absolute inset-0 bg-black/30"></div>
    </div>
    
    <!-- Contenu du formulaire -->
    <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-2xl p-10 w-full mx-4 relative z-10" style="min-width: 450px; max-width: 550px;">
        <div class="text-center mb-8">
            <span class="text-3xl font-bold text-indigo-600">GlowUp</span>
            <p class="text-gray-600 mt-2">Créez votre compte chez nous</p>
        </div>
        
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 rounded-lg">
                <ul class="text-red-600">
                    @foreach ($errors->all() as $error)
                        <li class="text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.addUser') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nom complet</label>
                <div class="mt-1">
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-300"
                           placeholder="Jean Dupont">
                </div>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <div class="mt-1">
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
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
                <label for="phone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                <div class="mt-1">
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-300">
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
            <p class="text-gray-600">Déjà un compte ? 
                <a href="/login" class="text-indigo-600 hover:text-indigo-700 font-semibold">Se connecter</a>
            </p>
        </div>
    </div>
</div>
@endsection