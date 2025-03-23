<?php

namespace App\Events;

use App\Models\Itinerary;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ItineraryCollaborated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $itinerary;
    private $user_id;
    /**
     * Create a new event instance.
     */
    public function __construct(Itinerary $itinerary)
    {
        $this->itinerary = $itinerary;
        $this->user_id = $itinerary->user_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("user-collaborate-channel." . $this->user_id),
        ];
    }

    public function broadcastAs()
    {
        return 'user-collaborate-event';
    }

    public function broadcastWith()
    {

        return [
            'body' => 'A new collaborator has been added to your itinerary.',
            'url' => url('/itineraries') . '/'  . $this->itinerary->id,
        ];
    }
}
