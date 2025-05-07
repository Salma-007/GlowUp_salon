@extends('layouts.admin.app')

@section('content')
<div class="flex-1 flex flex-col overflow-hidden">

    <header class="bg-white shadow-md sticky top-0 z-10">
        <div class="px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">
            <h1 class="text-xl font-bold text-gray-800">Gestion des Catégories</h1>

            <div class="flex items-center gap-4 ml-auto">

                @if(auth()->user()->hasRole('admin'))
                <button onclick="openAddCategoryModal()" 
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-300 flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Ajouter une Catégorie
                </button>
                @endif

                <div class="relative">
                    <button type="button" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <span class="sr-only">Ouvrir le menu utilisateur</span>
                        <div class="flex items-center">
                            @if(Auth::user()->photo)
                                <img class="h-8 w-8 rounded-full object-cover" 
                                    src="{{ asset('storage/' . Auth::user()->photo) }}" 
                                    alt="Photo de profil de {{ Auth::user()->name }}">
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

    <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50">
        <div class="max-w-7xl mx-auto space-y-6">

            @if (session('success'))
            <div class="p-4 bg-green-50 border-l-4 border-green-500 rounded-lg">
                <div class="flex items-center">
                    <div class="flex-shrink-0 text-green-500">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
            @endif

            @if (session('error'))
            <div class="p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
                <div class="flex items-center">
                    <div class="flex-shrink-0 text-red-500">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
            @endif

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-indigo-100 rounded-md p-3">
                                <i class="fas fa-tags text-indigo-600 text-xl"></i>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-lg font-medium text-gray-500">Total Catégories</h3>
                                <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $totalCategories }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Liste des Catégories</h3>
                            <p class="mt-1 text-sm text-gray-500">Toutes les catégories disponibles dans votre système</p>
                        </div>
                    </div>
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
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-md bg-indigo-100 text-indigo-600 flex items-center justify-center">
                                            <i class="fas fa-tag"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $category->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $category->services_count }} services</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                    <button onclick="openEditCategoryModal({{ $category->id }}, '{{ $category->name }}')" 
                                        class="text-indigo-600 hover:text-indigo-900 p-2 rounded-full hover:bg-indigo-50 transition-colors"
                                        title="Modifier">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    <button onclick="confirmDeleteCategory({{ $category->id }})" 
                                        class="text-red-600 hover:text-red-900 p-2 rounded-full hover:bg-red-50 transition-colors"
                                        title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </main>
</div>

<div id="addCategoryModal" class="hidden fixed inset-0 z-50 overflow-y-auto backdrop-blur-sm">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-plus text-blue-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Ajouter une Catégorie</h3>
                        <div class="mt-4">
                            <form id="addCategoryForm" action="{{ route('admin.categories.store') }}" method="POST">
                                @csrf
                                <input type="text" name="name" placeholder="Nom de la catégorie" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <div id="addCategoryError" class="mt-2 text-sm text-red-600 hidden"></div>
                                <div class="mt-6 flex justify-end space-x-3">
                                    <button type="button" onclick="closeAddCategoryModal()" 
                                        class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Annuler
                                    </button>
                                    <button type="submit" 
                                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Créer
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="editCategoryModal" class="hidden fixed inset-0 z-50 overflow-y-auto backdrop-blur-sm">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-edit text-blue-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Modifier la Catégorie</h3>
                        <div class="mt-4">
                            <form id="editCategoryForm" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" id="editCategoryId" name="id">
                                <input type="text" id="editCategoryName" name="name" placeholder="Nom de la catégorie" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <div id="editCategoryError" class="mt-2 text-sm text-red-600 hidden"></div>
                                <div class="mt-6 flex justify-end space-x-3">
                                    <button type="button" onclick="closeEditCategoryModal()" 
                                        class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Annuler
                                    </button>
                                    <button type="submit" 
                                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Enregistrer
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function openAddCategoryModal() {
        document.getElementById('addCategoryModal').classList.remove('hidden');

        document.getElementById('addCategoryError').classList.add('hidden');
        document.getElementById('addCategoryError').textContent = '';
    }

    function closeAddCategoryModal() {
        document.getElementById('addCategoryModal').classList.add('hidden');
    }

    function openEditCategoryModal(id, name) {
        document.getElementById('editCategoryId').value = id;
        document.getElementById('editCategoryName').value = name;
        document.getElementById('editCategoryForm').action = `/admin/categories/${id}`;
        document.getElementById('editCategoryModal').classList.remove('hidden');

        document.getElementById('editCategoryError').classList.add('hidden');
        document.getElementById('editCategoryError').textContent = '';
    }

    function closeEditCategoryModal() {
        document.getElementById('editCategoryModal').classList.add('hidden');
    }

    function confirmDeleteCategory(id) {
        Swal.fire({
            title: 'Êtes-vous sûr?',
            text: "Vous ne pourrez pas annuler cette action!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, supprimer!',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/admin/categories/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                }).then(response => {
                    if (response.ok) {
                        Swal.fire(
                            'Supprimé!',
                            'La catégorie a été supprimée.',
                            'success'
                        ).then(() => window.location.reload());
                    }
                });
            }
        });
    }

    document.getElementById('addCategoryForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);
        const errorElement = document.getElementById('addCategoryError');

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json'
                }
            });
            
            if (response.ok) {
                window.location.reload();
            } else {
                const data = await response.json();
                if (data.errors) {
                    errorElement.textContent = data.errors.name ? data.errors.name[0] : 'Une erreur est survenue';
                    errorElement.classList.remove('hidden');
                }
            }
        } catch (error) {
            errorElement.textContent = 'Une erreur réseau est survenue';
            errorElement.classList.remove('hidden');
            console.error('Error:', error);
        }
    });

    document.getElementById('editCategoryForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);
        const errorElement = document.getElementById('editCategoryError');

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json'
                }
            });
            
            if (response.ok) {
                window.location.reload();
            } else {
                const data = await response.json();
                if (data.errors) {
                    errorElement.textContent = data.errors.name ? data.errors.name[0] : 'Une erreur est survenue';
                    errorElement.classList.remove('hidden');
                }
            }
        } catch (error) {
            errorElement.textContent = 'Une erreur réseau est survenue';
            errorElement.classList.remove('hidden');
            console.error('Error:', error);
        }
    });
</script>
@endsection