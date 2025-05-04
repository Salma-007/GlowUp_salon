@extends('layouts.client.app')

@section('title', 'Réserver un service')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">

    <div class="bg-white rounded-xl shadow-sm p-6 flex flex-col md:flex-row items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Nos Prestations</h1>
            <p class="text-gray-500 mt-1">Choisissez le service qui vous correspond</p>
        </div>
        
        <form method="GET" action="{{ route('services') }}" class="flex items-center gap-3 w-full md:w-auto">
            <div class="relative flex-grow md:flex-grow-0">
                <select name="category_id" onchange="this.form.submit()" 
                        class="appearance-none pl-3 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 w-full">
                    <option value="">Toutes catégories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
            
            @if(request('category_id'))
                <a href="{{ route('services') }}" 
                   class="text-pink-600 hover:text-pink-800 text-sm whitespace-nowrap flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Réinitialiser
                </a>
            @endif
        </form>
    </div>

    <!-- Liste des services -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($services as $service)
        <div class="bg-white rounded-xl overflow-hidden shadow-md transition-all duration-300 hover:shadow-lg hover:-translate-y-1 group">
            <div class="relative h-48 overflow-hidden">
                <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" 
                    class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
            </div>
            
            <div class="p-5">
                <div class="flex justify-between items-start mb-3">
                    <h3 class="text-xl font-semibold text-gray-900">{{ $service->name }}</h3>
                    <span class="bg-pink-100 text-pink-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        {{ $service->category->name }}
                    </span>
                </div>

                <div class="relative mb-4">
                    <p class="text-gray-600 line-clamp-2 group-hover:line-clamp-none group-hover:pb-6 transition-all duration-300">
                        {{ $service->description }}
                    </p>
                    <div class="absolute bottom-0 left-0 right-0 h-6 bg-gradient-to-t from-white to-transparent opacity-100 group-hover:opacity-0 transition-opacity duration-300 pointer-events-none"></div>
                </div>
                
                <div class="flex justify-between items-center">
                    <div>
                        <span class="text-pink-600 font-bold text-lg">{{ number_format($service->price, 2) }}€</span>
                        <span class="text-gray-500 text-sm ml-2">({{ $service->duration }} min)</span>
                    </div>
                    <button onclick="openReservationModal({{ $service->id }}, '{{ addslashes($service->name) }}', {{ json_encode($service->employees) }})" 
                            class="flex items-center text-pink-600 hover:text-pink-800 font-medium group">
                        Réserver
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if ($services->hasPages())
        <div class="mt-8">
            {{ $services->links('vendor.pagination.tailwind') }}
        </div>
    @endif
</div>

<div id="reservationModal" class="hidden fixed inset-0 bg-black/30 backdrop-blur-sm overflow-y-auto h-full w-full z-50 p-4">
    <div class="relative mx-auto p-0 w-full max-w-2xl">

        <div class="bg-white rounded-xl shadow-xl overflow-hidden">

            <div class="bg-pink-600 px-6 py-4">
                <h3 class="text-lg font-medium text-white" id="modal_service_name"></h3>
            </div>

            <div id="modalError" class="hidden bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mx-6 mt-4 rounded">
                <p id="modalErrorMessage"></p>
            </div>

            <div class="flex justify-center py-6 px-6">
                <div class="flex items-center w-full max-w-md">
                    <div id="step1" class="flex flex-col items-center flex-1">
                        <div class="w-10 h-10 rounded-full bg-pink-600 text-white flex items-center justify-center relative z-10">
                            <span>1</span>
                        </div>
                        <div class="mt-2 text-sm font-medium text-pink-600 text-center">Choix de l'employé</div>
                    </div>
                    <div class="h-1 bg-gray-200 flex-1 mx-2 relative">
                        <div class="absolute inset-0 bg-pink-600 transition-all duration-300 ease-in-out" id="progressBar"></div>
                    </div>
                    <div id="step2" class="flex flex-col items-center flex-1">
                        <div class="w-10 h-10 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center relative z-10">
                            <span>2</span>
                        </div>
                        <div class="mt-2 text-sm font-medium text-gray-500 text-center">Choix du créneau</div>
                    </div>
                </div>
            </div>

            <!-- step 1  -->
            <div id="step1Content" class="px-6 pb-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- employees here by js -->
                </div>
                <div class="flex justify-end mt-6 space-x-3">
                    <button type="button" onclick="closeModal()"
                            class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Annuler
                    </button>
                    <button type="button" id="nextStepBtn" onclick="goToStep2()" disabled
                            class="px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 transition-colors flex items-center">
                        Suivant
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- step 2 -->
            <div id="step2Content" class="hidden px-6 pb-6">
                <div class="mb-4">
                    <div id="calendar" class="mb-6"></div>
                    <div class="mb-2 text-sm font-medium text-gray-700">Créneaux disponibles :</div>
                    <div id="timeSlots" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2">
                        <!-- timeslots by js -->
                    </div>
                </div>
                <div class="flex justify-between mt-6 space-x-3">
                    <button type="button" onclick="goToStep1()"
                            class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Retour
                    </button>
                    <button type="button" id="confirmBtn" onclick="confirmReservation()"
                            class="px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 transition-colors flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Confirmer
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
        
        selectedEmployeeId = null;
        selectedDate = null;
        selectedTime = null;
        
        document.getElementById('step1').querySelector('div:first-child').classList.add('bg-pink-600', 'text-white');
        document.getElementById('step1').querySelector('div:first-child').classList.remove('bg-gray-300', 'text-gray-600');
        document.getElementById('step2').querySelector('div:first-child').classList.remove('bg-pink-600', 'text-white');
        document.getElementById('step2').querySelector('div:first-child').classList.add('bg-gray-300', 'text-gray-600');
        
        document.getElementById('step1').querySelector('div:last-child').classList.add('text-pink-600');
        document.getElementById('step1').querySelector('div:last-child').classList.remove('text-gray-500');
        document.getElementById('step2').querySelector('div:last-child').classList.remove('text-pink-600');
        document.getElementById('step2').querySelector('div:last-child').classList.add('text-gray-500');
        
        document.getElementById('step1Content').classList.remove('hidden');
        document.getElementById('step2Content').classList.add('hidden');
        
        document.getElementById('nextStepBtn').disabled = true;
        
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
                    document.querySelectorAll('#step1Content .grid > div').forEach(c => {
                        c.classList.remove('border-pink-500', 'bg-pink-50');
                        c.classList.add('border-gray-200');
                    });
                    
                    this.classList.add('border-pink-500', 'bg-pink-50');
                    this.classList.remove('border-gray-200');
                    
                    selectedEmployeeId = employee.id;
                    selectedEmployeeName = employee.name;
                    
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
                    status: 'pending'
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => {
                        throw new Error(err.message || 'Erreur serveur');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Succès',
                        text: data.message,
                        timer: 3000
                    });
                    closeModal();
                } else {
                    throw new Error(data.message);
                }
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