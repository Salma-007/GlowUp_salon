@extends('layouts.admin.app')

@section('content')
<div class="bg-white shadow-lg rounded-lg p-6 max-w-2xl mx-auto">
    <h2 class="text-xl font-semibold text-gray-900 mb-6">Ajouter un nouveau service</h2>
    <form>
        <!-- Nom du service -->
        <div class="mb-6">
            <label for="service-name" class="block text-sm font-medium text-gray-700 mb-2">Nom du service</label>
            <input type="text" id="service-name" name="service-name" placeholder="Entrez le nom du service" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-300">
        </div>

        <!-- Description du service -->
        <div class="mb-6">
            <label for="service-description" class="block text-sm font-medium text-gray-700 mb-2">Description du service</label>
            <textarea id="service-description" name="service-description" rows="4" placeholder="Entrez la description du service" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-300"></textarea>
        </div>

        <!-- Catégorie du service -->
        <div class="mb-6">
            <label for="service-category" class="block text-sm font-medium text-gray-700 mb-2">Catégorie</label>
            <select id="service-category" name="service-category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-300">
                <option value="" disabled selected>Sélectionnez une catégorie</option>
                <option value="beaute">Beauté</option>
                <option value="sante">Santé</option>
                <option value="bien-etre">Bien-être</option>
                <option value="autre">Autre</option>
            </select>
        </div>

        <!-- Prix du service -->
        <div class="mb-6">
            <label for="service-price" class="block text-sm font-medium text-gray-700 mb-2">Prix (€)</label>
            <input type="number" id="service-price" name="service-price" placeholder="Entrez le prix du service" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-300">
        </div>

        <!-- Durée du service -->
        <div class="mb-6">
            <label for="service-duration" class="block text-sm font-medium text-gray-700 mb-2">Durée (minutes)</label>
            <input type="number" id="service-duration" name="service-duration" placeholder="Entrez la durée du service" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-300">
        </div>

        <!-- Boutons d'action -->
        <div class="flex justify-end space-x-4">
            <button type="button" class="px-6 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 focus:ring-2 focus:ring-gray-500 transition duration-300">
                Annuler
            </button>
            <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 transition duration-300">
                Ajouter le service
            </button>
        </div>
    </form>
</div>

@endsection