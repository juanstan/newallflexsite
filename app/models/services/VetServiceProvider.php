<?php namespace Services;

use Illuminate\Support\ServiceProvider;

class VetServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->app->bind('Repositories\VetRepositoryInterface', 'Repositories\VetRepository');
    }
}