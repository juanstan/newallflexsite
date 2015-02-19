<?php namespace Services;

use Illuminate\Support\ServiceProvider;

class AnimalConditionServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->app->bind('Repositories\AnimalConditionRepositoryInterface', 'Repositories\AnimalConditionRepository');
    }
}