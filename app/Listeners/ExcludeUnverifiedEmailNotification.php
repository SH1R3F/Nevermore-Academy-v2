<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Events\NotificationSending;

class ExcludeUnverifiedEmailNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(NotificationSending $event)
    {
        // Notification won't be sent if it's a mail notificaion to a user that hasn't verify his email EXCEPT if it's a verification notification
        if ($event->channel === 'mail' && !$event->notifiable->hasVerifiedEmail() && !$event->notification instanceof VerifyEmail) return false;

        return true;
    }
}
