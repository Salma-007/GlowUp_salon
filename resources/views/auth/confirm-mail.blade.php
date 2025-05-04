@extends('layouts.auth')

@section('title', 'Vérification du code')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="fixed inset-0 overflow-hidden z-0">
        <img src="{{ asset('storage/services/background_login.jpg') }}" 
             alt="Arrière-plan" 
             class="w-full h-full object-cover blur-md">
        <div class="absolute inset-0 bg-black/40"></div>
    </div>
    
    <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl p-10 w-full mx-4 relative z-10" 
         style="min-width: 450px; max-width: 550px;">
         
        <div class="text-center mb-8">
            <span class="text-3xl font-bold text-indigo-600">GlowUp</span>
            <p class="text-gray-600 mt-2">Vérification du code de sécurité</p>
        </div>

        @if (session('status'))
            <div class="mb-6 p-4 bg-blue-50/80 rounded-lg text-blue-700 text-center border border-blue-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
                </svg>
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('password.validate') }}" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="email" name="email" required
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200"
                       placeholder="votre@email.com"
                       value="{{ old('email') }}">
            </div>

            <div>
                <label for="code" class="block text-sm font-medium text-gray-700 mb-1">Code de vérification</label>
                <div class="relative">
                    <input type="text" id="code" name="code" required
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200"
                           placeholder="Code à 6 chiffres"
                           maxlength="6"
                           pattern="\d{6}">
                    <div class="absolute right-3 top-3 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-1">Entrez le code à 6 chiffres reçu par email</p>
            </div>
            
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-50/80 rounded-lg border border-red-200">
                    <ul class="text-red-600 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="text-sm flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <button type="submit"
                    class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 transition duration-200 shadow-md hover:shadow-indigo-200">
                <span class="flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    Vérifier le code
                </span>
            </button>
        </form>

        <div class="mt-8 text-center">
            <p class="text-gray-600 text-sm">
                <a href="{{ route('login') }}" 
                   class="text-indigo-600 hover:text-indigo-700 font-medium inline-flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Retour à la connexion
                </a>
            </p>
        </div>
    </div>
</div>
@endsection