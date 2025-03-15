@extends('layouts.admin.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-2">
    <h1 class="text-3xl font-semibold text-gray-800 mb-6">Modifier un rôle</h1>

    <!-- Afficher les messages de succès -->
    @if(session('success'))
        <div class="alert alert-success mb-4 p-4 bg-green-100 text-green-800 rounded-lg border border-green-300">
            {{ session('success') }}
        </div>
    @endif

    <!-- Formulaire de modification du rôle -->
    <div class="mb-8">
        <h3 class="text-xl font-medium text-gray-700 mb-4">Modifier le rôle : {{ $role->name }}</h3>
        <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT') <!-- Méthode PUT pour la mise à jour -->

            <!-- Nom du rôle -->
            <div class="mb-4">
                <label for="roleName" class="block text-sm font-medium text-gray-600">Nom du rôle</label>
                <input type="text" name="name" id="roleName" value="{{ old('name', $role->name) }}" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            </div>

            <!-- Sélectionner des permissions -->
            <div class="mb-4">
                <label for="permissions" class="block text-sm font-medium text-gray-600">Sélectionner des permissions</label>
                <select name="permissions[]" id="permissions" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" multiple>
                    @foreach($permissions as $permission)
                        <option value="{{ $permission->id }}" 
                            @if(in_array($permission->id, $rolePermissions)) selected @endif>
                            {{ $permission->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Mettre à jour le rôle
            </button>
        </form>
    </div>
</div>
@endsection

