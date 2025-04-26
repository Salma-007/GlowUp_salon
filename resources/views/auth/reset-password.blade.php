@extends('layouts.auth')

@section('title', 'Réinitialisation du mot de passe')

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
            <p class="text-gray-600 mt-2">Créer un nouveau mot de passe</p>
        </div>

        <form action="{{ route('password.update') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">


            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="email" name="email" required
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200"
                       placeholder="votre@email.com"
                       value="{{ $email ?? old('email') }}">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Nouveau mot de passe</label>
                <div class="relative">
                    <input type="password" id="password" name="password" required
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200"
                           placeholder="••••••••">
                    <div class="absolute right-3 top-3 text-gray-400 cursor-pointer toggle-password">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-1">Minimum 8 caractères</p>
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmer le mot de passe</label>
                <div class="relative">
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200"
                           placeholder="••••••••">
                    <div class="absolute right-3 top-3 text-gray-400 cursor-pointer toggle-password">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                </div>
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
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                    </svg>
                    Réinitialiser le mot de passe
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

<script>
    document.querySelectorAll('.toggle-password').forEach(icon => {
        icon.addEventListener('click', function() {
            const input = this.previousElementSibling;
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            this.querySelector('svg').classList.toggle('text-indigo-600');
        });
    });
</script>
@endsection