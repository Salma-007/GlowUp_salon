@extends('layouts.admin.app')

@section('content')
    <!-- Top header -->
    <header class="bg-white shadow-md sticky top-0 z-10">
        <div class="px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">
            <div class="flex items-center">
                <button type="button" class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                    <span class="sr-only">Ouvrir le menu sidebar</span>
                    <i class="fas fa-bars h-5 w-5"></i>
                </button>
                <h1 class="ml-2 md:ml-0 text-xl font-bold text-gray-800">Gestion des employés</h1>
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

    <!-- Main content -->
    <div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-blue-50 p-6 border-b border-blue-100">
                <h2 class="text-xl font-semibold text-blue-800">Informations de l'employé</h2>
                <p class="text-blue-600 mt-1">Veuillez remplir les informations suivantes</p>
            </div>
            
            <form action="{{ route('ajouter') }}" method="POST" class="p-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Colonne gauche -->
                    <div>
                        <!-- Nom -->
                        <div class="mb-6">
                            <label for="nom" class="block text-gray-800 font-bold mb-2">Nom complet</label>
                            <input type="text" name="nom" id="nom" required
                                class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <!-- Email -->
                        <div class="mb-6">
                            <label for="email" class="block text-gray-800 font-bold mb-2">Adresse email</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <input type="email" name="email" id="email" required
                                    class="w-full pl-10 pr-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Colonne droite -->
                    <div>
                        <!-- Téléphone -->
                        <div class="mb-6">
                            <label for="telephone" class="block text-gray-800 font-bold mb-2">Numéro de téléphone</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-phone text-gray-400"></i>
                                </div>
                                <input type="tel" name="telephone" id="telephone" required
                                    class="w-full pl-10 pr-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                        
                        <!-- Rôle -->
                        <div class="mb-6">
                            <label for="role" class="block text-gray-800 font-bold mb-2">Rôle</label>
                            <div class="relative">
                                <select name="role" id="role" required
                                    class="appearance-none w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Sélectionner un rôle</option>
                                    <option value="coiffeur">Coiffeur</option>
                                    <option value="coloriste">Coloriste</option>
                                    <option value="estheticien">Esthéticien(ne)</option>
                                    <option value="reception">Réceptionniste</option>
                                    <option value="manager">Manager</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Statut -->
                <div class="mt-2 mb-8">
                    <label class="block text-gray-800 font-bold mb-3">Statut</label>
                    <div class="flex items-center space-x-6">
                        <label class="inline-flex items-center">
                            <input type="radio" name="statut" value="actif" class="form-radio h-5 w-5 text-blue-600" checked>
                            <span class="ml-2 text-gray-700">Actif</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="statut" value="inactif" class="form-radio h-5 w-5 text-blue-600">
                            <span class="ml-2 text-gray-700">Inactif</span>
                        </label>
                    </div>
                </div>
                
                <!-- Ligne de séparation -->
                <div class="border-t border-gray-200 mt-8 mb-6"></div>
                
                <!-- Buttons -->
                <div class="flex justify-end space-x-4">
                    <a href="/admin/employes" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-200 font-medium">
                        Annuler
                    </a>
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 font-medium">
                        <i class="fas fa-user-plus mr-2"></i>
                        Ajouter l'employé
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection