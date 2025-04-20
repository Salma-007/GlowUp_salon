@extends('layouts.client.app')

@section('title', 'Réserver un service')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 ">

    <div class="mb-6 flex items-center justify-between bg-white p-3 rounded-lg shadow-md ">
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
    <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal_service_name"></h3>
            
            <div id="modalError" class="hidden bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-4 rounded">
                <p id="modalErrorMessage"></p>
            </div>

            <!-- Stepper -->
            <div class="flex justify-center mb-6">
                <div class="flex items-center">
                    <div id="step1" class="flex flex-col items-center px-4">
                        <div class="w-8 h-8 rounded-full bg-pink-600 text-white flex items-center justify-center">1</div>
                        <div class="mt-2 text-sm font-medium text-pink-600">Choix de l'employé</div>
                    </div>
                    <div class="w-16 h-1 bg-gray-300 mx-2"></div>
                    <div id="step2" class="flex flex-col items-center px-4">
                        <div class="w-8 h-8 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center">2</div>
                        <div class="mt-2 text-sm font-medium text-gray-500">Choix du créneau</div>
                    </div>
                </div>
            </div>

            <div id="step1Content" class="mt-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- Employee cards will be inserted here by JavaScript -->
                </div>
                <div class="flex justify-end mt-6">
                    <button type="button" onclick="closeModal()"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition-colors">
                        Annuler
                    </button>
                    <button type="button" id="nextStepBtn" onclick="goToStep2()"
                            class="px-4 py-2 bg-pink-600 text-white rounded-md hover:bg-pink-700 transition-colors ml-3">
                        Suivant
                    </button>
                </div>
            </div>

            <div id="step2Content" class="hidden mt-4">
                <div class="mb-4">
                    <div id="calendar" class="mb-4"></div>
                    <div id="timeSlots" class="grid grid-cols-4 gap-2">
                        <!-- Time slots will be inserted here by JavaScript -->
                    </div>
                </div>
                <div class="flex justify-between mt-6">
                    <button type="button" onclick="goToStep1()"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition-colors">
                        Retour
                    </button>
                    <button type="button" id="confirmBtn" onclick="confirmReservation()"
                            class="px-4 py-2 bg-pink-600 text-white rounded-md hover:bg-pink-700 transition-colors ml-3">
                        Confirmer la réservation
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/locales/fr.js"></script>
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet">

