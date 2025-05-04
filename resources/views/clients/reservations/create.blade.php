@extends('layouts.client.app')

@section('title', 'Réserver un service')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Réserver un service</h1>
        
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form id="reservationForm" action="{{ route('new_reservation') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
            @csrf
            <div class="mb-4">
                <label for="service_id" class="block text-gray-700 font-medium mb-2">Service</label>
                <select name="service_id" id="service_id" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600">
                    <option value="">Sélectionnez un service</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}">{{ $service->name }} - {{ $service->price }}€</option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-4">
                <label for="datetime" class="block text-gray-700 font-medium mb-2">Date et heure</label>
                <input type="datetime-local" name="datetime" id="datetime" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600" required>
            </div>
            
            <div class="mb-4">
                <label for="employee_id" class="block text-gray-700 font-medium mb-2">Employé</label>
                <select name="employee_id" id="employee_id" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600" disabled>
                    <option value="">Sélectionnez d'abord un service</option>
                </select>
                <div id="employee_loading" class="hidden text-gray-500 mt-2">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-pink-600 inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Chargement des employés...
                </div>
                <div id="employee_error" class="hidden text-red-500 mt-2"></div>
            </div>
            
            <div class="flex justify-end">
                <button type="submit" id="submit_btn" class="bg-pink-600 hover:bg-pink-700 text-white font-medium px-6 py-2 rounded-lg transition duration-300 disabled:opacity-50" disabled>
                    Réserver
                </button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const serviceSelect = document.getElementById('service_id');
    const employeeSelect = document.getElementById('employee_id');
    const loadingIndicator = document.getElementById('employee_loading');
    const errorDisplay = document.getElementById('employee_error');
    const submitBtn = document.getElementById('submit_btn');
    const reservationForm = document.getElementById('reservationForm');
    let employeesLoaded = false;

    
    function loadEmployees(serviceId) {
        employeeSelect.innerHTML = '<option value="">Chargement...</option>';
        employeeSelect.disabled = true;
        loadingIndicator.classList.remove('hidden');
        errorDisplay.classList.add('hidden');
        errorDisplay.textContent = '';
        submitBtn.disabled = true;
        employeesLoaded = false;


        fetch(`/services/${serviceId}/employees`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur lors du chargement des employés');
                }
                return response.json();
            })
            .then(employees => {
                employeeSelect.innerHTML = '';
                
                if (employees.length > 0) {
                    employees.forEach(employee => {
                        const option = document.createElement('option');
                        option.value = employee.id;
                        option.textContent = employee.name;
                        employeeSelect.appendChild(option);
                    });
                    employeeSelect.disabled = false;
                    employeesLoaded = true;
                    updateSubmitButton();
                } else {
                    employeeSelect.innerHTML = '<option value="">Aucun employé disponible pour ce service</option>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                employeeSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                errorDisplay.textContent = error.message;
                errorDisplay.classList.remove('hidden');
            })
            .finally(() => {
                loadingIndicator.classList.add('hidden');
            });
    }

    function updateSubmitButton() {
        const serviceSelected = serviceSelect.value && serviceSelect.value !== '';
        const employeeSelected = employeeSelect.value && employeeSelect.value !== '';
        submitBtn.disabled = !(serviceSelected && employeeSelected && employeesLoaded);
    }

    reservationForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            En cours...
        `;

        fetch(reservationForm.action, {
            method: 'POST',
            body: new FormData(reservationForm),
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => {
                    throw new Error(err.message || 'Erreur lors de la réservation');
                });
            }
            return response.json();
        })
        .then(data => {
            Swal.fire({
                icon: 'success',
                title: 'Réservation confirmée!',
                text: 'Votre réservation a été enregistrée avec succès.',
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK'
            }).then(() => {
                reservationForm.reset();
                employeeSelect.innerHTML = '<option value="">Sélectionnez un service</option>';
                employeeSelect.disabled = true;
                serviceSelect.value = '';
                updateSubmitButton();
            });
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: error.message,
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK'
            });
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Réserver';
        });
    });

    serviceSelect.addEventListener('change', function() {
        if (this.value) {
            loadEmployees(this.value);
        } else {
            employeeSelect.innerHTML = '<option value="">Sélectionnez un service</option>';
            employeeSelect.disabled = true;
            employeesLoaded = false;
            updateSubmitButton();
        }
    });

    employeeSelect.addEventListener('change', updateSubmitButton);

    updateSubmitButton();
});
</script>
@endsection