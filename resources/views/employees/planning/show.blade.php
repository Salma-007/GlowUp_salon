@extends('layouts.admin.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Mon Planning</h1>
    
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Calendar View -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-8">
        <div id="calendar"></div>
    </div>

    <!-- List View -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-medium">Mes Réservations</h2>
            <p class="text-sm text-gray-500">
                Affichage de {{ $reservations->firstItem() }} à {{ $reservations->lastItem() }} sur {{ $reservations->total() }} réservations
            </p>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Détails</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date/Heure</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durée</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($reservations as $reservation)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($reservation->client_id == $user->id)
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">Réservation</span>
                            @else
                                <span class="px-2 py-1 bg-purple-100 text-purple-800 text-xs rounded-full">Prestation</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">
                                @if($reservation->client_id == $user->id)
                                    {{ $reservation->service->name }} avec {{ $reservation->employee->name }}
                                @else
                                    {{ $reservation->service->name }} pour {{ $reservation->client->name }}
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ \Carbon\Carbon::parse($reservation->datetime)->format('d/m/Y H:i') }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ $reservation->service->duration }} minutes
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @switch($reservation->status)
                                @case('pending')
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">En attente</span>
                                    @break
                                @case('confirmed')
                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Confirmé</span>
                                    @break
                                @case('cancelled')
                                    <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">Annulé</span>
                                    @break
                                @default
                                    <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">{{ $reservation->status }}</span>
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
                                '{{ $reservation->service->duration }}',
                                '{{ $reservation->notes ?? 'Aucune note' }}',
                                '{{ $reservation->id }}'
                            )" class="text-blue-600 hover:text-blue-900 mr-2">
                                Voir
                            </button>
                            @if($reservation->client_id == $user->id && $reservation->status == 'pending')
                                <a href="{{ route('reservations.edit', $reservation->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">Modifier</a>
                                <form action="{{ route('reservations.cancel', $reservation->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Êtes-vous sûr de vouloir annuler cette réservation?')">
                                        Annuler
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">Aucune réservation trouvée.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            {{ $reservations->links() }}
        </div>
    </div>
</div>

<!-- Reservation Modal -->
<div id="reservationModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Détails de la réservation</h3>
                <div class="grid grid-cols-2 gap-4">
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
                    <div>
                        <p class="text-sm font-medium text-gray-500">Durée</p>
                        <p id="modalDuration" class="mt-1 text-sm text-gray-900"></p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-sm font-medium text-gray-500">Notes</p>
                        <p id="modalNotes" class="mt-1 text-sm text-gray-900"></p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="closeReservationModal()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
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
    function openReservationModal(service, client, employee, status, date, time, duration, notes, reservationId) {
        document.getElementById('modalService').textContent = service;
        document.getElementById('modalClient').textContent = client;
        document.getElementById('modalEmployee').textContent = employee;
        document.getElementById('modalDuration').textContent = duration + ' minutes';
        
        const statusElement = document.getElementById('modalStatus');
        statusElement.textContent = status.charAt(0).toUpperCase() + status.slice(1);
        statusElement.className = 'mt-1 text-sm px-2 py-1 rounded-full text-xs font-medium';
        
        switch(status.toLowerCase()) {
            case 'confirmed':
                statusElement.classList.add('bg-green-100', 'text-green-800');
                break;
            case 'pending':
                statusElement.classList.add('bg-yellow-100', 'text-yellow-800');
                break;
            case 'cancelled':
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
                    title: '{{ $reservation->service->name }}' + 
                           (@if($reservation->client_id == $user->id) 
                              ' (avec {{ $reservation->employee->name }})' 
                           @else 
                              ' (pour {{ $reservation->client->name }})' 
                           @endif),
                    start: '{{ $reservation->datetime }}',
                    end: '{{ $reservation->end_time }}',
                    color: @if($reservation->client_id == $user->id) '#3B82F6' @else '#8B5CF6' @endif,
                    extendedProps: {
                        client: '{{ $reservation->client->name }}',
                        employee: '{{ $reservation->employee->name }}',
                        service: '{{ $reservation->service->name }}',
                        duration: '{{ $reservation->service->duration }} minutes',
                        status: '{{ $reservation->status }}',
                        date: '{{ \Carbon\Carbon::parse($reservation->datetime)->format('d/m/Y') }}',
                        time: '{{ \Carbon\Carbon::parse($reservation->datetime)->format('H:i') }}',
                        notes: '{{ $reservation->notes ?? 'Aucune note' }}'
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
                    info.event.extendedProps.duration,
                    info.event.extendedProps.notes
                );
            }
        });
        calendar.render();
    });
</script>
@endsection