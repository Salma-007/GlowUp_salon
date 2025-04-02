@extends('layouts.admin.app')

@section('content')
<header class="bg-white shadow-md sticky top-0 z-10">
    <div class="px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">
        <div class="flex items-center">
            <button type="button" class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                <span class="sr-only">Ouvrir le menu sidebar</span>
                <i class="fas fa-bars h-5 w-5"></i>
            </button>
            <h1 class="ml-2 md:ml-0 text-xl font-bold text-gray-800">Modifier un Service</h1>
        </div>
        <div class="flex items-center gap-4">
            <div class="relative">
                <button class="text-gray-500 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100 transition-colors">
                    <i class="fas fa-bell"></i>
                    <span class="absolute top-0 right-0 h-4 w-4 bg-red-500 rounded-full text-xs text-white flex items-center justify-center">3</span>
                </button>
            </div>
            <div class="relative">
                <button type="button" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" id="user-menu-button">
                    <span class="sr-only">Ouvrir le menu utilisateur</span>
                    <div class="flex items-center">
                        <img class="h-8 w-8 rounded-full object-cover border-2 border-gray-200" src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Photo de profil">
                        <span class="hidden md:block ml-2 text-gray-700">Admin</span>
                        <i class="fas fa-chevron-down ml-1 text-xs text-gray-500"></i>
                    </div>
                </button>
            </div>
        </div>
    </div>
</header>

<div class="bg-white shadow-lg rounded-lg p-6 max-w-2xl mx-auto">
    <h2 class="text-xl font-semibold text-gray-900 mb-6">Modifier le service</h2>

    <!-- Affichage des messages de succès ou d'erreur -->
    @if(session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger text-red-500 mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger text-red-500 mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulaire de modification -->
    <form action="{{ route('services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Nom du service -->
        <div class="mb-6">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nom du service</label>
            <input type="text" id="name" name="name" value="{{ old('name', $service->name) }}" placeholder="Entrez le nom du service" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-300">
        </div>

        <!-- Description du service -->
        <div class="mb-6">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description du service</label>
            <textarea id="description" name="description" rows="4" placeholder="Entrez la description du service" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-300">{{ old('description', $service->description) }}</textarea>
        </div>

        <!-- Catégorie du service -->
        <div class="mb-6">
            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Catégorie</label>
            <select id="category_id" name="category_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-300">
                @foreach($categories as $categorie)
                    <option value="{{ $categorie->id }}" {{ $categorie->id == $service->category_id ? 'selected' : '' }}>
                        {{ $categorie->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Prix du service -->
        <div class="mb-6">
            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Prix (€)</label>
            <input type="number" id="price" name="price" value="{{ old('price', $service->price) }}" placeholder="Entrez le prix du service" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-300">
        </div>

        <!-- Durée du service -->
        <div class="mb-6">
            <label for="duration" class="block text-sm font-medium text-gray-700 mb-2">Durée (minutes)</label>
            <input type="number" id="duration" name="duration" value="{{ old('duration', $service->duration) }}" placeholder="Entrez la durée du service" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-300">
        </div>

        <!-- Image du service -->
        <div class="mb-6">
            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Photo du service</label>
            <div id="image-preview-container">
                <!-- Afficher l'image actuelle avec un ID pour pouvoir la supprimer -->
                @if($service->image)
                    <div class="mb-4" id="current-image-container">
                        <img src="{{ asset('storage/' . $service->image) }}" 
                            alt="Photo actuelle du service" 
                            class="h-32 w-32 object-cover rounded-lg border border-gray-200"
                            id="current-image">
                        <p class="mt-1 text-sm text-gray-500">Image actuelle</p>
                    </div>
                @endif

                <!-- Champ d'upload -->
                <input type="file" id="image" name="image" accept="image/*" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-300">
            
            <!-- Conteneur pour la prévisualisation -->
            <div id="new-image-preview" class="mt-4 hidden">
                <p class="text-sm text-green-600 mb-2">Nouvelle image sélectionnée :</p>
                <img id="preview-image" class="h-32 w-32 object-cover rounded-lg border border-gray-200">
            </div>
            </div>
        </div>

        <!-- Boutons d'action -->
        <div class="flex justify-end space-x-4">
            <a href="{{ route('admin.services.index') }}" class="px-6 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 focus:ring-2 focus:ring-gray-500 transition duration-300">
                Annuler
            </a>
            <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 transition duration-300">
                Enregistrer les modifications
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const imageInput = document.getElementById('image');
        const previewContainer = document.getElementById('new-image-preview');
        const previewImage = document.getElementById('preview-image');
        const currentImageWrapper = document.getElementById('current-image-wrapper');

        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(event) {
                    // Afficher la prévisualisation
                    previewImage.src = event.target.result;
                    previewContainer.classList.remove('hidden');
                    
                    // Masquer l'image actuelle si elle existe
                    if (currentImageWrapper) {
                        currentImageWrapper.classList.add('hidden');
                    }
                };
                
                reader.readAsDataURL(file);
            } else {
                // Si aucun fichier sélectionné
                previewContainer.classList.add('hidden');
                if (currentImageWrapper) {
                    currentImageWrapper.classList.remove('hidden');
                }
            }
        });
    });
</script>
@endsection