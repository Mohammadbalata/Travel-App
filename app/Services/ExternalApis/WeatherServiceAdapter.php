<?php

namespace App\Services\ExternalApis;

use App\Contracts\WeatherServiceInterface;
use Illuminate\Support\Facades\Cache;

class WeatherServiceAdapter extends BaseApiAdapter implements WeatherServiceInterface
{
    protected string $baseUrl = 'https://api.openweathermap.org/data/2.5';

    public function __construct()
    {
        $this->apiKey = config('services.openweathermap.api_key');
    }

    /**
     * Get forecast by coordinates
     * 
     * @param float $lat
     * @param float $lon
     * @return array
     */
    public function getForecastByCoordinates(float $lat, float $lon): array
    {
        $cacheKey = "forecast_{$lat}_{$lon}";

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $params = [
            'lat' => $lat,
            'lon' => $lon,
            'appid' => $this->apiKey,
            'units' => 'metric',
            'cnt' => 40,
        ];

        $response = $this->makeRequest('forecast', $params);

        if ($response) {
            Cache::put($cacheKey, $response, now()->addMinutes($this->cacheTime));
        }

        return $response;
    }
}