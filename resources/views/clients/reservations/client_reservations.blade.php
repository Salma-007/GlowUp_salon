@extends('layouts.client.app')

@section('title', 'Mes Réservations')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Mes Réservations</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date et Heure</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employé</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($reservations as $reservation)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $reservation->service->name }}</div>
                                <div class="text-sm text-gray-500">{{ Str::limit($reservation->service->description, 30, '...') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($reservation->datetime)->format('d/m/Y H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $reservation->employee->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($reservation->status === 'Pending')
                                    <span class="px-2 py-1 bg-amber-100 text-amber-800 text-xs rounded-full">En attente</span>
                                @elseif ($reservation->status === 'Done')
                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Terminée</span>
                                @elseif ($reservation->status === 'Refused')
                                    <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">Refusée</span>
                                @else
                                    <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">Statut inconnu ({{ $reservation->status }})</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if($reservation->status !== 'Refused' && $reservation->status !== 'Done')
                                    <button onclick="openEditModal({{ $reservation->id }}, '{{ $reservation->datetime }}', {{ $reservation->employee_id }})" 
                                            class="text-indigo-600 hover:text-indigo-900 mr-2">
                                        Modifier
                                    </button>
                                    <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" 
                                                onclick="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')">
                                            Annuler
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400">Aucune action disponible</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Aucune réservation trouvée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div id="editReservationModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="fixed inset-0 bg-opacity-50 backdrop-blur-sm" aria-hidden="true"></div>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Modifier la réservation</h3>
                    <form id="editReservationForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="reservation_id" id="reservation_id">
                        <div class="mt-4">
                            <label for="edit_datetime" class="block text-sm font-medium text-gray-700">Date et heure</label>
                            <input type="datetime-local" name="datetime" id="edit_datetime" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        <div class="mt-4">
                            <label for="edit_employee_id" class="block text-sm font-medium text-gray-700">Choisir un employé</label>
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
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function openEditModal(reservationId, datetime, employeeId) {

        const reservation = {!! $reservations->toJson() !!}.find(r => r.id === reservationId);
        
        document.getElementById('reservation_id').value = reservationId;
        document.getElementById('edit_datetime').value = datetime;

        const select = document.getElementById('edit_employee_id');
        select.innerHTML = '';
        
        reservation.service.employees.forEach(employee => {
            const option = document.createElement('option');
            option.value = employee.id;
            option.textContent = employee.name;
            option.selected = (employee.id == employeeId);
            select.appendChild(option);
        });

        document.getElementById('editReservationModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editReservationModal').classList.add('hidden');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('editReservationModal');
        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                closeEditModal();
            }
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

    document.getElementById('editReservationForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);
    const reservationId = formData.get('reservation_id');

    fetch(`/reservations/${reservationId}`, {
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
            return response.json().then(err => Promise.reject(err));
        }
        return response.json();
    })
    .then(data => {
        Swal.fire({
            icon: 'success',
            title: 'Succès',
            text: data.success,
            willClose: () => {
                window.location.reload();
            }
        });
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Erreur',
            text: error.error || 'Une erreur est survenue',
            didDestroy: () => {
                document.getElementById('editReservationModal').classList.remove('hidden');
            }
        });
    });
});
</script>
@endsection