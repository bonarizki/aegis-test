<?php

namespace App\Listeners;

use App\Events\UserNotificationEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class UserNotificationListener
{

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     */
    public function handle(UserNotificationEvent $event): void
    {
        // Assign the user object from the event to the $data variable.
        $data = $event->user;

        // Log 
        Log::info("welcome $data->name");
    }
}
