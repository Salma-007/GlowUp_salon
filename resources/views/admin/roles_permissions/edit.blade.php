@extends('layouts.admin.app')

@section('content')

<div class="flex flex-col min-h-screen">
    <!-- Header -->
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
                    <button type="button" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <span class="sr-only">Ouvrir le menu utilisateur</span>
                        <div class="flex items-center">
                            @if(Auth::user()->photo)
                                <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Photo de profil de {{ Auth::user()->name }}">
                            @else
                                <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-user text-gray-500"></i>
                                </div>
                            @endif
                            <span class="hidden md:block ml-2 text-gray-700">{{ Auth::user()->name }}</span>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Contenu principal -->
    <div class="flex-grow flex items-center justify-center">
        <div class="max-w-4xl w-full mx-auto p-6 bg-white shadow-lg rounded-lg mt-0">
            <h1 class="text-3xl font-semibold text-gray-800 mb-6">Modifier un rôle</h1>

            <!-- Afficher les messages de succès -->
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg border border-green-300">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Formulaire de modification du rôle -->
            <div class="space-y-6">
                <h3 class="text-xl font-medium text-gray-700">Modifier le rôle : {{ $role->name }}</h3>

                <form action="{{ route('admin.roles.update', $role->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Nom du rôle -->
                    <div>
                        <label for="roleName" class="block text-sm font-medium text-gray-600">Nom du rôle</label>
                        <input type="text" name="name" id="roleName" value="{{ old('name', $role->name) }}" 
                            class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                            required>
                    </div>

                    <!-- Sélectionner des permissions -->
                    <div>
                        <label for="permissions" class="block text-sm font-medium text-gray-600">Sélectionner des permissions</label>
                        <select name="permissions[]" id="permissions" 
                            class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            multiple>
                            @foreach($permissions as $permission)
                                <option value="{{ $permission->id }}" 
                                    @if(in_array($permission->id, $rolePermissions)) selected @endif>
                                    {{ $permission->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="w-full px-6 py-3 bg-blue-600 text-white font-semibold rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Mettre à jour le rôle
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
