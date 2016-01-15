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
use App\Models\Repositories\ReadingRepository;
use App\Models\Repositories\ReadingRepositoryInterface;
use App\Models\Repositories\PhotoRepository;
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
        $this->app->bind(PetConditionRepositoryInterface::class, PetConditionRepository::class);
        $this->app->bind(PetReadingRepositoryInterface::class, PetReadingRepository::class);
        $this->app->bind(PetReadingSymptomRepositoryInterface::class, PetReadingSymptomRepository::class);
        $this->app->bind(PetRepositoryInterface::class, PetRepository::class);
        $this->app->bind(PetRequestRepositoryInterface::class, PetRequestRepository::class);
        $this->app->bind(DeviceRepositoryInterface::class, DeviceRepository::class);
        $this->app->bind(HelpRepositoryInterface::class, HelpRepository::class);
        $this->app->bind(PhotoRepositoryInterface::class, PhotoRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(VetRepositoryInterface::class, VetRepository::class);
        $this->app->bind(ReadingRepositoryInterface::class, ReadingRepository::class);
    }
}
