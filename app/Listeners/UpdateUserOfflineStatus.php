<?php

namespace App\Listeners;

use App\Events\UserOnlineStatusChanged;
use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateUserOfflineStatus
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
    public function handle(Logout $event): void
    {
        $user = $event->user;
        if ($user){
            $user->is_online = false;
            $user->save();

            broadcast(new UserOnlineStatusChanged($user->id, false));
        }
    }
}
