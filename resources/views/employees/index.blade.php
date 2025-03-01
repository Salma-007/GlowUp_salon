<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord - Employé</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>
<body class="bg-gray-50 font-sans">
    <div class="min-h-screen flex">
        <!-- Sidebar (Identique à l'admin, mais simplifié pour l'employé) -->
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
                            <i class="fas fa-calendar-check mr-3 text-gray-400"></i>
                            Réservations
                        </a>
                        <a href="#" class="text-gray-600 hover:bg-gray-100 group flex items-center px-4 py-3 text-sm font-medium rounded-md">
                            <i class="fas fa-users-cog mr-3 text-gray-400"></i>
                            Profil
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Contenu principal -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white shadow">
                <div class="px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
                    <h1 class="text-xl font-bold text-gray-900">Tableau de Bord - Employé</h1>
                    <button class="text-sm font-semibold text-white bg-pink-600 hover:bg-pink-700 px-4 py-2 rounded-md">
                        <i class="fas fa-sign-out-alt mr-2"></i> Se déconnecter
                    </button>
                </div>
            </header>

            <!-- Sections du tableau de bord -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Section des réservations à venir -->
                    <div class="bg-white shadow rounded-lg p-4">
                        <h2 class="text-lg font-semibold text-gray-900">Réservations à venir</h2>
                        <ul role="list" class="divide-y divide-gray-200">
                            <!-- Exemple de réservation -->
                            <li class="py-3 flex justify-between items-center">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-md bg-pink-100 text-pink-600">
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-pink-600">Manucure</p>
                                        <p class="text-sm text-gray-500">Sarah - 45 min</p>
                                    </div>
                                </div>
                                <div class="text-sm text-gray-500">14:30 - 15:15</div>
                            </li>
                            <!-- Autres réservations à venir -->
                        </ul>
                    </div>

                    <!-- Section des tâches de la journée -->
                    <div class="bg-white shadow rounded-lg p-4">
                        <h2 class="text-lg font-semibold text-gray-900">Tâches de la journée</h2>
                        <ul role="list" class="divide-y divide-gray-200">
                            <!-- Exemple de tâche -->
                            <li class="py-3 flex justify-between items-center">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-md bg-green-100 text-green-600">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-green-600">Préparer l'espace manucure</p>
                                    </div>
                                </div>
                                <div class="text-sm text-gray-500">Terminer avant 13:00</div>
                            </li>
                            <!-- Autres tâches -->
                        </ul>
                    </div>

                    <!-- Section de statut -->
                    <div class="bg-white shadow rounded-lg p-4">
                        <h2 class="text-lg font-semibold text-gray-900">Statut actuel</h2>
                        <div class="flex items-center justify-between">
                            <p class="text-sm text-gray-500">Votre statut : </p>
                            <div class="text-sm font-semibold text-green-600">Disponible</div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
