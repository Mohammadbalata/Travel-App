<?php

namespace App\Policies;

use App\Models\Itinerary;
use App\Models\User;
use Illuminate\Auth\Access\Response;
 
class ItineraryPolicy
{
    

    public function view(User $user, Itinerary $itinerary): bool
    {
        return true;
    }
    
    public function update(User $user, Itinerary $itinerary): bool
    {
        return $user->id === $itinerary->user_id;
    }

    
    public function delete(User $user, Itinerary $itinerary): bool
    {
        return $user->id === $itinerary->user_id;
    }

    public function collaborate(User $user, Itinerary $itinerary)
    {
        return !$itinerary->collaborators()->where('user_id', $user->id)->exists();
    }

    public function leave(User $user, Itinerary $itinerary)
    {
        return $itinerary->collaborators()->where('user_id', $user->id)->exists();
    }
}
