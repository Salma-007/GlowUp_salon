<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Service;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;

class ReservationController extends Controller
{
    public function index()
    {
        try {
            $reservations = Reservation::with(['client', 'employee', 'service'])->paginate(10);
            return view('reservations.index', compact('reservations'));

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
            Reservation::create([
                'client_id' => $request->client_id,
                'employee_id' => $request->employee_id,
                'service_id' => $request->service_id,
                'datetime' => $request->datetime,
                'status' => $request->status ?? 'pending', 
            ]);

            return redirect()->route('reservations.index')->with('success', 'Réservation créée avec succès.');
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
            return redirect()->route('reservations.index')->with('success', 'Réservation supprimée avec succès.');

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la suppression de la réservation.' . $e->getMessage());
        }
    }

}
