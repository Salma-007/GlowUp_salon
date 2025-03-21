@extends('layouts.client.app')

@section('title', 'Réserver un service')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Réserver un service</h1>
        
        <form action="{{ route('reservations.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
            @csrf
            <div class="mb-4">
                <label for="service_id" class="block text-gray-700 font-medium mb-2">Service</label>
                <select name="service_id" id="service_id" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600">
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
                <select name="employee_id" id="employee_id" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600">
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-pink-600 hover:bg-pink-700 text-white font-medium px-6 py-2 rounded-lg transition duration-300">Réserver</button>
            </div>
        </form>
    </div>
@endsection