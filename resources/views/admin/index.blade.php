@extends('layouts.admin.app')

@section('content')
<!-- Main content -->
<div class="flex-1 flex flex-col overflow-hidden">
    <!-- Top header -->
    <header class="bg-white shadow-md sticky top-0 z-10">
        <div class="px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">
            <div class="flex items-center">
                <button type="button" class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                    <span class="sr-only">Ouvrir le menu sidebar</span>
                    <i class="fas fa-bars h-5 w-5"></i>
                </button>
                <h1 class="ml-2 md:ml-0 text-xl font-bold text-gray-800">Tableau de bord</h1>
            </div>
            <div class="flex items-center gap-4">
                <div class="relative">
                    <button class="text-gray-500 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100 transition-colors">
                        <i class="fas fa-bell"></i>
                        <span class="absolute top-0 right-0 h-4 w-4 bg-red-500 rounded-full text-xs text-white flex items-center justify-center">3</span>
                    </button>
                </div>
                <a href="/admin/add-service" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-300 flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Ajouter Service
                </a>
                <div class="relative">
                    <button type="button" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" id="user-menu-button">
                        <span class="sr-only">Ouvrir le menu utilisateur</span>
                        <div class="flex items-center">
                            <img class="h-8 w-8 rounded-full object-cover border-2 border-gray-200" src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Photo de profil">
                            <span class="hidden md:block ml-2 text-gray-700">Admin</span>
                            <i class="fas fa-chevron-down ml-1 text-xs text-gray-500"></i>
                        </div>
                    </button>
                    <!-- Dropdown menu -->
                    <div class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden" role="menu">
                        <div class="py-1">
                            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user mr-2 text-gray-500"></i> Profil
                            </a>
                            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-cog mr-2 text-gray-500"></i> Paramètres
                            </a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <a href="#" class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main content area -->
    <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50">
        <div class="max-w-7xl mx-auto">
            <!-- Welcome section -->
            <div class="bg-white rounded-xl shadow-md p-6 mb-8 border border-gray-100">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Bonjour, Administrateur</h2>
                        <p class="text-gray-600 mt-1">{{ now()->format('l, d F Y') }}</p>
                    </div>
                    <div class="mt-4 md:mt-0 flex space-x-3">
                        <a href="/admin/reports" class="text-blue-600 hover:text-blue-800 font-medium flex items-center">
                            <i class="fas fa-file-alt mr-1"></i> Rapports
                        </a>
                        <a href="/admin/settings" class="text-blue-600 hover:text-blue-800 font-medium flex items-center">
                            <i class="fas fa-cog mr-1"></i> Paramètres
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 transition-all duration-300 hover:shadow-lg hover:border-blue-100">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 flex items-center justify-center w-12 h-12 rounded-lg bg-blue-100 text-blue-600">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="ml-5">
                            <p class="text-sm font-medium text-gray-500">Total Clients</p>
                            <div class="flex items-end">
                                <h3 class="text-2xl font-bold text-gray-900">120</h3>
                                <span class="ml-2 text-xs font-medium text-green-600 flex items-center">
                                    <i class="fas fa-arrow-up mr-1"></i> 12%
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-100">
                        <a href="/admin/clients" class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center justify-between">
                            Voir tous les clients
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 transition-all duration-300 hover:shadow-lg hover:border-blue-100">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 flex items-center justify-center w-12 h-12 rounded-lg bg-emerald-100 text-emerald-600">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="ml-5">
                            <p class="text-sm font-medium text-gray-500">Total Employés</p>
                            <div class="flex items-end">
                                <h3 class="text-2xl font-bold text-gray-900">25</h3>
                                <span class="ml-2 text-xs font-medium text-green-600 flex items-center">
                                    <i class="fas fa-arrow-up mr-1"></i> 4%
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-100">
                        <a href="/admin/employees" class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center justify-between">
                            Voir tous les employés
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 transition-all duration-300 hover:shadow-lg hover:border-blue-100">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 flex items-center justify-center w-12 h-12 rounded-lg bg-purple-100 text-purple-600">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <div class="ml-5">
                            <p class="text-sm font-medium text-gray-500">Total Services</p>
                            <div class="flex items-end">
                                <h3 class="text-2xl font-bold text-gray-900">8</h3>
                                <span class="ml-2 text-xs font-medium text-yellow-600 flex items-center">
                                    <i class="fas fa-equals mr-1"></i> 0%
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-100">
                        <a href="/admin/services" class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center justify-between">
                            Voir tous les services
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 transition-all duration-300 hover:shadow-lg hover:border-blue-100">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 flex items-center justify-center w-12 h-12 rounded-lg bg-amber-100 text-amber-600">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="ml-5">
                            <p class="text-sm font-medium text-gray-500">Réservations Aujourd'hui</p>
                            <div class="flex items-end">
                                <h3 class="text-2xl font-bold text-gray-900">15</h3>
                                <span class="ml-2 text-xs font-medium text-green-600 flex items-center">
                                    <i class="fas fa-arrow-up mr-1"></i> 8%
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-100">
                        <a href="/admin/reservations" class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center justify-between">
                            Voir toutes les réservations
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Activity and Recent Bookings -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Recent Activity -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">Activité Récente</h3>
                        <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">Voir tout</button>
                    </div>
                    <div class="divide-y divide-gray-100">
                        <div class="px-6 py-4 flex items-start">
                            <div class="flex-shrink-0 bg-green-100 rounded-md p-2 text-green-600">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">Nouveau client enregistré</p>
                                <p class="text-sm text-gray-500">Thomas Martin s'est inscrit</p>
                                <p class="text-xs text-gray-400 mt-1">Il y a 35 minutes</p>
                            </div>
                        </div>
                        <div class="px-6 py-4 flex items-start">
                            <div class="flex-shrink-0 bg-blue-100 rounded-md p-2 text-blue-600">
                                <i class="fas fa-calendar-plus"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">Nouvelle réservation</p>
                                <p class="text-sm text-gray-500">Marie Dupont a réservé Massage Relaxant</p>
                                <p class="text-xs text-gray-400 mt-1">Il y a 2 heures</p>
                            </div>
                        </div>
                        <div class="px-6 py-4 flex items-start">
                            <div class="flex-shrink-0 bg-amber-100 rounded-md p-2 text-amber-600">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">Nouvel avis client</p>
                                <p class="text-sm text-gray-500">Pierre Durand a laissé un avis 5 étoiles</p>
                                <p class="text-xs text-gray-400 mt-1">Il y a 4 heures</p>
                            </div>
                        </div>
                        <div class="px-6 py-4 flex items-start">
                            <div class="flex-shrink-0 bg-purple-100 rounded-md p-2 text-purple-600">
                                <i class="fas fa-cog"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">Service mis à jour</p>
                                <p class="text-sm text-gray-500">Le prix du service "Soin Visage" a été mis à jour</p>
                                <p class="text-xs text-gray-400 mt-1">Il y a 6 heures</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Today's Bookings -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">Réservations Aujourd'hui</h3>
                        <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">Voir tout</button>
                    </div>
                    <div class="divide-y divide-gray-100">
                        <div class="px-6 py-4 flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-semibold">
                                    MD
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Marie Dupont</p>
                                    <p class="text-xs text-gray-500">Massage Relaxant • 14:00 - 15:30</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                                    Confirmé
                                </span>
                                <button class="ml-2 text-gray-500 hover:text-gray-700">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                            </div>
                        </div>
                        <div class="px-6 py-4 flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-semibold">
                                    PL
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Paul Lefebvre</p>
                                    <p class="text-xs text-gray-500">Coupe Homme • 15:00 - 15:45</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <span class="px-2 py-1 bg-amber-100 text-amber-800 text-xs rounded-full">
                                    En attente
                                </span>
                                <button class="ml-2 text-gray-500 hover:text-gray-700">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                            </div>
                        </div>
                        <div class="px-6 py-4 flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-semibold">
                                    SR
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Sophie Robert</p>
                                    <p class="text-xs text-gray-500">Manucure • 16:00 - 17:00</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                                    Confirmé
                                </span>
                                <button class="ml-2 text-gray-500 hover:text-gray-700">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                            </div>
                        </div>
                        <div class="px-6 py-4 flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-semibold">
                                    JD
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Jean Dubois</p>
                                    <p class="text-xs text-gray-500">Massage Sportif • 17:30 - 18:30</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                    Arrivé
                                </span>
                                <button class="ml-2 text-gray-500 hover:text-gray-700">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Clients Management -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Clients Récents</h3>
                    <a href="/admin/clients" class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center">
                        Voir tous les clients
                        <i class="fas fa-chevron-right ml-1 text-xs"></i>
                    </a>
                </div>
                <div class="bg-white shadow-md rounded-xl overflow-hidden border border-gray-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Réservations</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr class="hover:bg-gray-50 transition duration-300">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600">
                                                <span class="font-medium">MD</span>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">Marie Dupont</div>
                                                <div class="text-sm text-gray-500">Client depuis Jan 2023</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">marie.dupont@example.com</div>
                                        <div class="text-sm text-gray-500">+33 6 12 34 56 78</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">5 réservations</div>
                                        <div class="text-sm text-gray-500">Dernière: 10/03/2025</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Actif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button class="text-blue-600 hover:text-blue-900 mr-3">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="text-indigo-600 hover:text-indigo-900 mr-3">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition duration-300">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                                                <span class="font-medium">TM</span>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">Thomas Martin</div>
                                                <div class="text-sm text-gray-500">Client depuis Mar 2025</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">thomas.martin@example.com</div>
                                        <div class="text-sm text-gray-500">+33 6 98 76 54 32</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">1 réservation</div>
                                        <div class="text-sm text-gray-500">Dernière: 10/03/2025</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Actif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button class="text-blue-600 hover:text-blue-900 mr-3">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="text-indigo-600 hover:text-indigo-900 mr-3">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition duration-300">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-600">
                                                <span class="font-medium">PD</span>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">Pierre Durand</div>
                                                <div class="text-sm text-gray-500">Client depuis Fév 2024</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">pierre.durand@example.com</div>
                                        <div class="text-sm text-gray-500">+33 6 45 67 89 10</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">3 réservations</div>
                                        <div class="text-sm text-gray-500">Dernière: 08/03/2025</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Actif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button class="text-blue-600 hover:text-blue-900 mr-3">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="text-indigo-600 hover:text-indigo-900 mr-3">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

@endsection