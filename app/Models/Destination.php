<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'lat',
        'lng',
        'itinerary_id',
    ];

    public function itinerary(){
        return $this->belongsTo(Itinerary::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }


    public function getRateAvgAttribute(){
        $avg = $this->reviews()->avg('rating') ?? 0;
        return round($avg); 
    }
}
