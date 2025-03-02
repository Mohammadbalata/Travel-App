<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;


    public function reviews()
    {
        return $this->hasMany(Review::class);
    }


    public function scopeFilter(Builder $builder, $filters = '')
    {
        if ($filters) {
            $builder->where(function ($query) use ($filters) {
                $query->where('name', 'LIKE', "%{$filters}%")
                    ->orWhere('region', 'LIKE', "%{$filters}%")
                    ->orWhereRaw('JSON_SEARCH(interests, "one", ?)', "%{$filters}%");
            });
        }
        return $builder;
    }

    public function getRateAvgAttribute(){
        $avg = $this->reviews()->avg('rating') ?? 0;
        return round($avg); 
    }
}
