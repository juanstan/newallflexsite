<?php namespace Services;

use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->app->bind('Repositories\UserRepositoryInterface', 'Repositories\UserRepository');
    }
}