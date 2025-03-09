<?php

namespace App\Repositories;

use App\Models\Destination;

class DestinationRepository
{
    public function getAllDestinations($filters){
        return Destination::all();
    }
    
    public function getDestinationById($id){
        return Destination::findOrFail($id);
    }

    public function getDestinationReviews($destination){
        return $destination->reviews()->with('user')->get();
    }

    public function createDestination($data){
        return Destination::create($data);
    }

    public function deleteDestination($destination){
        return $destination->delete($destination);
    }
    
}