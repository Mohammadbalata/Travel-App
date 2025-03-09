<?php

namespace App\Repositories;

use App\Models\Itinerary;

class ItineraryRepository
{
    public function getAllItinerary(){
        return Itinerary::all();
    }

    public function getItineraryById($id){
        return Itinerary::findOrFail($id);
    }

    public function getUserItineraries($user){
        return $user->itineraries()->get();
    }

    public function createItinerary($data){
        return Itinerary::create($data);
    }

    public function updateItinerary($itinerary, $data){
        return $itinerary->update($data);
    }

    public function deleteItinerary($itinerary){
        return $itinerary->delete();
    }

    public function getItineraryDestinations($itinerary) {
        return $itinerary->destinations()->get();
    }
    
}