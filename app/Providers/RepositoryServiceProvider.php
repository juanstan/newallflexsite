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

class RepositoryServiceProvider extends ServiceProvider
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
        $this->app->bind(AnimalConditionRepositoryInterface::class, AnimalConditionRepository::class);
        $this->app->bind(AnimalReadingRepositoryInterface::class, AnimalReadingRepository::class);
        $this->app->bind(AnimalReadingSymptomRepositoryInterface::class, AnimalReadingSymptomRepository::class);
        $this->app->bind(AnimalRepositoryInterface::class, AnimalRepository::class);
        $this->app->bind(AnimalRequestRepositoryInterface::class, AnimalRequestRepository::class);
        $this->app->bind(DeviceRepositoryInterface::class, DeviceRepository::class);
        $this->app->bind(HelpRepositoryInterface::class, HelpRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(VetRepositoryInterface::class, VetRepository::class);
    }
}
