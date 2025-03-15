@extends('layouts.auth')

@section('title', 'Réinitialiser le mot de passe')

@section('content')
<div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl p-8 w-full max-w-md">
    <div class="text-center mb-8">
        <span class="text-3xl font-bold text-indigo-600">GlowUp</span>
        <p class="text-gray-600 mt-2">Réinitialiser votre mot de passe</p>
    </div>

    <form action="{{ route('password.update') }}" method="POST" class="space-y-6">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <div class="mt-1">
                <input type="email" id="email" name="email" required
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-300"
                       placeholder="votre@email.com">
            </div>
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Nouveau mot de passe</label>
            <div class="mt-1">
                <input type="password" id="password" name="password" required
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-300"
                       placeholder="••••••••">
            </div>
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer le mot de passe</label>
            <div class="mt-1">
                <input type="password" id="password_confirmation" name="password_confirmation" required
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-300"
                       placeholder="••••••••">
            </div>
        </div>
        @if ($errors->any())
            <div class="alert text-red-600">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div>
            <button type="submit"
                    class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 transition duration-300">
                Réinitialiser le mot de passe
            </button>
        </div>
    </form>

    <div class="mt-6 text-center">
        <p class="text-gray-600">Retour à la <a href="{{ route('loginpage') }}" class="text-indigo-600 hover:text-indigo-700 font-semibold">connexion</a></p>
    </div>
</div>
@endsection