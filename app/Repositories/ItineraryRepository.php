<?php

namespace App\Repositories;

use App\Models\Itinerary;

class ItineraryRepository
{
    public function getAllItinerary(){
        return Itinerary::all();
    }
    
}