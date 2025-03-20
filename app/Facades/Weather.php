<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array getForecastByCoordinates(float $lat, float $lon)
 * 
 * @see \App\Services\ExternalApis\WeatherServiceAdapter
 */
class Weather extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'weather.service';
    }
}
