<?php

namespace App\Listeners;

use App\Events\ItineraryCollaborated;
use App\Models\User;
use App\Notifications\ItineraryCollaboratedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendItineraryCollaboratedNotification
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
    public function handle(ItineraryCollaborated $event): void
    {
        $itinerary = $event->itinerary;
        $user = User::findOrFail($itinerary->user_id);
        $user->notify(new ItineraryCollaboratedNotification());
    }
}
