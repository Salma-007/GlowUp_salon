<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Service;
use App\Models\Reservation;
use Illuminate\Http\Request;

class adminController extends Controller
{
    public function index()
    {
        $totalClients = User::whereHas('roles', function($query) {
            $query->where('name', 'client');
        })->count();
    
        $totalEmployees = User::whereDoesntHave('roles', function($query) {
            $query->whereIn('name', ['admin', 'client']);
        })->count();
        
        $totalServices = Service::count();
    
        $todayReservations = Reservation::whereDate('datetime', today())->count();
    
        $todayBookings = Reservation::with(['user', 'service'])
            ->whereDate('datetime', today())
            ->orderBy('datetime', 'asc')
            ->get();
    
        $recentClients = User::whereHas('roles', function($query) {
            $query->where('name', 'client');
        })
        ->withCount('reservations')
        ->with(['reservations' => function($query) {
            $query->orderByDesc('datetime');
        }])
        ->orderBy('created_at', 'desc')
        ->take(4)
        ->get();
        
        $completedReservations = Reservation::where('status', 'Done')
            ->whereMonth('datetime', now()->month)
            ->count();
        $totalMonthlyReservations = Reservation::whereMonth('datetime', now()->month)
            ->count();
        $completionRate = $totalMonthlyReservations > 0 
            ? round(($completedReservations / $totalMonthlyReservations) * 100) 
            : 0;
        
        $activities = collect();
        
        $newClients = User::whereHas('roles', function($query) {
            $query->where('name', 'client');
        })->orderBy('created_at', 'desc')->take(3)->get();
        
        foreach($newClients as $client) {
            $activities->push([
                'type' => 'new_client',
                'icon' => 'fa-user-plus',
                'color' => 'green',
                'title' => 'Nouveau client enregistré',
                'description' => $client->name . ' s\'est inscrit',
                'time' => $client->created_at
            ]);
        }

        $newBookings = Reservation::with(['user', 'service'])
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
            
        foreach($newBookings as $booking) {
            $activities->push([
                'type' => 'new_booking',
                'icon' => 'fa-calendar-plus',
                'color' => 'blue',
                'title' => 'Nouvelle réservation',
                'description' => $booking->user->name . ' a réservé ' . $booking->service->name,
                'time' => $booking->created_at
            ]);
        }
        
        $updatedServices = Service::orderBy('updated_at', 'desc')
            ->whereColumn('created_at', '!=', 'updated_at')
            ->take(2)
            ->get();
            
        foreach($updatedServices as $service) {
            $activities->push([
                'type' => 'service_update',
                'icon' => 'fa-cog',
                'color' => 'purple',
                'title' => 'Service mis à jour',
                'description' => 'Le service "' . $service->name . '" a été mis à jour',
                'time' => $service->updated_at
            ]);
        }
        
        $activities = $activities->sortByDesc('time')->take(4);

        $popularServices = Service::withCount('reservations')
            ->orderByDesc('reservations_count')
            ->take(5)
            ->get();
        
        $maxReservations = $popularServices->max('reservations_count') ?: 1;
        $colors = ['bg-blue-500', 'bg-green-500', 'bg-purple-500', 'bg-amber-500', 'bg-red-500'];
    
        return view("admin.index", compact(
            'totalClients',
            'totalEmployees',
            'totalServices',
            'todayReservations',
            'todayBookings',
            'recentClients',
            'completionRate',
            'activities',
            'popularServices',
            'maxReservations',
            'colors'
        ));
    }
}
