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
                <h1 class="ml-2 md:ml-0 text-xl font-bold text-gray-800">Gestion des Services</h1>
            </div>
            <div class="flex items-center gap-4">
                <div class="relative">
                    <button class="text-gray-500 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100 transition-colors">
                        <i class="fas fa-bell"></i>
                        <span class="absolute top-0 right-0 h-4 w-4 bg-red-500 rounded-full text-xs text-white flex items-center justify-center">3</span>
                    </button>
                </div>
                @if(auth()->user()->hasRole('admin'))
                <a href="{{ route('services.add-service') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-300 flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Ajouter Service
                </a>
                @endif
                <div class="relative">
                    <button type="button" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" id="user-menu-button">
                        <span class="sr-only">Ouvrir le menu utilisateur</span>
                        <button type="button" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" id="user-menu-button">
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
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Main content area -->
    <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50">
        <div class="max-w-7xl mx-auto">
            <!-- Messages de session -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Top stats -->
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3 mb-6">
                <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 p-3 rounded-lg bg-purple-100 text-purple-600">
                            <i class="fas fa-cogs text-lg"></i>
                        </div>
                        <div class="ml-5">
                            <h3 class="text-lg font-medium text-gray-900">Services Actifs</h3>
                            <div class="mt-1 flex items-baseline">
                                <p class="text-2xl font-semibold text-gray-900">{{ $services->total() }}</p>
                                <p class="ml-2 text-sm text-gray-600">services</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Services table -->
            <div class="bg-white shadow-md rounded-xl overflow-hidden border border-gray-100 mb-6">
                <div class="px-4 py-5 sm:px-6 flex justify-between items-center border-b border-gray-200">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Liste des Services</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Gérez vos services et leurs disponibilités</p>
                    </div>
                    <div class="flex">
                        <form method="GET" action="{{ route('admin.services.index') }}" class="flex items-center">
                            <!-- Recherche par nom -->
                            <div class="relative mr-2">
                                <input 
                                    type="text" 
                                    name="search" 
                                    id="search-input"
                                    class="border border-gray-300 rounded-md py-2 pl-10 pr-4 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                    placeholder="Rechercher..."
                                >
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                            </div>
                            
                            <!-- Filtre par catégorie -->
                            <div class="relative mr-2">
                                <select 
                                    name="category" 
                                    class="border border-gray-300 rounded-md py-2 pl-3 pr-8 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                >
                                    <option value="">Toutes catégories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-300 flex items-center">
                                <i class="fas fa-filter mr-2"></i>
                                Filtrer
                            </button>
                            
                            @if(request('search') || request('category'))
                                <a 
                                    href="{{ route('admin.services.index') }}" 
                                    class="ml-2 bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md text-sm font-medium transition duration-300 flex items-center"
                                >
                                    <i class="fas fa-times mr-2"></i>
                                    Réinitialiser
                                </a>
                            @endif
                        </form>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catégorie</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durée</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Réservations</th>
                                @if(auth()->user()->hasRole('admin'))
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="alldata bg-white divide-y divide-gray-200">
                            @forelse($services as $service)
                            <tr class="hover:bg-gray-50 transition duration-300">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-md bg-purple-100 flex items-center justify-center text-purple-600">
                                            @if($service->image)
                                                <img src="{{ asset('storage/'.$service->image) }}" class="h-full w-full object-cover rounded-md">
                                            @else
                                                <i class="fas fa-spa"></i>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $service->name }}</div>
                                            <div class="text-sm text-gray-500" title="{{ $service->description }}">
                                                {{ Str::limit($service->description, 50, '...') }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $service->category->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $service->duration }} min</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ number_format($service->price, 2) }}€</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $service->reservations_count ?? 0 }} ce mois
                                </td>
                                @if(auth()->user()->hasRole('admin'))
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('services.edit', $service->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('services.destroy', $service->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce service ?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Aucun service trouvé
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tbody id="Content" class ="searchdata bg-white divide-y divide-gray-200"></tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $services->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </main>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">

    $('#search-input').on('keyup', function()
    {
        $value = $(this).val();

        if($value)
        {
            $('.alldata').hide();
            $('.searchdata').show();
        }
        else{
            $('.alldata').show();
            $('.searchdata').hide(); 
        }

        $.ajax({
            type:'get',
            url:'/services/search',
            data:{'search':$value},

            success:function(data){
                console.log(data);
                $('#Content').html(data);
            }
        })
    })

</script>
@endsection