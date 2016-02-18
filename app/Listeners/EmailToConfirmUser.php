<?php

namespace App\Listeners;

use App\Events\ANewUserWasAdded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Mail\Mailer;

class EmailToConfirmUser
{

    public $mailer;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Handle the event.
     *
     * @param  ANewUserWasAdded  $event
     * @return void
     */
    public function handle(ANewUserWasAdded $event)
    {
        $this->mailer->send('emails.user-verify',
            array(
                'confirmation_code' => $event->user->confirmation_code
            ),
            function ($message) use ($event) {
                $message->to($event->user->email)->subject('Validate your account in All Flex');
            }
        );

    }
}
