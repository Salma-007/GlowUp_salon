@extends('layouts.client.app')

@section('title', 'Mon Profil')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Mon Profil</h1>

        <!-- Messages de succès/erreur -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <!-- Section Photo de Profil -->
            <div class="bg-pink-50 px-6 py-8 sm:px-10 sm:py-12">
                <div class="flex flex-col sm:flex-row items-center">
                    <!-- Photo de profil -->
                    <div class="relative group mb-4 sm:mb-0 sm:mr-8">
                        <div class="w-32 h-32 rounded-full bg-white shadow-md overflow-hidden">
                            @if(auth()->user()->photo)
                                <img src="{{ asset('storage/' . auth()->user()->photo) }}" 
                                     alt="Photo de profil" 
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-user text-5xl text-gray-400"></i>
                                </div>
                            @endif
                        </div>
                        <!-- Bouton de modification de photo -->
                        <form id="photo-form" method="POST" action="{{ route('profile.update-photo') }}" enctype="multipart/form-data" class="absolute bottom-0 right-0">
                            @csrf
                            <label for="profile_photo" class="cursor-pointer">
                                <div class="bg-pink-600 text-white p-2 rounded-full shadow-lg group-hover:bg-pink-700 transition">
                                    <i class="fas fa-camera"></i>
                                    <input type="file" id="profile_photo" name="profile_photo" class="hidden" accept="image/*">
                                </div>
                            </label>
                        </form>
                    </div>
                    
                    <!-- Informations utilisateur -->
                    <div class="text-center sm:text-left">
                        <h2 class="text-2xl font-bold text-gray-900">{{ auth()->user()->name }}</h2>
                        <p class="text-gray-600 mt-1">{{ auth()->user()->email }}</p>
                        @if(auth()->user()->phone)
                            <p class="text-gray-600 mt-1">
                                <i class="fas fa-phone-alt mr-2"></i>{{ auth()->user()->phone }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Formulaire de modification -->
            <div class="px-6 py-8 sm:px-10">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Modifier mes informations</h2>
                
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <!-- Nom -->
                        <div class="sm:col-span-3">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nom complet</label>
                            <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="sm:col-span-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Adresse email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Téléphone -->
                        <div class="sm:col-span-3">
                            <label for="phone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone', auth()->user()->phone) }}"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Section changement de mot de passe -->
                        <div class="sm:col-span-6 pt-4 border-t border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Changer le mot de passe</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="current_password" class="block text-sm font-medium text-gray-700">Mot de passe actuel</label>
                                    <input type="password" name="current_password" id="current_password"
                                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                                    @error('current_password')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="new_password" class="block text-sm font-medium text-gray-700">Nouveau mot de passe</label>
                                    <input type="password" name="new_password" id="new_password"
                                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                                    @error('new_password')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer le nouveau mot de passe</label>
                                    <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons -->
                    <div class="mt-8 flex justify-end space-x-3">
                        <a href="{{ route('home') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                            Annuler
                        </a>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                            Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script pour la prévisualisation de la photo -->
    <script>
        document.getElementById('profile_photo').addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgElement = document.querySelector('.relative.group img');
                    if (imgElement) {
                        imgElement.src = e.target.result;
                    } else {
                        const divElement = document.querySelector('.relative.group div');
                        divElement.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                    }
                }
                reader.readAsDataURL(this.files[0]);
                document.getElementById('photo-form').submit();
            }
        });
    </script>
@endsection