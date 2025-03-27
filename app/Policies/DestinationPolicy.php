<?php

namespace App\Policies;

use App\Models\Destination;
use App\Models\Itinerary;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Log;

class DestinationPolicy
{
    
    public function add(User $user, Destination $destination,Itinerary $itinerary)
    {
        return $user->id === $itinerary->user_id ||
           $itinerary->collaborators()->where('user_id', $user->id)->exists();
    }
    public function delete(User $user, Destination $destination)
    {
        $itinerary = $destination->itinerary;
        return $user->id === $itinerary->user_id ||
            $itinerary->collaborators()->where('user_id', $user->id)->exists();
    }

   
}
