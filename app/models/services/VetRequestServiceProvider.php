<?php namespace Services;

use Illuminate\Support\ServiceProvider;

class VetRequestServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->app->bind('Repositories\VetRequestRepositoryInterface', 'Repositories\VetRequestRepository');
    }
}