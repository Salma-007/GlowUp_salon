<?php

namespace App\Listeners;

use Carbon\Carbon;
use App\Models\Service;
use App\Models\Planning;
use App\Events\ReservationCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddReservationToPlanning
{
    public function handle(ReservationCreated $event)
    {
        $reservation = $event->reservation;

        $service = Service::find($reservation->service_id);
        $duration = $service->duration; 

        $startTime = Carbon::parse($reservation->datetime);
        $endTime = $startTime->copy()->addMinutes($duration);

        Planning::create([
            'employee_id' => $reservation->employee_id,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'event_name' => 'Réservation avec ' . $reservation->client->name, 
        ]);
    }
}
