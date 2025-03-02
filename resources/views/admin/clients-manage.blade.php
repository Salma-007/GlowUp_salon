@extends('layouts.admin.app')

@section('content')

    <!-- Main content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top header -->
        <header class="bg-white shadow">
            <div class="px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
                <div class="flex items-center">
                    <button type="button" class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-pink-500">
                        <span class="sr-only">Ouvrir le menu sidebar</span>
                        <i class="fas fa-bars h-6 w-6"></i>
                    </button>
                    <h1 class="ml-2 md:ml-0 text-xl font-bold text-gray-900">Gestion des Clients</h1>
                </div>
                <div class="flex items-center">
                    <button class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-md text-sm font-medium mr-4">
                        Ajouter Client
                    </button>
                    <div class="ml-3 relative">
                        <div>
                            <button type="button" class="max-w-xs flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500" id="user-menu-button">
                                <span class="sr-only">Ouvrir le menu utilisateur</span>
                                <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Photo de profil">
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main content area -->
        <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50">
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-900">Liste des Clients</h2>
                <p class="text-gray-600">Gérez les clients de votre entreprise</p>
            </div>

            <!-- Clients Table -->
            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <ul role="list" class="divide-y divide-gray-200">
                    <li>
                        <div class="block hover:bg-gray-50">
                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-md bg-pink-100 text-pink-600">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-pink-600">Marie Dupont</p>
                                            <p class="text-sm text-gray-500">5 réservations</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <button class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-pink-700 bg-pink-100 hover:bg-pink-200">
                                            <i class="fas fa-edit mr-1"></i> Modifier
                                        </button>
                                        <button class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200">
                                            <i class="fas fa-trash mr-1"></i> Supprimer
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <!-- Ajouter d'autres clients ici -->
                </ul>
            </div>
        </main>
    </div>

@endsection