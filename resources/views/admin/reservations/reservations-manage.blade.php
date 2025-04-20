@extends('layouts.admin.app')

@section('content')
<!-- Main content -->
<div class="flex-1 flex flex-col overflow-hidden">
    <header class="bg-white shadow-md sticky top-0 z-10">
        <div class="px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">
            <div class="flex items-center">
                <button type="button" class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                    <span class="sr-only">Ouvrir le menu sidebar</span>
                    <i class="fas fa-bars h-5 w-5"></i>
                </button>
                <h1 class="ml-2 md:ml-0 text-xl font-bold text-gray-800">Calendrier des Réservations</h1>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="relative">
                    <button class="text-gray-500 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100 transition-colors">
                        <i class="fas fa-bell"></i>
                        <span class="absolute top-0 right-0 h-4 w-4 bg-red-500 rounded-full text-xs text-white flex items-center justify-center">3</span>
                    </button>
                </div>
                <div class="relative">
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
                </div>
            </div>
        </div>
    </header>

    <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50">
        <div class="max-w-7xl mx-auto">
            <!-- Calendar -->
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200 flex justify-between items-center">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Calendrier des Réservations</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        Visualisez et gérez les réservations (Total: {{ $reservations->total() }})
                    </p>
                </div>
                <button onclick="openCreateModal()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-plus mr-2"></i> Nouvelle Réservation
                </button>
            </div>
                <div class="p-6">
                    <div id="calendar"></div>
                </div>
            </div>

            <div class="mt-8 bg-white shadow-md rounded-xl overflow-hidden border border-gray-100">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Liste des Réservations</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Affichage de {{ $reservations->firstItem() }} à {{ $reservations->lastItem() }} sur {{ $reservations->total() }} réservations
                    </p>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employé</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date/Heure</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($reservations as $reservation)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if($reservation->client->photo)
                                            <img class="h-10 w-10 rounded-full" src="{{ asset('storage/' .$reservation->client->photo) }}" alt="Photo de profil de {{ $reservation->client->name }}">
                                            @else
                                            <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                                                <i class="fas fa-user text-gray-500"></i>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $reservation->client->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $reservation->client->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $reservation->service->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $reservation->service->duration }} min</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $reservation->employee->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($reservation->datetime)->format('d/m/Y H:i') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @switch($reservation->status)
                                        @case('Pending')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">En attente</span>
                                            @break
                                        @case('Done')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Terminée</span>
                                            @break
                                        @case('Refused')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Annulé</span>
                                            @break
                                        @default
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">{{ $reservation->status }}</span>
                                    @endswitch
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button onclick="openReservationModal(
                                        '{{ $reservation->service->name }}',
                                        '{{ $reservation->client->name }}',
                                        '{{ $reservation->employee->name }}',
                                        '{{ $reservation->status }}',
                                        '{{ \Carbon\Carbon::parse($reservation->datetime)->format('d/m/Y') }}',
                                        '{{ \Carbon\Carbon::parse($reservation->datetime)->format('H:i') }}',
                                        '{{ $reservation->id }}'
                                    )" class="text-blue-600 hover:text-blue-900 mr-3">
                                        Voir
                                    </button>
                                    
                                    @if($reservation->status !== 'Done' && $reservation->status !== 'Refused')
                                        <button onclick="openEditModal(
                                            {{ $reservation->id }}, 
                                            '{{ $reservation->datetime }}', 
                                            {{ $reservation->employee_id }}, 
                                            {{ $reservation->service_id }}
                                        )" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                            Modifier
                                        </button>
                                        <form action="" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Êtes-vous sûr de vouloir annuler cette réservation?')">Annuler</button>
                                        </form>
                                    @else
                                        <span class="text-gray-400">Aucune action disponible</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">Aucune réservation trouvée.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="px-4 py-3 bg-gray-50 border-t border-gray-200 sm:px-6">
                    <div class="flex items-center justify-between">
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    Affichage de <span class="font-medium">{{ $reservations->firstItem() }}</span>
                                    à <span class="font-medium">{{ $reservations->lastItem() }}</span>
                                    sur <span class="font-medium">{{ $reservations->total() }}</span> résultats
                                </p>
                            </div>
                            <div>
                                {{ $reservations->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Create Reservation Modal -->
<div id="createReservationModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-opacity-50 backdrop-blur-sm" aria-hidden="true"></div>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Créer une nouvelle réservation</h3>
                <div id="createModalError" class="hidden bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-4 rounded">
                    <p id="createModalErrorMessage"></p>
                </div>
                <form id="createReservationForm" method="POST" action="{{ route('admin.reservations.store') }}">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label for="client_id" class="block text-sm font-medium text-gray-700">Client</label>
                            <select name="client_id" id="client_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">Sélectionner un client</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }} ({{ $client->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label for="service_id" class="block text-sm font-medium text-gray-700">Service</label>
                            <select name="service_id" id="service_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">Sélectionner un service</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}" data-duration="{{ $service->duration }}">{{ $service->name }} ({{ $service->duration }} min)</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label for="employee_id" class="block text-sm font-medium text-gray-700">Employé</label>
                            <select name="employee_id" id="employee_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">Sélectionner un employé</option>
                                <!-- Rempli dynamiquement via JavaScript -->
                            </select>
                        </div>
                        
                        <div>
                            <label for="create_datetime" class="block text-sm font-medium text-gray-700">Date et heure</label>
                            <input type="datetime-local" name="datetime" id="create_datetime" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Statut</label>
                            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="Pending">En attente</option>
                                <option value="Done">Confirmé</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mt-6 flex justify-end">
                        <button type="button" onclick="closeCreateModal()" class="mr-2 inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Annuler
                        </button>
                        <button type="submit" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Créer la réservation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Reservation Details Modal -->
<div id="reservationModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-opacity-50 backdrop-blur-sm" aria-hidden="true"></div>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg font-medium text-gray-900">Détails de la réservation</h3>
                        <div class="mt-4 grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Service</p>
                                <p id="modalService" class="mt-1 text-sm text-gray-900"></p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Client</p>
                                <p id="modalClient" class="mt-1 text-sm text-gray-900"></p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Employé</p>
                                <p id="modalEmployee" class="mt-1 text-sm text-gray-900"></p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Statut</p>
                                <p id="modalStatus" class="mt-1 text-sm"></p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Date</p>
                                <p id="modalDate" class="mt-1 text-sm text-gray-900"></p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Heure</p>
                                <p id="modalTime" class="mt-1 text-sm text-gray-900"></p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="closeReservationModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Fermer
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Reservation Modal -->
<div id="editReservationModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-opacity-50 backdrop-blur-sm" aria-hidden="true"></div>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Modifier la réservation</h3>
                <div id="editModalError" class="hidden bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-4 rounded">
                    <p id="editModalErrorMessage"></p>
                </div>
                <form id="editReservationForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="reservation_id" id="reservation_id">
                    <input type="hidden" name="service_id" id="edit_service_id">
                    
                    <div class="mt-4">
                        <label for="edit_status" class="block text-sm font-medium text-gray-700">Statut</label>
                        <select name="status" id="edit_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="Pending">En attente</option>
                            <option value="Done">Confirmé</option>
                            <option value="Refused">Annulé</option>
                        </select>
                    </div>
                    
                    <div class="mt-4">
                        <label for="edit_datetime" class="block text-sm font-medium text-gray-700">Date et heure</label>
                        <input type="datetime-local" name="datetime" id="edit_datetime" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>
                    
                    <div class="mt-4">
                        <label for="edit_employee_id" class="block text-sm font-medium text-gray-700">Employé</label>
                        <select name="employee_id" id="edit_employee_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <!-- Options chargées dynamiquement -->
                        </select>
                    </div>
                    

                    
                    <div class="mt-6 flex justify-end">
                        <button type="button" onclick="closeEditModal()" class="mr-2 inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Annuler
                        </button>
                        <button type="submit" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/locales/fr.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function openReservationModal(service, client, employee, status, date, time, reservationId) {
    document.getElementById('modalService').textContent = service;
    document.getElementById('modalClient').textContent = client;
    document.getElementById('modalEmployee').textContent = employee;
    
    const statusElement = document.getElementById('modalStatus');
    statusElement.textContent = status;
    statusElement.className = 'mt-1 text-sm px-2 py-1 rounded-full text-xs font-medium';
    
    const actionsDiv = document.querySelector('.bg-gray-50.px-4.py-3.sm\\:px-6');
    
    const oldEditButton = document.getElementById('modalEditButton');
    if (oldEditButton) {
        oldEditButton.remove();
    }
    
    if (status !== 'Done' && status !== 'Refused') {
        const editButton = document.createElement('button');
    editButton.id = 'modalEditButton';
    editButton.onclick = function() {
        const [day, month, year] = date.split('/');
        const formattedDate = `${year}-${month}-${day} ${time}:00`;
        
        openEditModal(
            reservationId,
            formattedDate,  
            null,           
            null            
        );
        closeReservationModal();
    };
    editButton.className = 'w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm';
    editButton.textContent = 'Modifier';

    const closeButton = document.querySelector('button[onclick="closeReservationModal()"]');
    closeButton.insertAdjacentElement('beforebegin', editButton);
    }
    
    switch(status) {
        case 'Done':
            statusElement.classList.add('bg-green-100', 'text-green-800');
            break;
        case 'Pending':
            statusElement.classList.add('bg-yellow-100', 'text-yellow-800');
            break;
        case 'Refused':
            statusElement.classList.add('bg-red-100', 'text-red-800');
            break;
        default:
            statusElement.classList.add('bg-gray-100', 'text-gray-800');
    }
    
    document.getElementById('modalDate').textContent = date;
    document.getElementById('modalTime').textContent = time;

    
    document.getElementById('reservationModal').classList.remove('hidden');
}

function closeReservationModal() {
    document.getElementById('reservationModal').classList.add('hidden');
}

function openEditModal(reservationId, datetime, employeeId, serviceId) {
    Swal.fire({
        title: 'Chargement...',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });

    let formattedDatetime = '';
    if (datetime) {
        const dateObj = new Date(datetime);
        const year = dateObj.getFullYear();
        const month = String(dateObj.getMonth() + 1).padStart(2, '0');
        const day = String(dateObj.getDate()).padStart(2, '0');
        const hours = String(dateObj.getHours()).padStart(2, '0');
        const minutes = String(dateObj.getMinutes()).padStart(2, '0');
        
        formattedDatetime = `${year}-${month}-${day}T${hours}:${minutes}`;
    }
    
    document.getElementById('reservation_id').value = reservationId;
    if (serviceId) {
        document.getElementById('edit_service_id').value = serviceId;
    }
    if (formattedDatetime) {
        document.getElementById('edit_datetime').value = formattedDatetime;
    }

    fetch(`/admin/reservations/${reservationId}/edit-data`)
        .then(response => {
            if (!response.ok) throw new Error('Erreur réseau');
            return response.json();
        })
        .then(data => {
            Swal.close();
            
            const select = document.getElementById('edit_employee_id');
            select.innerHTML = '';
            data.employees.forEach(employee => {
                const option = new Option(employee.name, employee.id);
                option.selected = (employee.id == (employeeId || data.reservation.employee_id));
                select.appendChild(option);
            });
            
            document.getElementById('edit_status').value = data.reservation.status;
            
            if (!formattedDatetime) {
                const dateObj = new Date(data.reservation.datetime);
                const year = dateObj.getFullYear();
                const month = String(dateObj.getMonth() + 1).padStart(2, '0');
                const day = String(dateObj.getDate()).padStart(2, '0');
                const hours = String(dateObj.getHours()).padStart(2, '0');
                const minutes = String(dateObj.getMinutes()).padStart(2, '0');
                
                document.getElementById('edit_datetime').value = `${year}-${month}-${day}T${hours}:${minutes}`;
            }
            
            document.getElementById('editReservationModal').classList.remove('hidden');
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: 'Impossible de charger les données de la réservation'
            });
            console.error('Error:', error);
        });
}

