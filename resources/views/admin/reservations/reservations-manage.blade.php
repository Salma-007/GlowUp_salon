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

    <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50">
        <div class="max-w-7xl mx-auto">
            <!-- Calendar -->
            <div class="bg-white shadow-md rounded-xl overflow-hidden border border-gray-100">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Calendrier des Réservations</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        Visualisez et gérez les réservations (Total: {{ $reservations->total() }})
                    </p>
                </div>
                <div class="p-6">
                    <div id="calendar"></div>
                </div>
            </div>

            <!-- Reservations List with Pagination -->
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
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Confirmé</span>
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
                                        '{{ $reservation->notes ?? 'Aucune note' }}',
                                        '{{ $reservation->id }}'
                                    )" class="text-blue-600 hover:text-blue-900 mr-3">
                                        Voir
                                    </button>
                                    
                                    @if($reservation->status !== 'Done' && $reservation->status !== 'Refused')
                                        <a href="" class="text-indigo-600 hover:text-indigo-900 mr-3">Modifier</a>
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
                
                <!-- Pagination -->
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

<!-- Reservation Modal -->
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
                            <div class="col-span-2">
                                <p class="text-sm font-medium text-gray-500">Notes</p>
                                <p id="modalNotes" class="mt-1 text-sm text-gray-900"></p>
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

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/locales/fr.js"></script>

<script>
function openReservationModal(service, client, employee, status, date, time, notes, reservationId) {
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
        const editButton = document.createElement('a');
        editButton.id = 'modalEditButton';
        editButton.href = '/admin/reservations/' + reservationId + '/edit';
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
    document.getElementById('modalNotes').textContent = notes;
    
    document.getElementById('reservationModal').classList.remove('hidden');
}

    function closeReservationModal() {
        document.getElementById('reservationModal').classList.add('hidden');
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
                @foreach($reservations as $reservation)
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
                        notes: '{{ $reservation->notes ?? 'Aucune note' }}',
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
                    info.event.extendedProps.notes,
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
    });
</script>
@endsection