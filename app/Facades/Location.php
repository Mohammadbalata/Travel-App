<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array searchDestination(array $query)
 * 
 * @see \App\Services\ExternalApis\OpenStreetMapAdapter
 */
class Location extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'location.service';
    }
}