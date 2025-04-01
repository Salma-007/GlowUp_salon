<?php

namespace App\Http\Controllers;

use DateTime;
use Exception;
use DateInterval;
use App\Models\User;
use App\Models\Service;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Events\ReservationCreated;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Http\Requests\StoreModalReservationRequest;

class ReservationController extends Controller
{
    public function index()
    {
        try {
            
            $reservations = Reservation::with(['client', 'employee', 'service'])->paginate(10);
            return view('reservations.index', compact('reservations','employees'));

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la récupération des réservations.' . $e->getMessage());
        }
    }


    public function create()
    {
        try {
            // $clients = User::where('role_id', 'client')->get(); 
            $employees = User::whereNotIn('role_id', [2, 4])->get();
            $services = Service::all(); 
            return view('clients.reservations.create', compact( 'employees', 'services'));

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la préparation du formulaire de création.' . $e->getMessage());
        }
    }

    public function store(StoreReservationRequest $request)
    {
        try {

            if (!Auth::check()) {
                return redirect()->route('login');
            }
    
            $client = Auth::user();

            $service = Service::findOrFail($request->service_id);

            $startTime = new DateTime($request->datetime);
            $endTime = clone $startTime;
            $endTime->add(new DateInterval('PT' . $service->duration . 'M'));

            Reservation::create([
                'client_id' => $client->id,
                'employee_id' => $request->employee_id,
                'service_id' => $request->service_id,
                'datetime' => $request->datetime,
                'end_time' => $endTime->format('Y-m-d H:i:s'),
                'status' => $request->status ?? 'pending', 
            ]);

            event(new ReservationCreated($reservation));
            
            return redirect()->route('home')->with('success', 'Réservation créée avec succès.');
            
        } catch (Exception $e) {

            return redirect()->back()->with('error', 'Une erreur est survenue lors de la création de la réservation.' . $e->getMessage());
        }
    }

    public function show(Reservation $reservation)
    {
        try {
            return view('reservations.show', compact('reservation'));
        } catch (Exception $e) {

            return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'affichage de la réservation.' . $e->getMessage());
        }
    }

    public function edit(Reservation $reservation)
    {
        try {
            $clients = User::where('role', 'client')->get();
            $employees = User::where('role', 'employee')->get(); 
            $services = Service::all(); 
            return view('reservations.edit', compact('reservation', 'clients', 'employees', 'services'));

        } catch (Exception $e) {

            return redirect()->back()->with('error', 'Une erreur est survenue lors de la préparation du formulaire de modification.' . $e->getMessage());
        }
    }

    public function update(UpdateReservationRequest $request, Reservation $reservation)
    {
        try {
            
            $reservation->update([
                'client_id' => $request->client_id,
                'employee_id' => $request->employee_id,
                'service_id' => $request->service_id,
                'datetime' => $request->datetime,
                'status' => $request->status ?? 'pending',
            ]);

            return redirect()->route('reservations.index')->with('success', 'Réservation mise à jour avec succès.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la mise à jour de la réservation.' . $e->getMessage());
        }
    }

    public function destroy(Reservation $reservation)
    {
        try {
            $reservation->delete();
            return redirect()->route('clients.reservations.index')->with('success', 'Réservation supprimée avec succès.');

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la suppression de la réservation.' . $e->getMessage());
        }
    }

    public function clientReservations()
    {
        $employees = User::whereNotIn('role_id', [2, 4])->get();
        $client = Auth::user();

        $reservations = Reservation::with(['service', 'employee'])
            ->where('client_id', $client->id)
            ->orderBy('datetime', 'desc')
            ->get();

        return view('clients.reservations.client_reservations', compact('reservations','employees'));
    }

}
