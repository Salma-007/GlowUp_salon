@extends('layouts.admin.app')

@section('content')
<div class="flex-1 flex flex-col overflow-hidden">
    <!-- Top header -->
    <header class="bg-white shadow-md sticky top-0 z-10">
        <div class="px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">
            <div class="flex items-center">
                <button type="button" class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                    <span class="sr-only">Ouvrir le menu sidebar</span>
                    <i class="fas fa-bars h-5 w-5"></i>
                </button>
                <h1 class="ml-2 md:ml-0 text-xl font-bold text-gray-800">Gestion des Rôles et Permissions</h1>
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

    <!-- Main content area -->
    <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50">
        <div class="max-w-4xl mx-auto">
            <!-- Afficher les messages de succès -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-400 text-green-700">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <!-- Formulaire pour créer un rôle -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Créer un rôle</h3>
                <form action="{{ route('admin.roles.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="roleName" class="block text-sm font-medium text-gray-700 mb-2">Nom du rôle</label>
                        <input type="text" name="name" id="roleName" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <!-- Sélectionner des permissions -->
                    <div class="mb-4">
                        <label for="permissions" class="block text-sm font-medium text-gray-700 mb-2">Sélectionner des permissions</label>
                        <select name="permissions[]" id="permissions" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" multiple>
                            @foreach($permissions as $permission)
                                <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Créer le rôle
                    </button>
                </form>
            </div>

            <!-- Formulaire pour créer une permission -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Créer une permission</h3>
                <form action="{{ route('admin.permissions.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="permissionName" class="block text-sm font-medium text-gray-700 mb-2">Nom de la permission</label>
                        <input type="text" name="name" id="permissionName" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                        Créer la permission
                    </button>
                </form>
            </div>

            <!-- Liste des rôles existants avec pagination -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Rôles existants</h3>
                <ul class="space-y-3">
                    @foreach($roles as $role)
                        <li class="px-4 py-3 bg-gray-50 rounded-lg flex justify-between items-center">
                            <span class="text-gray-700">{{ $role->name }}</span>
                            <div class="flex items-center gap-2">
                                <!-- Bouton de modification -->
                                <a href="{{ route('admin.roles.edit', $role->id) }}" class="px-3 py-1 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
                                    Modifier
                                </a>
                                <!-- Bouton de suppression -->
                                <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce rôle ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <!-- Lien de pagination -->
                <div class="mt-4">
                    {{ $roles->links() }}
                </div>
            </div>

            <!-- Liste des permissions existantes -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Permissions existantes</h3>
                <ul class="space-y-3">
                    @foreach($permissions as $permission)
                        <li class="px-4 py-3 bg-gray-50 rounded-lg flex justify-between items-center">
                            <span class="text-gray-700">{{ $permission->name }}</span>
                            <!-- Bouton de suppression -->
                            <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette permission ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                    Supprimer
                                </button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </main>
</div>
@endsection