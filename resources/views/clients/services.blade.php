@extends('layouts.client.app')

@section('title', 'Tous les Services')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Tous nos Services</h1>

        <!-- Affichage des messages de succès ou d'erreur -->
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

        <!-- Liste des Services -->
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
                            <a href="" class="text-pink-600 hover:text-pink-800 font-medium">Réserver →</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination (si nécessaire) -->
        @if ($services->hasPages())
            <div class="mt-8">
                {{ $services->links() }}
            </div>
        @endif
    </div>
@endsection