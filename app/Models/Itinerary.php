<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Itinerary extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'start_date',
        'end_date',
        'note',
        'budget'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];


    public function collaborators()
    {
        return $this->belongsToMany(User::class, 'user_itinerary')
        ->using(UserItinerary::class);
    }



    public function getDurationAttribute()
    {
        return $this->start_date->diffInDays($this->end_date);
    }

    public function getCreatorAttribute()
    {
        $user =  User::findOrFail($this->user_id);
        return $user->name;
    }

    public function destinations(){
        return $this->hasMany(Destination::class);
    }
}
