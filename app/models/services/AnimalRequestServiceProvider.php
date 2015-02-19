<?php namespace Services;

use Illuminate\Support\ServiceProvider;

class AnimalRequestServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->app->bind('Repositories\AnimalRequestRepositoryInterface', 'Repositories\AnimalRequestRepository');
    }
}