<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - GlowUp</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>
<body class="bg-gray-50 font-sans">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="hidden md:flex md:w-64 md:flex-col bg-white shadow-lg">
            <div class="flex-1 flex flex-col min-h-0">
                <div class="flex items-center h-16 flex-shrink-0 px-4 bg-pink-600">
                    <span class="text-2xl font-bold text-white">GlowUp</span>
                </div>
                <div class="flex-1 flex flex-col overflow-y-auto">
                    <nav class="flex-1 p-4 space-y-1">
                        <a href="#" class="bg-pink-100 text-pink-600 group flex items-center px-4 py-3 text-sm font-medium rounded-md">
                            <i class="fas fa-tachometer-alt mr-3 text-pink-500"></i>
                            Tableau de bord
                        </a>
                        <a href="#" class="text-gray-600 hover:bg-gray-100 group flex items-center px-4 py-3 text-sm font-medium rounded-md">
                            <i class="fas fa-users mr-3 text-gray-400"></i>
                            Gestion des clients
                        </a>
                        <a href="#" class="text-gray-600 hover:bg-gray-100 group flex items-center px-4 py-3 text-sm font-medium rounded-md">
                            <i class="fas fa-user-tie mr-3 text-gray-400"></i>
                            Gestion des employés
                        </a>
                        <a href="#" class="text-gray-600 hover:bg-gray-100 group flex items-center px-4 py-3 text-sm font-medium rounded-md">
                            <i class="fas fa-cogs mr-3 text-gray-400"></i>
                            Gestion des services
                        </a>
                        <a href="#" class="text-gray-600 hover:bg-gray-100 group flex items-center px-4 py-3 text-sm font-medium rounded-md">
                            <i class="fas fa-calendar-alt mr-3 text-gray-400"></i>
                            Gestion des réservations
                        </a>
                        <div class="pt-8">
                            <div class="space-y-1">
                                <a href="#" class="text-gray-600 hover:bg-gray-100 group flex items-center px-4 py-3 text-sm font-medium rounded-md">
                                    <i class="fas fa-question-circle mr-3 text-gray-400"></i>
                                    Aide & Support
                                </a>
                                <a href="#" class="text-gray-600 hover:bg-gray-100 group flex items-center px-4 py-3 text-sm font-medium rounded-md">
                                    <i class="fas fa-sign-out-alt mr-3 text-gray-400"></i>
                                    Déconnexion
                                </a>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>

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
                        <h1 class="ml-2 md:ml-0 text-xl font-bold text-gray-900">Tableau de bord Admin</h1>
                    </div>
                    <div class="flex items-center">
                        <button class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-md text-sm font-medium mr-4">
                            Ajouter Service
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
                    <h2 class="text-lg font-semibold text-gray-900">Bonjour, Administrateur</h2>
                    <p class="text-gray-600">Voici un résumé de l'activité de l'entreprise et des éléments à gérer</p>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    <div class="bg-white shadow rounded-lg p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 flex items-center justify-center w-12 h-12 rounded-md bg-pink-100 text-pink-600">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="ml-5">
                                <p class="text-sm font-medium text-gray-500">Total Clients</p>
                                <h3 class="text-lg font-semibold text-gray-900">120</h3>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white shadow rounded-lg p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 flex items-center justify-center w-12 h-12 rounded-md bg-pink-100 text-pink-600">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div class="ml-5">
                                <p class="text-sm font-medium text-gray-500">Total Employés</p>
                                <h3 class="text-lg font-semibold text-gray-900">25</h3>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white shadow rounded-lg p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 flex items-center justify-center w-12 h-12 rounded-md bg-pink-100 text-pink-600">
                                <i class="fas fa-cogs"></i>
                            </div>
                            <div class="ml-5">
                                <p class="text-sm font-medium text-gray-500">Total Services</p>
                                <h3 class="text-lg font-semibold text-gray-900">8</h3>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white shadow rounded-lg p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 flex items-center justify-center w-12 h-12 rounded-md bg-pink-100 text-pink-600">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div class="ml-5">
                                <p class="text-sm font-medium text-gray-500">Réservations Aujourd'hui</p>
                                <h3 class="text-lg font-semibold text-gray-900">15</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Clients Management -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Gestion des Clients</h3>
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
                </div>
                
            </main>
        </div>
    </div>
</body>
</html>
