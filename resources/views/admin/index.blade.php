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
                <h1 class="ml-2 md:ml-0 text-xl font-bold text-gray-800">Tableau de bord</h1>
            </div>
            <div class="flex items-center gap-4">
                <div class="relative">
                    <button class="text-gray-500 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100 transition-colors">
                        <i class="fas fa-bell"></i>
                        <span class="absolute top-0 right-0 h-4 w-4 bg-red-500 rounded-full text-xs text-white flex items-center justify-center">3</span>
                    </button>
                </div>
                <a href="{{ route('services.add-service') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-300 flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Ajouter Service
                </a>
                <div class="relative">
                    <button type="button" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" id="user-menu-button">
                        <span class="sr-only">Ouvrir le menu utilisateur</span>
                            <div class="flex items-center">
                            @auth
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
                            @else
                                <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-user text-gray-500"></i>
                                </div>
                                <span class="hidden md:block ml-2 text-gray-700">Invité</span>
                            @endauth
                            </div>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50">
        <div class="max-w-7xl mx-auto">

            <div class="bg-white rounded-xl shadow-md p-6 mb-8 border border-gray-100">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Bonjour, {{ Auth::user()->name }}</h2>
                        <p class="text-gray-600 mt-1">{{ now()->format('l, d F Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

                <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 transition-all duration-300 hover:shadow-lg hover:border-blue-100">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 flex items-center justify-center w-12 h-12 rounded-lg bg-blue-100 text-blue-600">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="ml-5">
                            <p class="text-sm font-medium text-gray-500">Total Clients</p>
                            <div class="flex items-end">
                                <h3 class="text-2xl font-bold text-gray-900">{{ $totalClients }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-100">
                        <a href="/admin/clients" class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center justify-between">
                            Voir tous les clients
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 transition-all duration-300 hover:shadow-lg hover:border-blue-100">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 flex items-center justify-center w-12 h-12 rounded-lg bg-emerald-100 text-emerald-600">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="ml-5">
                            <p class="text-sm font-medium text-gray-500">Total Employés</p>
                            <div class="flex items-end">
                                <h3 class="text-2xl font-bold text-gray-900">{{ $totalEmployees }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-100">
                        <a href="/admin/employees" class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center justify-between">
                            Voir tous les employés
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 transition-all duration-300 hover:shadow-lg hover:border-blue-100">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 flex items-center justify-center w-12 h-12 rounded-lg bg-purple-100 text-purple-600">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <div class="ml-5">
                            <p class="text-sm font-medium text-gray-500">Total Services</p>
                            <div class="flex items-end">
                                <h3 class="text-2xl font-bold text-gray-900">{{ $totalServices }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-100">
                        <a href="/admin/services" class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center justify-between">
                            Voir tous les services
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 transition-all duration-300 hover:shadow-lg hover:border-blue-100">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 flex items-center justify-center w-12 h-12 rounded-lg bg-amber-100 text-amber-600">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="ml-5">
                            <p class="text-sm font-medium text-gray-500">Réservations Aujourd'hui</p>
                            <div class="flex items-end">
                                <h3 class="text-2xl font-bold text-gray-900">{{ $todayReservations }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-100">
                        <a href="/admin/reservations" class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center justify-between">
                            Voir toutes les réservations
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">

                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">Activité Récente</h3>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @forelse($activities as $activity)
                            <div class="px-6 py-4 flex items-start">
                                <div class="flex-shrink-0 bg-{{ $activity['color'] }}-100 rounded-md p-2 text-{{ $activity['color'] }}-600">
                                    <i class="fas {{ $activity['icon'] }}"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">{{ $activity['title'] }}</p>
                                    <p class="text-sm text-gray-500">{{ $activity['description'] }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ $activity['time']->diffForHumans() }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="px-6 py-4 text-center text-gray-500">
                                Aucune activité récente
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Today's Bookings -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900">Réservations Aujourd'hui</h3>
                    <a href="/admin/reservations" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Voir tout</a>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($todayBookings as $booking)
                    <div class="px-6 py-4 flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-semibold">
                            @if($booking->service->image)
                                <img src="{{ asset('storage/'.$booking->service->image) }}" class="h-full w-full object-cover rounded-md" alt="{{ $booking->service->name }}">
                            @else
                                <i class="fas fa-spa"></i>
                            @endif
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">
                                    {{ $booking->user->name }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ $booking->service->name }} • 
                                    {{ \Carbon\Carbon::parse($booking->datetime)->format('H:i') }} - 
                                    {{ \Carbon\Carbon::parse($booking->datetime)->addMinutes($booking->service->duration ?? 0)->format('H:i') }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <span class="px-2 py-1 text-xs rounded-full 
                                {{ $booking->status === 'Done' ? 'bg-green-100 text-green-800' : 
                                ($booking->status === 'Pending' ? 'bg-amber-100 text-amber-800' : 
                                ($booking->status === 'Refused' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800')) }}">
                                {{ $booking->status === 'Done' ? 'Confirmé' : 
                                ($booking->status === 'Pending' ? 'En attente' : 
                                ($booking->status === 'Refused' ? 'Refusé' : $booking->status)) }}
                            </span>
                            <div class="relative ml-2">
                                <button class="text-gray-500 hover:text-gray-700" id="booking-menu-{{ $booking->id }}">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <!-- Dropdown menu could be added here -->
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="px-6 py-4 text-center text-gray-500">
                        Aucune réservation aujourd'hui
                    </div>
                    @endforelse
                </div>
            </div>
            </div>

            <!-- Bottom Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Clients Management -->
                <div class="lg:col-span-2">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Clients Récents</h3>
                        <a href="/admin/clients" class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center">
                            Voir tous les clients
                            <i class="fas fa-chevron-right ml-1 text-xs"></i>
                        </a>
                    </div>
                    <div class="bg-white shadow-md rounded-xl overflow-hidden border border-gray-100">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Réservations</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($recentClients as $client)
                                    <tr class="hover:bg-gray-50 transition duration-300">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8">
                                                    @if($client->photo)
                                                        <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/' . $client->photo) }}" alt="{{ $client->name }}">
                                                    @else
                                                        <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                                                            <span class="text-xs font-medium text-gray-500">{{ substr($client->name, 0, 2) }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $client->name }} 
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        Client depuis {{ $client->created_at->format('M Y') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $client->email }}</div>
                                            <div class="text-sm text-gray-500">{{ $client->phone ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $client->reservations_count }} réservation(s)
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                @if($client->reservations_count > 0 && isset($client->reservations) && $client->reservations->isNotEmpty())
                                                    Dernière: {{ \Carbon\Carbon::parse($client->reservations->first()->datetime)->format('d/m/Y') }}
                                                @else
                                                    Aucune réservation
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Actif
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('admin.clients.edit', $client->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('client.destroy', $client->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce client?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                            Aucun client récent à afficher
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Popular Services Chart -->
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Services Populaires</h3>
                        <a href="/admin/services" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Détails</a>
                    </div>
                    <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                        @forelse($popularServices as $index => $service)
                            <div class="mb-4 last:mb-0">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">{{ $service->name }}</span>
                                    <span class="text-sm text-gray-500">{{ $service->reservations_count }} réservations</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="{{ $colors[$index % count($colors)] }} h-2 rounded-full" 
                                        style="width: {{ ($service->reservations_count / $maxReservations) * 100 }}%"></div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-gray-500 py-4">
                                Aucune donnée disponible
                            </div>
                        @endforelse
                        
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <div class="flex justify-between text-sm">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

@endsection