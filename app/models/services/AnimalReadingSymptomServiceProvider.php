<?php namespace Services;

use Illuminate\Support\ServiceProvider;

class AnimalReadingSymptomServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->app->bind('Repositories\AnimalReadingSymptomRepositoryInterface', 'Repositories\AnimalReadingSymptomRepository');
    }
}