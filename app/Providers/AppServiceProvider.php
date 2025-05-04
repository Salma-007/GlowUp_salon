<?php

namespace App\Providers;

use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Gate;
use App\Repositories\ServiceRepository;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\AuthRepositoryInterface;
use App\Interfaces\ServiceRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(ServiceRepositoryInterface::class, ServiceRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('admin', function ($user) {
            return $user->role === 'admin';
        });
    }
}
