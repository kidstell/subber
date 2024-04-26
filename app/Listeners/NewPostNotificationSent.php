<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\NewPostNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewPostNotificationSent
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        if ($event->notification instanceof NewPostNotification) {
            $event->notifiable->is_sent = true;
            $event->notifiable->save();
        }
    }

}
