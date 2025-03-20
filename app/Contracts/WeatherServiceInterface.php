<?php

namespace App\Contracts;

/**
 * Interface for weather service
 */
interface WeatherServiceInterface
{
    /**
     * Get forecast by coordinates
     * 
     * @param float $lat
     * @param float $lon
     * @return array
     */
    public function getForecastByCoordinates(float $lat, float $lon): array;
}