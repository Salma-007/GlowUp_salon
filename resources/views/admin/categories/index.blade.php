@extends('layouts.admin.app')

@section('content')
<div class="flex-1 flex flex-col overflow-hidden">
    <!-- Header -->
    <header class="bg-white shadow-md sticky top-0 z-10">
        <div class="px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">
            <h1 class="text-xl font-bold text-gray-800">Gestion des Catégories</h1>
            <button onclick="openAddCategoryModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-300 flex items-center">
                <i class="fas fa-plus mr-2"></i>
                Ajouter une Catégorie
            </button>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50">
        <div class="max-w-7xl mx-auto">
            <!-- Liste des Catégories -->
            <div class="bg-white shadow-md rounded-xl overflow-hidden border border-gray-100">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Liste des Catégories</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Gérez les catégories de services</p>
                    @if (session('success'))
                        <div class="alert alert-success bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-error bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($categories as $category)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $category->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button onclick="openEditCategoryModal({{ $category->id }}, '{{ $category->name }}')" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="confirmDeleteCategory({{ $category->id }})" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Modal pour Ajouter une Catégorie -->
<div id="addCategoryModal" class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm">
    <div class="bg-white rounded-lg shadow-xl w-11/12 md:w-1/2 lg:w-1/3 p-6">
        <div class="text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Ajouter une Catégorie</h3>
            <form action="{{ route('admin.categories.store') }}" method="POST" class="mt-4">
                @csrf
                <input type="text" name="name" placeholder="Nom de la catégorie" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                <div class="mt-6 flex justify-end">
                    <button type="button" onclick="closeAddCategoryModal()" class="mr-2 px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Annuler</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal pour Modifier une Catégorie -->
<div id="editCategoryModal" class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm">
    <div class="bg-white rounded-lg shadow-xl w-11/12 md:w-1/2 lg:w-1/3 p-6">
        <div class="text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Modifier la Catégorie</h3>
            <form id="editCategoryForm" method="POST" class="mt-4">
                @csrf
                @method('PUT')
                <input type="hidden" id="editCategoryId" name="id">
                <input type="text" id="editCategoryName" name="name" placeholder="Nom de la catégorie" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                <div class="mt-6 flex justify-end">
                    <button type="button" onclick="closeEditCategoryModal()" class="mr-2 px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Annuler</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts JavaScript -->
<script>
    // Ouvrir le modal d'ajout
    function openAddCategoryModal() {
        document.getElementById('addCategoryModal').classList.remove('hidden');
    }

    // Fermer le modal d'ajout
    function closeAddCategoryModal() {
        document.getElementById('addCategoryModal').classList.add('hidden');
    }

    // Ouvrir le modal de modification
    function openEditCategoryModal(id, name) {
        document.getElementById('editCategoryId').value = id;
        document.getElementById('editCategoryName').value = name;
        document.getElementById('editCategoryForm').action = `/admin/categories/${id}`;
        document.getElementById('editCategoryModal').classList.remove('hidden');
    }

    // Fermer le modal de modification
    function closeEditCategoryModal() {
        document.getElementById('editCategoryModal').classList.add('hidden');
    }

    // Confirmer la suppression
    function confirmDeleteCategory(id) {
        if (confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')) {

            fetch(`/admin/categories/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(response => {
                if (response.ok) {
                    window.location.reload();
                }
            });
        }
    }
</script>
@endsection