function closeEditModal() {
    document.getElementById('editReservationModal').classList.add('hidden');
    document.getElementById('editModalError').classList.add('hidden');
}

function showEditModalError(message) {
    const errorDiv = document.getElementById('editModalError');
    const errorMessage = document.getElementById('editModalErrorMessage');
    
    errorDiv.classList.remove('hidden');
    errorMessage.textContent = message;
    
    errorDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
}

document.addEventListener('DOMContentLoaded', function() {

    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'fr',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: [
            @foreach($calendarReservations as $reservation)
            {
                title: '{{ $reservation->service->name }} - {{ $reservation->client->name }}',
                start: '{{ $reservation->datetime }}',
                end: '{{ $reservation->end_time }}',
                color: @switch($reservation->status)
                            @case('Done') '#10B981' @break
                            @case('Pending') '#F59E0B' @break
                            @case('Refused') '#EF4444' @break
                            @default '#6B7280'
                        @endswitch,
                extendedProps: {
                    client: '{{ $reservation->client->name }}',
                    employee: '{{ $reservation->employee->name }}',
                    service: '{{ $reservation->service->name }}',
                    status: '{{ $reservation->status }}',
                    date: '{{ \Carbon\Carbon::parse($reservation->datetime)->format('d/m/Y') }}',
                    time: '{{ \Carbon\Carbon::parse($reservation->datetime)->format('H:i') }}',
                    reservationId: '{{ $reservation->id }}'
                }
            },
            @endforeach
        ],
        eventClick: function(info) {
            openReservationModal(
                info.event.extendedProps.service,
                info.event.extendedProps.client,
                info.event.extendedProps.employee,
                info.event.extendedProps.status,
                info.event.extendedProps.date,
                info.event.extendedProps.time,
                info.event.extendedProps.reservationId
            );
        }
    });
    calendar.render();

    document.getElementById('reservationModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeReservationModal();
        }
    });
    
    document.getElementById('editReservationModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeEditModal();
        }
    });
    
    document.getElementById('editReservationForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const form = event.target;
        const formData = new FormData(form);
        const reservationId = formData.get('reservation_id');

        const submitButton = form.querySelector('button[type="submit"]');
        const originalText = submitButton.textContent;
        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Enregistrement...';

        fetch(`/admin/reservations/${reservationId}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-HTTP-Method-Override': 'PUT',
                'Accept': 'application/json',
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => {
                    let errorMessage = err.error || 'Une erreur est survenue';
                    if (err.errors) {
                        errorMessage = Object.values(err.errors).flat().join('\n');
                    }
                    throw new Error(errorMessage);
                });
            }
            return response.json();
        })
        .then(data => {
            Swal.fire({
                icon: 'success',
                title: 'Succès',
                text: data.success || 'La réservation a été mise à jour avec succès',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                window.location.reload();
            });
        })
        .catch(error => {
            showEditModalError(error.message);
        })
        .finally(() => {
            submitButton.disabled = false;
            submitButton.innerHTML = originalText;
        });
    });
    

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Succès',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Erreur',
            text: '{{ session('error') }}'
        });
    @endif
});

// add reservation
function openCreateModal() {
    document.getElementById('createReservationModal').classList.remove('hidden');
}

function closeCreateModal() {
    document.getElementById('createReservationModal').classList.add('hidden');
    document.getElementById('createModalError').classList.add('hidden');
}

function showCreateModalError(message) {
    const errorDiv = document.getElementById('createModalError');
    const errorMessage = document.getElementById('createModalErrorMessage');
    
    errorDiv.classList.remove('hidden');
    errorMessage.textContent = message;
    
    errorDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
}

// Gestion du changement de service pour charger les employés
document.getElementById('service_id').addEventListener('change', function() {
    const serviceId = this.value;
    const employeeSelect = document.getElementById('employee_id');
    
    if (!serviceId) {
        employeeSelect.innerHTML = '<option value="">Sélectionner un employé</option>';
        return;
    }
    
    fetch(`/services/${serviceId}/employees`)
        .then(response => response.json())
        .then(data => {
            employeeSelect.innerHTML = '<option value="">Sélectionner un employé</option>';
            data.forEach(employee => {
                const option = new Option(employee.name, employee.id);
                employeeSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error:', error);
            employeeSelect.innerHTML = '<option value="">Erreur de chargement</option>';
        });
});

// Gestion de la soumission du formulaire
document.getElementById('createReservationForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);
    const submitButton = form.querySelector('button[type="submit"]');
    const originalText = submitButton.textContent;
    
    submitButton.disabled = true;
    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Création...';

    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => {
                let errorMessage = err.message || 'Une erreur est survenue';
                if (err.errors) {
                    errorMessage = Object.values(err.errors).flat().join('\n');
                }
                throw new Error(errorMessage);
            });
        }
        return response.json();
    })
    .then(data => {
        Swal.fire({
            icon: 'success',
            title: 'Succès',
            text: data.success || 'La réservation a été créée avec succès',
            timer: 2000,
            showConfirmButton: false
        }).then(() => {
            window.location.reload();
        });
    })
    .catch(error => {
        showCreateModalError(error.message);
    })
    .finally(() => {
        submitButton.disabled = false;
        submitButton.innerHTML = originalText;
    });
});

</script>
@endsection