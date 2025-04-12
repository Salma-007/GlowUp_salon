@extends('layouts.admin.app')

@section('content')
<div class="flex-1 flex flex-col overflow-hidden">

        <header class="bg-white shadow-md sticky top-0 z-10">
    <div class="px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">
        <h1 class="text-xl font-bold text-gray-800">Editer mon profil</h1>
        
        <div class="flex items-center gap-4 ml-auto">

            <div class="relative">
                <button type="button" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <span class="sr-only">Ouvrir le menu utilisateur</span>
                    <div class="flex items-center">
                        @if(Auth::user()->photo)
                            <img class="h-8 w-8 rounded-full object-cover" 
                                src="{{ asset('storage/' . Auth::user()->photo) }}" 
                                alt="Photo de profil de {{ Auth::user()->name }}">
                        @else
                            <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                                <i class="fas fa-user text-gray-500"></i>
                            </div>
                        @endif
                        <span class="hidden md:block ml-2 text-gray-700">{{ Auth::user()->name }}</span>
                    </div>
                </button>
            </div>
        </div>
    </div>
</header>
    <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white shadow-md rounded-xl overflow-hidden border border-gray-100">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Mon Profil</h3>
                    <p class="mt-1 text-sm text-gray-500">Gérez vos informations personnelles et votre mot de passe</p>
                </div>

                <div class="p-6">
                    @if (session('success'))
                        <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <!-- Photo de profil -->
                            <div class="flex items-center">
                            <div class="mr-4 photo-preview">
                                @if(auth()->user()->photo)
                                    <img class="h-16 w-16 rounded-full object-cover" 
                                        src="{{ asset('storage/' . auth()->user()->photo) }}" 
                                        alt="Photo de profil">
                                @else
                                    <div class="h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center">
                                        <i class="fas fa-user text-gray-500 text-xl"></i>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <input type="file" name="photo" id="photo" class="hidden" accept="image/*">
                                <label for="photo" class="cursor-pointer px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Changer de photo
                                </label>
                                <p class="mt-1 text-xs text-gray-500">JPEG, PNG ou GIF (max. 2MB)</p>
                                @error('photo')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                            <!-- Nom -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nom complet</label>
                                <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Adresse email</label>
                                <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Bouton de soumission -->
                            <div class="flex justify-end">
                                <button type="submit"
                                    class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Enregistrer les modifications
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Séparateur -->
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <h4 class="text-lg font-medium text-gray-900">Changer de mot de passe</h4>
                        <p class="mt-1 text-sm text-gray-500">Assurez-vous d'utiliser un mot de passe long et sécurisé.</p>
                    </div>

                    <form method="POST" action="{{ route('profile.password.update') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700">Mot de passe actuel</label>
                            <input type="password" name="current_password" id="current_password" autocomplete="current-password"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @error('current_password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Nouveau mot de passe</label>
                            <input type="password" name="password" id="password" autocomplete="new-password"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer le nouveau mot de passe</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Changer le mot de passe
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const photoInput = document.getElementById('photo');
    const photoPreview = document.querySelector('.photo-preview');
    
    photoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            
            reader.onload = function(event) {

                if (photoPreview.querySelector('img')) {

                    photoPreview.querySelector('img').src = event.target.result;
                } else if (photoPreview.querySelector('div')) {
                    const img = document.createElement('img');
                    img.className = 'h-16 w-16 rounded-full object-cover';
                    img.src = event.target.result;
                    img.alt = 'Photo sélectionnée';
                    photoPreview.innerHTML = '';
                    photoPreview.appendChild(img);
                }
            };
            
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endsection