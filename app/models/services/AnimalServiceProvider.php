<?php namespace Services;

use Illuminate\Support\ServiceProvider;

class AnimalServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->app->bind('Repositories\AnimalRepositoryInterface', 'Repositories\AnimalRepository');
    }
}