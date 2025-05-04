@extends('layouts.client.app')

@section('title', 'Accueil')

@section('content')
    <section class="relative bg-gray-900 text-white">
        <div class="absolute inset-0 overflow-hidden">
            <img src="{{ asset('storage/pink_background.jpg') }}" alt="Salon GlowUp" class="w-full h-full object-cover opacity-40">
        </div>
        <div class="relative max-w-7xl mx-auto px-4 py-32 sm:px-6 lg:px-8 flex flex-col items-center text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6 leading-tight">
                Révélez votre <span class="text-pink-400">éclat naturel</span>
            </h1>
            <p class="text-xl max-w-3xl mb-10 opacity-90">
                Bienvenue chez GlowUp, votre salon esthétique de confiance pour des soins professionnels qui subliment votre beauté
            </p>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('services') }}" class="bg-pink-600 hover:bg-pink-700 text-white font-medium px-8 py-3 rounded-lg transition-colors shadow-lg">
                    Découvrir nos services
                </a>
                <a href="{{ route('reservation-ajout') }}" class="bg-white hover:bg-gray-100 text-pink-600 font-medium px-8 py-3 rounded-lg transition-colors shadow-lg">
                    Réserver maintenant
                </a>
            </div>
        </div>
    </section>

    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4 relative inline-block">
                    Nos services populaires
                    <span class="absolute bottom-0 left-0 w-full h-1 bg-pink-500 transform translate-y-2"></span>
                </h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Découvrez nos soins les plus appréciés pour une expérience de beauté complète
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($services as $service)
            <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300 border border-gray-100">
                <div class="relative h-60 overflow-hidden">
                    <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" 
                        class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                </div>

                <div class="p-6 flex flex-col">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $service->name }}</h3>
                    <p class="text-gray-600 mb-4 line-clamp-2 flex-grow">{{ $service->description }}</p>

                    <div class="flex justify-between items-center mb-4">
                        <span class="text-pink-600 font-bold text-lg">{{ number_format($service->price, 2) }}€</span>
                        <span class="text-gray-500 text-sm">{{ $service->duration }} min</span>
                    </div>

                    <a href="{{ route('services') }}" 
                    class="block text-center bg-pink-50 hover:bg-pink-100 text-pink-600 font-medium py-2 px-4 rounded-lg transition-colors">
                        Réserver ce soin
                    </a>
                </div>
            </div>
            @endforeach
        </div>
            
            <div class="text-center mt-12">
                <a href="{{ route('services') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-lg font-medium rounded-md text-white bg-pink-600 hover:bg-pink-700 shadow-lg transition-colors">
                    Voir tous nos services
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4 relative inline-block">
                    Pourquoi choisir GlowUp ?
                    <span class="absolute bottom-0 left-0 w-full h-1 bg-pink-500 transform translate-y-2"></span>
                </h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Nous nous engageons à vous offrir une expérience exceptionnelle à chaque visite
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-shadow text-center">
                    <div class="mx-auto w-16 h-16 rounded-full bg-pink-100 text-pink-600 mb-4 flex items-center justify-center">
                        <i class="fas fa-award text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Expertise professionnelle</h3>
                    <p class="text-gray-600">Nos spécialistes qualifiés vous garantissent des résultats impeccables et durables.</p>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-shadow text-center">
                    <div class="mx-auto w-16 h-16 rounded-full bg-pink-100 text-pink-600 mb-4 flex items-center justify-center">
                        <i class="fas fa-leaf text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Produits naturels</h3>
                    <p class="text-gray-600">Nous sélectionnons des produits haut de gamme, naturels et respectueux de votre peau.</p>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-shadow text-center">
                    <div class="mx-auto w-16 h-16 rounded-full bg-pink-100 text-pink-600 mb-4 flex items-center justify-center">
                        <i class="fas fa-spa text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Ambiance luxueuse</h3>
                    <p class="text-gray-600">Un havre de paix conçu pour votre bien-être et votre détente absolue.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4 relative inline-block">
                    Témoignages clients
                    <span class="absolute bottom-0 left-0 w-full h-1 bg-pink-500 transform translate-y-2"></span>
                </h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Ils nous ont fait confiance et partagent leur expérience
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                    <div class="flex mb-4">
                        @for ($i = 0; $i < 5; $i++)
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @endfor
                    </div>
                    <p class="text-gray-600 italic mb-6">"Le meilleur salon que j'ai connu. Un professionnalisme rare allié à une ambiance chaleureuse."</p>
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-pink-100 text-pink-600 rounded-full w-10 h-10 flex items-center justify-center">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Sophie Martin</p>
                            <p class="text-xs text-gray-500">Cliente fidèle</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                    <div class="flex mb-4">
                        @for ($i = 0; $i < 5; $i++)
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @endfor
                    </div>
                    <p class="text-gray-600 italic mb-6">"Des résultats toujours au rendez-vous. Mon rendez-vous mensuel chez GlowUp est un rituel sacré."</p>
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-pink-100 text-pink-600 rounded-full w-10 h-10 flex items-center justify-center">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Thomas Dubois</p>
                            <p class="text-xs text-gray-500">Depuis 2 ans</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                    <div class="flex mb-4">
                        @for ($i = 0; $i < 4; $i++)
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @endfor
                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </div>
                    <p class="text-gray-600 italic mb-6">"J'ai offert un bon cadeau à ma mère qui a été ravie. Le personnel est aux petits soins."</p>
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-pink-100 text-pink-600 rounded-full w-10 h-10 flex items-center justify-center">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Julie Petit</p>
                            <p class="text-xs text-gray-500">Nouvelle cliente</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-pink-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-6">Prêt à révéler votre éclat ?</h2>
            <p class="text-xl mb-8 max-w-3xl mx-auto">
                Réservez dès maintenant votre rendez-vous pour une expérience unique
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('reservation-ajout') }}" class="bg-white hover:bg-gray-100 text-pink-600 font-bold px-8 py-4 rounded-lg shadow-lg transition-colors">
                    Prendre rendez-vous
                </a>
                <a href="tel:+33123456789" class="bg-transparent hover:bg-pink-700 border-2 border-white text-white font-bold px-8 py-4 rounded-lg transition-colors">
                    <i class="fas fa-phone-alt mr-2"></i>Nous appeler
                </a>
            </div>
        </div>
    </section>

    <div id="reservationModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" aria-hidden="true"></div>
        
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md overflow-hidden">
                <div class="bg-pink-600 px-6 py-4">
                    <h3 class="text-xl font-bold text-white">Réserver un soin</h3>
                </div>
                
                <div class="p-6">
                    @if ($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form id="reservationForm" action="{{ route('new_reservation') }}" method="POST">
                        @csrf
                        <input type="hidden" name="service_id" id="service_id">
                        
                        <div class="space-y-4">
                            <div>
                                <label for="datetime" class="block text-sm font-medium text-gray-700 mb-1">Date et heure</label>
                                <input type="datetime-local" name="datetime" id="datetime" 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-pink-500 focus:border-pink-500" 
                                       required>
                            </div>
                            
                            <div>
                                <label for="employee_id" class="block text-sm font-medium text-gray-700 mb-1">Employé</label>
                                <select name="employee_id" id="employee_id" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-pink-500 focus:border-pink-500" 
                                        required>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="flex justify-end space-x-3 pt-4">
                                <button type="button" onclick="closeModal()" 
                                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50">
                                    Annuler
                                </button>
                                <button type="submit" 
                                        class="px-4 py-2 bg-pink-600 text-white rounded-md hover:bg-pink-700">
                                    Confirmer
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>

    function openReservationModal(serviceId) {
        document.getElementById('service_id').value = serviceId;
        document.getElementById('reservationModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        document.getElementById('reservationModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('reservationModal');
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal();
            }
        });

        @if ($errors->any())
            openReservationModal({{ old('service_id') }});
        @endif
    });
</script>
@endsection