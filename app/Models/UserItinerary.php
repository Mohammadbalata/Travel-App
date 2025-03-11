<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserItinerary extends Pivot
{
    protected $table = 'user_itinerary';
    public $timestamps = false;
    
    
}
