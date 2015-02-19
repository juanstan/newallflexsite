<?php namespace Services;

use Illuminate\Support\ServiceProvider;

class AnimalReadingServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->app->bind('Repositories\AnimalReadingRepositoryInterface', 'Repositories\AnimalReadingRepository');
    }
}