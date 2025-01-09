<?php

namespace App\Providers;

use App\Repositories\Eloquent\BuildingRepository;
use App\Repositories\Interfaces\BuildingRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\OrganizationRepositoryInterface;
use App\Repositories\Eloquent\OrganizationRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(OrganizationRepositoryInterface::class, OrganizationRepository::class);
        $this->app->bind(BuildingRepositoryInterface::class, BuildingRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}