<div class="hidden md:flex md:w-64 md:flex-col bg-white shadow-xl border-r border-gray-100">
    <div class="flex-1 flex flex-col min-h-0">
        <!-- Sidebar Header -->
        <div class="flex items-center h-20 flex-shrink-0 px-6 bg-gradient-to-r from-indigo-600 to-purple-600 shadow-sm">
            <span class="text-2xl font-bold text-white tracking-tight">GlowUp</span>
        </div>

        <!-- Sidebar Navigation -->
        <div class="flex-1 flex flex-col overflow-y-auto">
            <nav class="flex-1 px-4 py-6 space-y-1">
                <!-- Dashboard Link -->
                <a href="/admin/dashboard" class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-300 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 hover:text-indigo-900 shadow-sm">
                    <i class="fas fa-tachometer-alt mr-3 text-indigo-500 group-hover:text-indigo-700"></i>
                    Tableau de bord
                </a>

                <!-- Clients Link -->
                <a href="/admin/clients" class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-300 text-gray-600 hover:bg-gray-50 hover:text-gray-900 hover:shadow-sm">
                    <i class="fas fa-users mr-3 text-gray-400 group-hover:text-gray-600"></i>
                    Gestion des clients
                </a>

                <!-- Employees Link -->
                <a href="/admin/employees" class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-300 text-gray-600 hover:bg-gray-50 hover:text-gray-900 hover:shadow-sm">
                    <i class="fas fa-user-tie mr-3 text-gray-400 group-hover:text-gray-600"></i>
                    Gestion des employés
                </a>

                <!-- Services Link -->
                <a href="/admin/services" class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-300 text-gray-600 hover:bg-gray-50 hover:text-gray-900 hover:shadow-sm">
                    <i class="fas fa-cogs mr-3 text-gray-400 group-hover:text-gray-600"></i>
                    Gestion des services
                </a>

                <!-- Reservations Link -->
                <a href="/admin/reservations" class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-300 text-gray-600 hover:bg-gray-50 hover:text-gray-900 hover:shadow-sm">
                    <i class="fas fa-calendar-alt mr-3 text-gray-400 group-hover:text-gray-600"></i>
                    Gestion des réservations
                </a>

                <!-- Roles and Permissions Link -->
                <a href="{{ route('admin.roles_permissions.index') }}" class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-300 text-gray-600 hover:bg-gray-50 hover:text-gray-900 hover:shadow-sm">
                    <i class="fas fa-user-shield mr-3 text-gray-400 group-hover:text-gray-600"></i>
                    Gestion des rôles
                </a>

                <!-- Logout Link -->
                <div class="pt-8">
                    <div class="space-y-1">
                    <form action="{{ route('logout') }}" method="POST">
                    @csrf
                        <button type="submit" class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-300 text-gray-600 hover:bg-gray-50 hover:text-gray-900 hover:shadow-sm">
                            <i class="fas fa-sign-out-alt mr-3 text-gray-400 group-hover:text-gray-600"></i>
                            Déconnexion
                        </button>
                    </form>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>