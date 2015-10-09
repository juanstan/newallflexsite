<?php

namespace App\Providers;

use App\Models\Repositories\PetConditionRepository;
use App\Models\Repositories\PetConditionRepositoryInterface;
use App\Models\Repositories\PetReadingRepository;
use App\Models\Repositories\PetReadingRepositoryInterface;
use App\Models\Repositories\PetReadingSymptomRepository;
use App\Models\Repositories\PetReadingSymptomRepositoryInterface;
use App\Models\Repositories\PetRepository;
use App\Models\Repositories\PetRepositoryInterface;
use App\Models\Repositories\PetRequestRepository;
use App\Models\Repositories\PetRequestRepositoryInterface;
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
