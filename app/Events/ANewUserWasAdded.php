<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\Entities\User;

class ANewUserWasAdded extends Event
{
    use SerializesModels;

    public $email;
    public $user;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, $email)
    {

        $this->email = $email;
        $this->user = $user;



    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
