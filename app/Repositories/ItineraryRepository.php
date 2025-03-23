<?php

namespace App\Repositories;

use App\Models\Itinerary;

class ItineraryRepository
{
    public function getAllItinerary()
    {
        return Itinerary::all();
    }

    public function getItineraryById($id)
    {
        return Itinerary::findOrFail($id);
    }

    public function getUserItineraries($user)
    {
        return Itinerary::where('user_id', $user->id)->get();
    }

    public function getCollaboratedItineraries($user){
        return Itinerary::WhereHas('collaborators', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();
    }

    public function createItinerary($data)
    {
        return Itinerary::create($data);
    }

    public function updateItinerary($itinerary, $data)
    {
        return $itinerary->update($data);
    }

    public function deleteItinerary($itinerary)
    {
        return $itinerary->delete();
    }

    public function getItineraryDestinations($itinerary)
    {
        return $itinerary->destinations()->get();
    }

    public function getOtherUsersItineraries($user)
    {
        if (!$user) {
            return Itinerary::all();
        }
        return Itinerary::where('user_id', '!=', $user->id)->whereDoesntHave('collaborators', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();
    }
}
