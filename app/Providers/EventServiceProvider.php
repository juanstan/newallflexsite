<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Models\Entities\User;
use App\Models\Entities\Pet;
use App\Models\Entities\Reading;
use Carbon\Carbon;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\SomeEvent' => [
            'App\Listeners\EventListener',
        ],
        'App\Events\ANewVetWasAdded' => [
            'App\Listeners\EmailToConfirmVet',
        ],
        'App\Events\ANewUserWasAdded' => [
            'App\Listeners\EmailToConfirmUser',
        ]
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        User::deleting(function($user)
        {
            //On this way to call the deleting event
            foreach ($user->pets()->get() as $pet) {
                $pet->delete();
            }

            $user->device()->delete();

        });

        Reading::deleting(function($reading){
            $reading->symptoms()->detach();

        });

        Pet::deleting(function($pet){
            foreach ($pet->vet()->get() as $vet) {
                $vet->pets()->updateExistingPivot($pet->id, array('deleted_at'=>Carbon::now()));
            }
            $pet->conditions()->detach();
            foreach ($pet->readings()->get() as $reading) {
                $reading->delete();
            }

        });

    }
}
