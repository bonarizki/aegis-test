<?php

namespace App\Listeners;

use App\Events\AdminNotificationEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class AdminNotificationListener implements ShouldQueue
{

    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    public $queue = 'admin';

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
    public function handle(AdminNotificationEvent $event): void
    {
        // Assign the user object from the event to the $data variable.
        $data = $event->user;

        Log::info("hi admin theres new user registrastion, name : $data->name - via queue admin");

    }
}
