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
            $now = now()->timezone(config('app.timezone'));

            // pour update à chaque fois les status des reservations
            Reservation::where('end_time', '<', $now)
                ->whereNotIn('status', ['Done', 'Refused'])
                ->update(['status' => 'Done']);

            $paginatedReservations = Reservation::with(['client', 'employee', 'service'])
                ->orderBy('datetime', 'desc')
                ->paginate(6);

            $calendarReservations = Reservation::with(['client', 'employee', 'service'])
                ->orderBy('datetime', 'asc')
                ->get()
                ->map(function ($reservation) {
                    $reservation->datetime = \Carbon\Carbon::parse($reservation->datetime)
                        ->timezone(config('app.timezone'))
                        ->format('Y-m-d H:i:s');
                    return $reservation;
                });

                $services = Service::all();

                $clients = User::whereHas('roles', function($query) {
                    $query->where('name', 'client');
                })->get();
        
            return view('admin.reservations.reservations-manage', [
                'reservations' => $paginatedReservations,
                'calendarReservations' => $calendarReservations,
                'clients' => $clients,
                'services' => $services
            ]);
        
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la récupération des réservations: ' . $e->getMessage());
        }
    }
    public function userReservations()
    {
        try {
            $user = auth()->user();
            
            $reservations = Reservation::with(['client', 'employee', 'service'])
                ->where('client_id', $user->id)
                ->orWhere('employee_id', $user->id)
                ->orderBy('datetime', 'asc')
                ->paginate(10);
                
            return view('employees.planning.show', compact('reservations', 'user'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue: ' . $e->getMessage());
        }
    }


    public function create()
    {
        try {
            $employees = User::whereDoesntHave('roles', function ($query) {
                $query->whereIn('name', ['client', 'admin']);
            })->get();
            $services = Service::all(); 
            return view('clients.reservations.create', compact( 'employees', 'services'));

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la préparation du formulaire de création.' . $e->getMessage());
        }
    }


    public function getEmployeesByService($serviceId)
    {
        $employees = User::whereHas('services', function($query) use ($serviceId) {
            $query->where('services.id', $serviceId);
        })->get();

        return response()->json($employees);
    }

    public function store(StoreReservationRequest $request)
    {
        try {
            if (!Auth::check()) {
                return redirect()->route('login');
            }
    
            $client = Auth::user();

            $service = Service::findOrFail($request->service_id);

            $selectedDateTime = new DateTime($request->datetime);
            $currentDateTime = new DateTime(); 

            if ($selectedDateTime < $currentDateTime) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vous ne pouvez pas réserver un créneau dans le passé. Veuillez choisir une date et heure futures.'
                ], 422);
            }

            $startTime = new DateTime($request->datetime);
            $endTime = clone $startTime;
            $endTime->add(new DateInterval('PT' . $service->duration . 'M'));

                $isEmployeeAvailable = !Reservation::where('employee_id', $request->employee_id)
                ->where(function($query) use ($startTime, $endTime) {
                    $query->whereBetween('datetime', [$startTime, $endTime])
                        ->orWhereBetween('end_time', [$startTime, $endTime])
                        ->orWhere(function($q) use ($startTime, $endTime) {
                            $q->where('datetime', '<', $startTime)
                                ->where('end_time', '>', $endTime);
                        });
                })
                ->whereNotIn('status', ['cancelled', 'refused'])
                ->exists();

                if (!$isEmployeeAvailable) {
                    return back()
                        ->withInput()
                        ->with([
                            'error' => 'Empolyé est indisponible à cette heure. Veuillez choisir un autre créneau.',
                            'service_id' => $request->service_id
                        ]);
                }

            $reservation = Reservation::create([
                'client_id' => $client->id,
                'employee_id' => $request->employee_id,
                'service_id' => $request->service_id,
                'datetime' => $request->datetime,
                'end_time' => $endTime->format('Y-m-d H:i:s'),
                'status' => $request->status ?? 'pending', 
            ]);

            event(new ReservationCreated($reservation));
            
            // return redirect()->back()->with('success', 'Réservation créée avec succès.');
            return response()->json([
                'success' => true,
                'message' => 'Réservation créée avec succès'
            ]);

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

    public function editData(Reservation $reservation)
    {
        $employees = $reservation->service->employees;

        return response()->json([
            'reservation' => [
                'status' => $reservation->status,
                'notes' => $reservation->notes,
            ],
            'employees' => $employees
        ]);
    }

    public function update(UpdateReservationRequest $request, Reservation $reservation)
    {
        try {
            // if ($reservation->client_id !== auth()->id()) {
            //     abort(403, 'Accès refusé');
            // }

            $startTime = new DateTime($request->datetime);
            $endTime = clone $startTime;
            $endTime->add(new DateInterval('PT' . $reservation->service->duration . 'M'));

            $isEmployeeAvailable = !Reservation::where('employee_id', $request->employee_id)
                ->where('id', '!=', $reservation->id)
                ->where(function($query) use ($startTime, $endTime) {
                    $query->whereBetween('datetime', [$startTime, $endTime])
                        ->orWhereBetween('end_time', [$startTime, $endTime])
                        ->orWhere(function($q) use ($startTime, $endTime) {
                            $q->where('datetime', '<', $startTime)
                                ->where('end_time', '>', $endTime);
                        });
                })
                ->whereNotIn('status', ['Done', 'Refused'])
                ->exists();

            if (!$isEmployeeAvailable) {
                return back()
                    ->withInput()
                    ->with([
                        'error' => 'L\'employé est indisponible à cette heure. Veuillez choisir un autre créneau.',
                        'service_id' => $reservation->service_id
                    ]);
            }

            $reservation->update([
                'employee_id' => $request->employee_id,
                'datetime' => $startTime->format('Y-m-d H:i:s'),
                'end_time' => $endTime->format('Y-m-d H:i:s'),
            ]);

            if ($request->wantsJson()) {
                return response()->json(['success' => 'Réservation mise à jour avec succès.']);
            }

            return redirect()->route('client.reservations')->with('success', 'Réservation mise à jour avec succès.');
        } catch (Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Erreur : ' . $e->getMessage()], 500);
            }

            return redirect()->route('client.reservations')
                ->withInput()
                ->with('error', 'Erreur : ' . $e->getMessage());
        }
    }

    public function destroy(Reservation $reservation)
    {
        try {
            $reservation->update([
                'status' => 'refused'
            ]);
    
            return redirect()
                   ->route('client.reservations')
                   ->with('success', 'Réservation marquée comme refusée avec succès.');
    
        } catch (Exception $e) {
            return redirect()
                   ->back()
                   ->with('error', 'Échec du refus de la réservation : ' . $e->getMessage());
        }
    }

    public function clientReservations()
    {
        $client = Auth::user();

        $reservations = Reservation::with(['service', 'employee', 'service.employees'])
        ->where('client_id', $client->id)
        ->orderBy('datetime', 'desc')
        ->get();

        return view('clients.reservations.client_reservations', compact('reservations'));
    }

    public function adminUpdate(UpdateReservationRequest $request, Reservation $reservation)
    {
        try {
            $startTime = new DateTime($request->datetime);
            $endTime = clone $startTime;
            $endTime->add(new DateInterval('PT' . $reservation->service->duration . 'M'));

            $isEmployeeAvailable = !Reservation::where('employee_id', $request->employee_id)
                ->where('id', '!=', $reservation->id)
                ->where(function($query) use ($startTime, $endTime) {
                    $query->whereBetween('datetime', [$startTime, $endTime])
                        ->orWhereBetween('end_time', [$startTime, $endTime])
                        ->orWhere(function($q) use ($startTime, $endTime) {
                            $q->where('datetime', '<', $startTime)
                                ->where('end_time', '>', $endTime);
                        });
                })
                ->whereNotIn('status', ['Done', 'Refused'])
                ->exists();

            if (!$isEmployeeAvailable) {
                return response()->json([
                    'error' => 'L\'employé est indisponible à cette heure. Veuillez choisir un autre créneau.'
                ], 422);
            }

            $reservation->update([
                'employee_id' => $request->employee_id,
                'datetime' => $startTime,
                'end_time' => $endTime,
                'status' => $request->status,
            ]);

            return response()->json([
                'success' => 'Réservation mise à jour avec succès'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => 'Une erreur est survenue: ' . $e->getMessage()
            ], 500);
        }
    }

    public function adminStore(StoreReservationRequest $request)
    {
        try {
            $client = User::findOrFail($request->client_id);
            $service = Service::findOrFail($request->service_id);

            $startTime = new DateTime($request->datetime);
            $endTime = clone $startTime;
            $endTime->add(new DateInterval('PT' . $service->duration . 'M'));

            $isEmployeeAvailable = !Reservation::where('employee_id', $request->employee_id)
                ->where(function($query) use ($startTime, $endTime) {
                    $query->whereBetween('datetime', [$startTime, $endTime])
                        ->orWhereBetween('end_time', [$startTime, $endTime])
                        ->orWhere(function($q) use ($startTime, $endTime) {
                            $q->where('datetime', '<', $startTime)
                                ->where('end_time', '>', $endTime);
                        });
                })
                ->whereNotIn('status', ['Refused'])
                ->exists();

            if (!$isEmployeeAvailable) {
                return response()->json([
                    'message' => 'Employee not available',
                    'errors' => ['datetime' => ['L\'employé est indisponible à cette heure. Veuillez choisir un autre créneau.']]
                ], 422);
            }

            $reservation = Reservation::create([
                'client_id' => $client->id,
                'employee_id' => $request->employee_id,
                'service_id' => $service->id,
                'datetime' => $request->datetime,
                'end_time' => $endTime->format('Y-m-d H:i:s'),
                'status' => $request->status ?? 'Pending',
            ]);

            event(new ReservationCreated($reservation));

            return response()->json([
                'success' => 'Réservation créée avec succès'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => 'Une erreur est survenue: ' . $e->getMessage()
            ], 500);
        }
    }

    public function checkAvailability(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:users,id',
            'date' => 'required|date_format:Y-m-d',
            'service_id' => 'required|exists:services,id'
        ]);

        try {
            $employeeId = $request->employee_id;
            $date = $request->date;
            $service = Service::findOrFail($request->service_id);

            $startHour = 9; 
            $endHour = 16;   

            $availableSlots = [];
            
            for ($hour = $startHour; $hour < $endHour; $hour++) {
                for ($minute = 0; $minute < 60; $minute += 30) {
                    $startTime = new DateTime("$date $hour:$minute:00");
                    $endTime = clone $startTime;
                    $endTime->add(new DateInterval('PT' . $service->duration . 'M'));
                    
                    $isAvailable = !Reservation::where('employee_id', $employeeId)
                        ->where(function($query) use ($startTime, $endTime) {
                            $query->whereBetween('datetime', [$startTime, $endTime])
                                ->orWhereBetween('end_time', [$startTime, $endTime])
                                ->orWhere(function($q) use ($startTime, $endTime) {
                                    $q->where('datetime', '<', $startTime)
                                        ->where('end_time', '>', $endTime);
                                });
                        })
                        ->whereNotIn('status', ['Refused', 'Done'])
                        ->exists();
                    
                    if ($isAvailable) {
                        $availableSlots[] = sprintf('%02d:%02d', $hour, $minute);
                    }
                }
            }
            
            return response()->json([
                'available_slots' => $availableSlots,
                'message' => count($availableSlots) ? null : 'Aucun créneau disponible'
            ]);
            
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Une erreur est survenue: ' . $e->getMessage(),
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function calendar(Request $request)
    {
        $employeeId = $request->input('employee_id');
        
        $reservations = Reservation::with(['client', 'employee', 'service'])
            ->when($employeeId, function($query) use ($employeeId) {
                return $query->where('employee_id', $employeeId);
            })
            ->orderBy('datetime', 'asc')
            ->get()
            ->map(function ($reservation) {
                return [
                    'title' => 'réservation',
                    'start' => $reservation->datetime,
                    'end' => $reservation->end_time,
                    'color' => $this->getStatusColor($reservation->status),
                ];
            });

        return response()->json($reservations);
    }

    private function getStatusColor($status)
    {
        switch ($status) {
            case 'Pending': return '#FFC107'; 
            case 'Refused': return '#DC3545'; 
            case 'Done': return '#28A745'; 
            default: return '#007BFF'; 
        }
    }

        public function store2(StoreReservationRequest $request)
    {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vous devez être connecté pour effectuer une réservation'
                ], 401);
            }

            $client = Auth::user();
            $service = Service::findOrFail($request->service_id);

            // Vérification date/heure
            $selectedDateTime = new DateTime($request->datetime);
            $currentDateTime = new DateTime(); 

            if ($selectedDateTime < $currentDateTime) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vous ne pouvez pas réserver un créneau dans le passé.'
                ], 422);
            }

            // Calcul des horaires
            $startTime = new DateTime($request->datetime);
            $endTime = clone $startTime;
            $endTime->add(new DateInterval('PT' . $service->duration . 'M'));

            // Vérification disponibilité employé
            $isEmployeeAvailable = !Reservation::where('employee_id', $request->employee_id)
                ->where(function($query) use ($startTime, $endTime) {
                    $query->whereBetween('datetime', [$startTime, $endTime])
                        ->orWhereBetween('end_time', [$startTime, $endTime])
                        ->orWhere(function($q) use ($startTime, $endTime) {
                            $q->where('datetime', '<', $startTime)
                                ->where('end_time', '>', $endTime);
                        });
                })
                ->whereNotIn('status', ['cancelled', 'refused'])
                ->exists();

            if (!$isEmployeeAvailable) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cet employé est indisponible à cette heure. Veuillez choisir un autre créneau.',
                    'service_id' => $request->service_id
                ], 422);
            }

            // Création réservation
            $reservation = Reservation::create([
                'client_id' => $client->id,
                'employee_id' => $request->employee_id,
                'service_id' => $request->service_id,
                'datetime' => $request->datetime,
                'end_time' => $endTime->format('Y-m-d H:i:s'),
                'status' => $request->status ?? 'pending', 
            ]);

            event(new ReservationCreated($reservation));
            
            return response()->json([
                'success' => true,
                'message' => 'Réservation créée avec succès',
                'reservation' => $reservation
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Service non trouvé'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue: ' . $e->getMessage()
            ], 500);
        }
    }


}
