<?php

namespace App\Providers;

use App\Events\ReservationCreated;
use Illuminate\Support\ServiceProvider;
use App\Listeners\AddReservationToPlanning;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'ReservationCreated' => [
            'AddReservationToPlanning',
        ],
    ];
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
