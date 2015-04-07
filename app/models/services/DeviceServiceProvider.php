<?php namespace Services;

use Illuminate\Support\ServiceProvider;

class DeviceServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->app->bind('Repositories\DeviceRepositoryInterface', 'Repositories\DeviceRepository');
    }
}