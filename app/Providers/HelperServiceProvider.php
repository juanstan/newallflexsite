<?php

namespace App\Providers;

use App\Models\Repositories\AnimalConditionRepository;
use App\Models\Repositories\AnimalConditionRepositoryInterface;
use App\Models\Repositories\AnimalReadingRepository;
use App\Models\Repositories\AnimalReadingRepositoryInterface;
use App\Models\Repositories\AnimalReadingSymptomRepository;
use App\Models\Repositories\AnimalReadingSymptomRepositoryInterface;
use App\Models\Repositories\AnimalRepository;
use App\Models\Repositories\AnimalRepositoryInterface;
use App\Models\Repositories\AnimalRequestRepository;
use App\Models\Repositories\AnimalRequestRepositoryInterface;
use App\Models\Repositories\DeviceRepository;
use App\Models\Repositories\DeviceRepositoryInterface;
use App\Models\Repositories\HelpRepository;
use App\Models\Repositories\HelpRepositoryInterface;
use App\Models\Repositories\UserRepository;
use App\Models\Repositories\UserRepositoryInterface;
use App\Models\Repositories\VetRepository;
use App\Models\Repositories\VetRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        foreach (glob(app_path().'/Helpers/*.php') as $filename){
            require_once($filename);
        }
    }

}
