@extends('layouts.client.app')

@section('title', 'Réserver un service')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

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
                    <button onclick="openReservationModal({{ $service->id }}, '{{ addslashes($service->name) }}', {{ json_encode($service->employees) }})" 
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
<div id="reservationModal" class="hidden fixed inset-0 bg-opacity-50 backdrop-blur-sm overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal_service_name"></h3>
            
            <!-- Conteneur d'erreur -->
            <div id="modalError" class="hidden bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-4 rounded">
                <p id="modalErrorMessage"></p>
            </div>

            <form method="POST" action="{{ route('new_reservation') }}" class="mt-4">
                @csrf
                <input type="hidden" name="service_id" id="modal_service_id" value="{{ old('service_id') }}">
                
                <div class="mb-4 text-left">
                    <label for="datetime" class="block text-sm font-medium text-gray-700 mb-1">Date et heure</label>
                    <input type="datetime-local" name="datetime" id="datetime" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500 @error('datetime') border-red-500 @enderror"
                           min="{{ now()->format('Y-m-d\TH:i') }}"
                           value="{{ old('datetime') }}"
                           required>
                    @error('datetime')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4 text-left">
                    <label for="employee_id" class="block text-sm font-medium text-gray-700 mb-1">Employé</label>
                    <select name="employee_id" id="employee_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500 @error('employee_id') border-red-500 @enderror" required>
                        <!-- Options will be filled by JavaScript -->
                    </select>
                    @error('employee_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeModal()"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition-colors">
                        Annuler
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-pink-600 text-white rounded-md hover:bg-pink-700 transition-colors">
                        Confirmer la réservation
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>

    function openReservationModal(serviceId, serviceName, employees) {
        const modal = document.getElementById('reservationModal');
        
        document.getElementById('modal_service_id').value = serviceId;
        document.getElementById('modal_service_name').textContent = `Réserver: ${serviceName}`;
        

        const employeeSelect = document.getElementById('employee_id');
        employeeSelect.innerHTML = '';
        
        if (employees && employees.length > 0) {

            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = 'Sélectionnez un employé';
            defaultOption.selected = true;
            employeeSelect.appendChild(defaultOption);
            
            employees.forEach(employee => {
                const option = document.createElement('option');
                option.value = employee.id;
                option.textContent = employee.name;
                
                if (employee.id == '{{ old('employee_id') }}') {
                    option.selected = true;
                }
                
                employeeSelect.appendChild(option);
            });
        } else {
            const option = document.createElement('option');
            option.value = '';
            option.textContent = 'Aucun employé disponible';
            option.disabled = true;
            employeeSelect.appendChild(option);
        }
        

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        @if(session('error'))
            showModalError('{{ session('error') }}');
        @endif
    }


    function showModalError(message) {
        const errorDiv = document.getElementById('modalError');
        const errorMessage = document.getElementById('modalErrorMessage');
        
        errorDiv.classList.remove('hidden');
        errorMessage.textContent = message;
        

        setTimeout(() => {
            errorDiv.classList.add('hidden');
        }, 8000);
    }

    function closeModal() {
        document.getElementById('reservationModal').classList.add('hidden');
        document.body.style.overflow = 'auto';

        document.getElementById('modalError').classList.add('hidden');
    }

    window.addEventListener('click', function(event) {
        if (event.target === document.getElementById('reservationModal')) {
            closeModal();
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        @if($errors->any() || session('error'))
            const serviceId = {{ old('service_id', session('service_id')) ?? 'null' }};
            if (serviceId) {
                const servicesData = {!! $services->getCollection()->toJson() !!};
                const service = servicesData.find(s => s.id == serviceId);
                if (service) {
                    openReservationModal(
                        serviceId, 
                        service.name, 
                        service.employees
                    );
                    
                    document.getElementById('datetime').value = '{{ old('datetime') }}';
                }
            }
        @endif
    });
</script>
@endsection