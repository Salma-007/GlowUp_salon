@extends('layouts.client.app')

@section('title', 'Accueil')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-gray-900 text-white">
        <div class="absolute inset-0 overflow-hidden">
            <img src="{{ asset('storage/pink_background.jpg') }}" alt="Salon GlowUp" class="w-full h-full object-cover opacity-40">
        </div>
        <div class="relative max-w-7xl mx-auto px-4 py-24 sm:px-6 lg:px-8 flex flex-col items-center">
            <h1 class="text-4xl md:text-5xl font-bold text-center mb-6">Révélez votre éclat naturel</h1>
            <p class="text-xl text-center max-w-3xl mb-10">Bienvenue chez GlowUp, votre salon esthétique de confiance pour des soins professionnels qui révèlent votre beauté</p>
            <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                <a href="" class="bg-pink-600 hover:bg-pink-700 text-white font-medium px-6 py-3 rounded-md text-center">Nos services</a>
                <a href="" class="bg-white hover:bg-gray-100 text-pink-600 font-medium px-6 py-3 rounded-md text-center">Réserver maintenant</a>
            </div>
        </div>
    </section>

    <!-- Featured Services -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Nos services populaires</h2>
                
                @if (session('error'))
                        <div class="alert alert-error bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                            {{ session('error') }}
                        </div>
                    @endif
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">Découvrez nos soins les plus appréciés pour une expérience de beauté complète</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($services as $service)
                <!-- Service Card 1 -->
                <div class="bg-gray-50 rounded-lg overflow-hidden shadow-md transition-transform duration-300 hover:shadow-lg hover:transform hover:-translate-y-1">
                    <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $service->name }}</h3>
                        <p class="text-gray-600 mb-4">{{ $service->description }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-pink-600 font-bold">{{ $service->price }}$</span>
                            <a href="" class="text-pink-600 hover:text-pink-800 font-medium">Réserver →</a>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
            
            <div class="text-center mt-10">
                <a href="" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-pink-600 hover:bg-pink-700">
                    Voir tous nos services
                </a>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Pourquoi choisir GlowUp ?</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">Nous nous engageons à vous offrir une expérience exceptionnelle à chaque visite</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="text-center p-6">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-pink-100 text-pink-600 mb-4">
                        <i class="fas fa-award text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Expertise professionnelle</h3>
                    <p class="text-gray-600">Notre équipe est composée de spécialistes qualifiés et expérimentés pour des résultats garantis.</p>
                </div>
                
                <!-- Feature 2 -->
                <div class="text-center p-6">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-pink-100 text-pink-600 mb-4">
                        <i class="fas fa-leaf text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Produits naturels</h3>
                    <p class="text-gray-600">Nous utilisons uniquement des produits de qualité, naturels et adaptés à tous les types de peau.</p>
                </div>
                
                <!-- Feature 3 -->
                <div class="text-center p-6">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-pink-100 text-pink-600 mb-4">
                        <i class="fas fa-spa text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Ambiance relaxante</h3>
                    <p class="text-gray-600">Un environnement paisible et élégant conçu pour votre confort et votre tranquillité.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Ce que disent nos clients</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">Découvrez les expériences de nos clients satisfaits</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400 flex">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p class="text-gray-600 italic mb-4">"Le meilleur salon de beauté que j'ai jamais fréquenté. L'équipe est professionnelle et attentionnée. Je recommande vivement !"</p>
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-user-circle text-2xl text-gray-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Sophie Martin</p>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 2 -->
                <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400 flex">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p class="text-gray-600 italic mb-4">"Le massage relaxant est incroyable ! J'ai adoré l'atmosphère paisible et le professionnalisme du personnel. Je reviendrai certainement."</p>
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-user-circle text-2xl text-gray-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Thomas Dubois</p>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 3 -->
                <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400 flex">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                    <p class="text-gray-600 italic mb-4">"J'ai offert un bon cadeau à ma mère et elle a été enchantée par son expérience. Le personnel est chaleureux et les résultats sont exceptionnels."</p>
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-user-circle text-2xl text-gray-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Julie Petit</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-16 bg-pink-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-6">Prêt à révéler votre éclat naturel ?</h2>
            <p class="text-lg mb-8 max-w-3xl mx-auto">Réservez dès maintenant votre rendez-vous et laissez-nous prendre soin de vous</p>
            <a href="" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-pink-600 bg-white hover:bg-gray-100">
                Réserver un rendez-vous
            </a>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    // Animation pour les cartes de services
    document.addEventListener('DOMContentLoaded', function() {
        const serviceCards = document.querySelectorAll('.grid > div');
        serviceCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.classList.add('shadow-lg');
            });
            card.addEventListener('mouseleave', function() {
                this.classList.remove('shadow-lg');
            });
        });
    });
</script>
@endsection