<script>
    let selectedServiceId = null;
    let selectedServiceName = null;
    let selectedEmployeeId = null;
    let selectedEmployeeName = null;
    let selectedDate = null;
    let selectedTime = null;
    let selectedServiceDuration = 0;
    let calendar = null;

    function openReservationModal(serviceId, serviceName, employees) {
        selectedServiceId = serviceId;
        selectedServiceName = serviceName;
        
        const modal = document.getElementById('reservationModal');
        document.getElementById('modal_service_name').textContent = `Réserver: ${serviceName}`;
        
        // Reset previous selections
        selectedEmployeeId = null;
        selectedDate = null;
        selectedTime = null;
        
        // Update step indicators
        document.getElementById('step1').querySelector('div:first-child').classList.add('bg-pink-600', 'text-white');
        document.getElementById('step1').querySelector('div:first-child').classList.remove('bg-gray-300', 'text-gray-600');
        document.getElementById('step2').querySelector('div:first-child').classList.remove('bg-pink-600', 'text-white');
        document.getElementById('step2').querySelector('div:first-child').classList.add('bg-gray-300', 'text-gray-600');
        
        document.getElementById('step1').querySelector('div:last-child').classList.add('text-pink-600');
        document.getElementById('step1').querySelector('div:last-child').classList.remove('text-gray-500');
        document.getElementById('step2').querySelector('div:last-child').classList.remove('text-pink-600');
        document.getElementById('step2').querySelector('div:last-child').classList.add('text-gray-500');
        
        // Show step 1, hide step 2
        document.getElementById('step1Content').classList.remove('hidden');
        document.getElementById('step2Content').classList.add('hidden');
        
        // Disable next button until employee is selected
        document.getElementById('nextStepBtn').disabled = true;
        
        // Populate employee cards
        const employeeContainer = document.getElementById('step1Content').querySelector('.grid');
        employeeContainer.innerHTML = '';
        
        if (employees && employees.length > 0) {
            employees.forEach(employee => {
                const card = document.createElement('div');
                card.className = 'border rounded-lg p-4 cursor-pointer hover:border-pink-500 transition-colors';
                card.innerHTML = `
                    <div class="flex items-center">
                        ${employee.photo ? 
                            `<img src="{{ asset('storage/') }}/${employee.photo}" class="w-12 h-12 rounded-full object-cover mr-3">` : 
                            `<div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center mr-3">
                                <i class="fas fa-user text-gray-500"></i>
                            </div>`
                        }
                        <div>
                            <h4 class="font-medium">${employee.name}</h4>
                        </div>
                    </div>
                `;
                
                card.addEventListener('click', function() {
                    // Remove selection from all cards
                    document.querySelectorAll('#step1Content .grid > div').forEach(c => {
                        c.classList.remove('border-pink-500', 'bg-pink-50');
                        c.classList.add('border-gray-200');
                    });
                    
                    // Add selection to this card
                    this.classList.add('border-pink-500', 'bg-pink-50');
                    this.classList.remove('border-gray-200');
                    
                    selectedEmployeeId = employee.id;
                    selectedEmployeeName = employee.name;
                    
                    // Enable next button
                    document.getElementById('nextStepBtn').disabled = false;
                });
                
                employeeContainer.appendChild(card);
            });
        } else {
            employeeContainer.innerHTML = '<p class="col-span-3 text-gray-500 py-4">Aucun employé disponible pour ce service.</p>';
        }
        
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function goToStep2() {
        if (!selectedEmployeeId) return;
        
        document.getElementById('step2').querySelector('div:first-child').classList.add('bg-pink-600', 'text-white');
        document.getElementById('step2').querySelector('div:first-child').classList.remove('bg-gray-300', 'text-gray-600');
        document.getElementById('step2').querySelector('div:last-child').classList.add('text-pink-600');
        document.getElementById('step2').querySelector('div:last-child').classList.remove('text-gray-500');
        
        document.getElementById('step1Content').classList.add('hidden');
        document.getElementById('step2Content').classList.remove('hidden');
        
        const calendarEl = document.getElementById('calendar');
        if (calendarEl) {
            calendarEl.innerHTML = ''; 
            
            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'fr',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek'
                },
                events: {
                    url: '/reservations/calendar', 
                    method: 'GET',
                    extraParams: {
                        employee_id: selectedEmployeeId
                    },
                    failure: function() {
                        alert('Erreur lors du chargement des réservations');
                    }
                },
                dateClick: function(info) {
                    const clickedDate = new Date(info.dateStr);
                    const today = new Date();
                    today.setHours(0, 0, 0, 0); 
                    
                    if (clickedDate < today) {
                        showModalError('Vous ne pouvez pas réserver une date passée');
                        document.getElementById('timeSlots').innerHTML = '';
                        return;
                    }
                    
                    selectedDate = info.dateStr;
                    loadAvailableTimeSlots(info.dateStr);
                },
                eventTimeFormat: { 
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                }
            });
            
            calendar.render();
        }
    }

    function goToStep1() {
        
        document.getElementById('step2').querySelector('div:first-child').classList.remove('bg-pink-600', 'text-white');
        document.getElementById('step2').querySelector('div:first-child').classList.add('bg-gray-300', 'text-gray-600');
        document.getElementById('step2').querySelector('div:last-child').classList.remove('text-pink-600');
        document.getElementById('step2').querySelector('div:last-child').classList.add('text-gray-500');
        
        document.getElementById('step2Content').classList.add('hidden');
        document.getElementById('step1Content').classList.remove('hidden');
        
        selectedDate = null;
        selectedTime = null;
        document.getElementById('timeSlots').innerHTML = '';
    }

    function loadAvailableTimeSlots(date) {

        const selectedDateObj = new Date(date);
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        
        if (selectedDateObj < today) {
            document.getElementById('timeSlots').innerHTML = `
                <p class="col-span-4 text-red-500 py-4">
                    Date passée - veuillez choisir une date future
                </p>`;
            return;
        }

        if (!selectedEmployeeId || !selectedServiceId) {
            console.error('Missing required parameters');
            return;
        }

        console.log('Fetching slots for:', {selectedEmployeeId, date, selectedServiceId});

        fetch(`/api/availability?${new URLSearchParams({
            employee_id: selectedEmployeeId,
            date: date,
            service_id: selectedServiceId
        })}`, {
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(async response => {
            const contentType = response.headers.get('content-type');
            
            if (!contentType || !contentType.includes('application/json')) {
                const text = await response.text();
                console.error('Expected JSON but got:', text);
                throw new Error('Le serveur a retourné une réponse non-JSON');
            }

            if (!response.ok) {
                const err = await response.json();
                throw new Error(err.message || 'Erreur serveur');
            }
            
            return response.json();
        })
        .then(data => {
            console.log('Received data:', data);
            const timeSlotsContainer = document.getElementById('timeSlots');
            timeSlotsContainer.innerHTML = '';
            
            if (data.available_slots?.length > 0) {
                data.available_slots.forEach(slot => {
                    const timeBtn = document.createElement('button');
                    timeBtn.type = 'button';
                    timeBtn.className = 'px-3 py-2 border rounded-md text-sm font-medium hover:bg-pink-100 transition-colors';
                    timeBtn.textContent = slot;
                    
                    timeBtn.addEventListener('click', function() {
                        document.querySelectorAll('#timeSlots button').forEach(btn => {
                            btn.classList.remove('bg-pink-600', 'text-white', 'border-pink-600');
                            btn.classList.add('border-gray-300');
                        });
                        
                        this.classList.add('bg-pink-600', 'text-white', 'border-pink-600');
                        this.classList.remove('border-gray-300');
                        
                        selectedTime = slot;
                        console.log('Selected time:', selectedTime);
                    });
                    
                    timeSlotsContainer.appendChild(timeBtn);
                });
            } else {
                timeSlotsContainer.innerHTML = `
                    <p class="col-span-4 text-gray-500 py-4">
                        Aucun créneau disponible pour cette date.
                        ${data.message ? `<br>${data.message}` : ''}
                    </p>
                `;
            }
        })
        .catch(error => {
            console.error('Full error:', error);
            const timeSlotsContainer = document.getElementById('timeSlots');
            timeSlotsContainer.innerHTML = `
                <p class="col-span-4 text-red-500 py-4">
                    Erreur lors du chargement des créneaux.<br>
                    ${error.message}
                </p>
            `;
        });
}

function confirmReservation() {
    if (!selectedServiceId || !selectedEmployeeId || !selectedDate || !selectedTime) {
        showModalError('Veuillez sélectionner un créneau horaire.');
        return;
    }
    
    const datetime = `${selectedDate}T${selectedTime}`;
    
    Swal.fire({
        title: 'Confirmation',
        html: `Confirmez-vous la réservation avec <b>${selectedEmployeeName}</b> le <b>${new Date(selectedDate).toLocaleDateString('fr-FR')}</b> à <b>${selectedTime}</b> ?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Confirmer',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.showLoading();
            
            fetch('{{ route("new_reservation") }}', { 
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    service_id: selectedServiceId,
                    employee_id: selectedEmployeeId,
                    datetime: datetime,
                    status: 'pending',
                    _method: 'POST'
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => {
                        throw new Error(text || 'Erreur serveur');
                    });
                }
                return response.json();
            })
            .then(data => {
                Swal.fire({
                    icon: 'success',
                    title: 'Succès',
                    text: 'Réservation confirmée!',
                    timer: 3000
                });
                closeModal();
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: error.message || 'Erreur lors de la réservation'
                });
            });
        }
    });
}

    function showModalError(message) {
        const errorDiv = document.getElementById('modalError');
        const errorMessage = document.getElementById('modalErrorMessage');
        
        errorDiv.classList.remove('hidden');
        errorMessage.textContent = message;
        
        setTimeout(() => {
            errorDiv.classList.add('hidden');
        }, 5000);
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
        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Succès',
            text: '{{ session('success') }}',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false
        });
        @endif
    });
</script>
@endsection