@extends('layouts.admin.app')

@section('content')
        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top header -->
            <header class="bg-white shadow">
                <div class="px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
                    <div class="flex items-center">
                        <button type="button" class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-pink-500">
                            <span class="sr-only">Open sidebar</span>
                            <i class="fas fa-bars h-6 w-6"></i>
                        </button>
                        <h1 class="ml-2 md:ml-0 text-xl font-bold text-gray-900">Tableau de bord</h1>
                    </div>
                    <div class="flex items-center">
                        <button class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-md text-sm font-medium mr-4">
                            Nouvelle réservation
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
                    <h2 class="text-lg font-semibold text-gray-900">Bonjour, Marie</h2>
                    <p class="text-gray-600">Voici un résumé de vos activités et rendez-vous à venir</p>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    <div class="bg-white shadow rounded-lg p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 flex items-center justify-center w-12 h-12 rounded-md bg-pink-100 text-pink-600">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div class="ml-5">
                                <p class="text-sm font-medium text-gray-500">Prochain rendez-vous</p>
                                <h3 class="text-lg font-semibold text-gray-900">12 Mars</h3>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white shadow rounded-lg p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 flex items-center justify-center w-12 h-12 rounded-md bg-pink-100 text-pink-600">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="ml-5">
                                <p class="text-sm font-medium text-gray-500">Heure</p>
                                <h3 class="text-lg font-semibold text-gray-900">14:30</h3>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white shadow rounded-lg p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 flex items-center justify-center w-12 h-12 rounded-md bg-pink-100 text-pink-600">
                                <i class="fas fa-spa"></i>
                            </div>
                            <div class="ml-5">
                                <p class="text-sm font-medium text-gray-500">Service réservé</p>
                                <h3 class="text-lg font-semibold text-gray-900">Manucure</h3>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white shadow rounded-lg p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 flex items-center justify-center w-12 h-12 rounded-md bg-pink-100 text-pink-600">
                                <i class="fas fa-history"></i>
                            </div>
                            <div class="ml-5">
                                <p class="text-sm font-medium text-gray-500">Total des visites</p>
                                <h3 class="text-lg font-semibold text-gray-900">8</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upcoming appointments -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Rendez-vous à venir</h3>
                    <div class="bg-white shadow overflow-hidden sm:rounded-md">
                        <ul role="list" class="divide-y divide-gray-200">
                            <li>
                                <div class="block hover:bg-gray-50">
                                    <div class="px-4 py-4 sm:px-6">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-md bg-pink-100 text-pink-600">
                                                    <i class="fas fa-hand-sparkles"></i>
                                                </div>
                                                <div class="ml-4">
                                                    <p class="text-sm font-medium text-pink-600">Manucure & Pédicure</p>
                                                    <p class="text-sm text-gray-500">60 min avec Sarah</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center">
                                                <div class="mr-4 flex flex-col text-right">
                                                    <p class="text-sm font-semibold text-gray-900">12 Mars 2025</p>
                                                    <p class="text-sm text-gray-500">14:30 - 15:30</p>
                                                </div>
                                                <div class="flex space-x-2">
                                                    <button class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-pink-700 bg-pink-100 hover:bg-pink-200">
                                                        <i class="fas fa-edit mr-1"></i> Modifier
                                                    </button>
                                                    <button class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200">
                                                        <i class="fas fa-times mr-1"></i> Annuler
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="block hover:bg-gray-50">
                                    <div class="px-4 py-4 sm:px-6">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-md bg-pink-100 text-pink-600">
                                                    <i class="fas fa-spa"></i>
                                                </div>
                                                <div class="ml-4">
                                                    <p class="text-sm font-medium text-pink-600">Soin du visage</p>
                                                    <p class="text-sm text-gray-500">45 min avec Julie</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center">
                                                <div class="mr-4 flex flex-col text-right">
                                                    <p class="text-sm font-semibold text-gray-900">20 Mars 2025</p>
                                                    <p class="text-sm text-gray-500">10:00 - 10:45</p>
                                                </div>
                                                <div class="flex space-x-2">
                                                    <button class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-pink-700 bg-pink-100 hover:bg-pink-200">
                                                        <i class="fas fa-edit mr-1"></i> Modifier
                                                    </button>
                                                    <button class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200">
                                                        <i class="fas fa-times mr-1"></i> Annuler
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Recent appointments history -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Historique récent</h3>
                    <div class="bg-white shadow overflow-hidden sm:rounded-md">
                        <ul role="list" class="divide-y divide-gray-200">
                            <li>
                                <div class="block hover:bg-gray-50">
                                    <div class="px-4 py-4 sm:px-6">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-md bg-gray-200 text-gray-600">
                                                    <i class="fas fa-cut"></i>
                                                </div>
                                                <div class="ml-4">
                                                    <p class="text-sm font-medium text-gray-600">Coupe & Coiffure</p>
                                                    <p class="text-sm text-gray-500">75 min avec Marc</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center">
                                                <div class="mr-4 flex flex-col text-right">
                                                    <p class="text-sm font-semibold text-gray-900">28 Février 2025</p>
                                                    <div class="inline-flex items-center text-sm text-gray-500">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            Complété
                                                        </span>
                                                    </div>
                                                </div>
                                                <button class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-pink-700 bg-pink-100 hover:bg-pink-200">
                                                    <i class="fas fa-redo mr-1"></i> Réserver à nouveau
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="block hover:bg-gray-50">
                                    <div class="px-4 py-4 sm:px-6">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-md bg-gray-200 text-gray-600">
                                                    <i class="fas fa-hand-sparkles"></i>
                                                </div>
                                                <div class="ml-4">
                                                    <p class="text-sm font-medium text-gray-600">Manucure</p>
                                                    <p class="text-sm text-gray-500">45 min avec Sarah</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center">
                                                <div class="mr-4 flex flex-col text-right">
                                                    <p class="text-sm font-semibold text-gray-900">15 Février 2025</p>
                                                    <div class="inline-flex items-center text-sm text-gray-500">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            Complété
                                                        </span>
                                                    </div>
                                                </div>
                                                <button class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-pink-700 bg-pink-100 hover:bg-pink-200">
                                                    <i class="fas fa-redo mr-1"></i> Réserver à nouveau
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </main>
        </div>
@endsection