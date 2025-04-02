@extends('layouts.client.app')

@section('title', 'Tous les Services')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Barre de filtre en haut -->
    <div class="mb-6 flex items-center justify-between bg-white p-3 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-gray-900">Tous nos Services</h1>
        <form method="GET" action="{{ route('services') }}" class="flex items-center gap-3">
            <select name="category_id" onchange="this.form.submit()" 
                    class="rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500">
                <option value="">Toutes catégories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            
            @if(request('category_id'))
                <a href="{{ route('services') }}" 
                   class="text-pink-600 hover:text-pink-800 text-sm">
                    Réinitialiser
                </a>
            @endif
        </form>
    </div>

    <!-- Contenu principal : liste des services -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($services as $service)
        <div class="bg-gray-50 rounded-lg overflow-hidden shadow-md transition-transform duration-300 hover:shadow-lg hover:transform hover:-translate-y-1">
            <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="w-full h-48 object-cover">
            <div class="p-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $service->name }}</h3>
                <p class="text-gray-600 mb-4">{{ $service->description }}</p>
                <div class="flex justify-between items-center">
                    <div>
                        <span class="text-pink-600 font-bold">{{ $service->price }}$</span>
                        <span class="text-gray-500 text-sm ml-2">({{ $service->duration }} minutes)</span>
                    </div>
                    <button onclick="openReservationModal({{ $service->id }})" 
                            class="text-pink-600 hover:text-pink-800 font-medium">
                        Réserver →
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if ($services->hasPages())
        <div class="mt-8">
            {{ $services->links() }}
        </div>
    @endif
</div>

<!-- Modal de réservation -->
<div id="reservationModal" class="hidden fixed inset-0 backdrop-blur-sm bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Réserver ce service</h3>
            
            <form id="reservationForm" method="POST" action="{{ route('new_reservation') }}" class="mt-4">
                @csrf
                <input type="hidden" name="service_id" id="modal_service_id">
                
                <div class="mb-4">
                    <label for="datetime" class="block text-sm font-medium text-gray-700">Date et heure</label>
                    <input type="datetime-local" name="datetime" id="datetime" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500"
                           min="{{ now()->format('Y-m-d\TH:i') }}"
                           required>
                </div>
                
                <div class="mb-4">
                    <label for="employee_id" class="block text-sm font-medium text-gray-700">Employé</label>
                    <select name="employee_id" id="employee_id" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500" required>
                        <option value="">Sélectionnez un employé</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="flex justify-end gap-3 mt-4">
                    <button type="button" onclick="closeModal()"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                        Annuler
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-pink-600 text-white rounded-md hover:bg-pink-700">
                        Confirmer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
    function openReservationModal(serviceId) {
        document.getElementById('modal_service_id').value = serviceId;
        document.getElementById('reservationModal').classList.remove('hidden');
        
        document.querySelector('#reservationModal form').reset();
    }

    function closeModal() {
        document.getElementById('reservationModal').classList.add('hidden');
    }

    window.onclick = function(event) {
        if (event.target == document.getElementById('reservationModal')) {
            closeModal();
        }
    }
</script>
@endsection
@endsection