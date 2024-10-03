<?php

namespace App\Providers;

use App\Repositories\PositionRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\PositionRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PositionRepositoryInterface::class, PositionRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
