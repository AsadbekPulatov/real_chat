<?php

namespace App\Listeners;

use App\Events\UserOnlineStatusChanged;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateUserOnlineStatus
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
    public function handle(Authenticated $event): void
    {
        $user = $event->user;
        $user->is_online = true;
        $user->save();

        broadcast(new UserOnlineStatusChanged($user->id, true));
    }
}
