@extends('layouts.auth')

@section('title', 'Connexion')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4 bg-gray-100">

    <div class="fixed inset-0 overflow-hidden z-0">
        <img src="{{ asset('storage/services/background_login.jpg') }}" 
             alt="Background" 
             class="w-full h-full object-cover blur-sm">
        <div class="absolute inset-0 bg-black/30"></div>
    </div>
    

    <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-2xl p-8 w-full mx-4 relative z-10" style="width: 450px;">
        <div class="text-center mb-8">
            <span class="text-3xl font-bold text-indigo-600">GlowUp</span>
            <p class="text-gray-600 mt-2">Connectez-vous</p>
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

        <form action="{{ route('loginIn') }}" method="POST" class="space-y-6">
            @csrf
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
                <button type="submit"
                        class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 transition duration-300">
                    Se connecter
                </button>
            </div>
        </form>
        
        <div class="mt-4 text-center">
            <p class="text-gray-600">
                <a href="{{ route('password.request') }}" class="text-indigo-600 hover:text-indigo-700 font-semibold">
                    Mot de passe oublié ?
                </a>
            </p>
        </div>

        <div class="mt-6 text-center">
            <p class="text-gray-600">Pas encore de compte ? 
                <a href="/register" class="text-indigo-600 hover:text-indigo-700 font-semibold">S'inscrire</a>
            </p>
        </div>
    </div>
</div>
@endsection