<?php

namespace App\Services\ExternalApis;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherService
{
    protected $apiKey;
    protected $baseUrl = 'https://api.openweathermap.org/data/2.5/forecast';
    public function __construct()
    {
        $this->apiKey = config('services.openweathermap.api_key');
    }

    public function getForecastByCoordinates($lat, $lon)
    {
        $cacheKey = "forecast_{$lat}_{$lon}";

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $response = $this->makeRequest([
            'lat' => $lat,
            'lon' => $lon,
            'appid' => $this->apiKey,
            'units' => 'metric',
            'cnt' => 40,
        ]);

        if ($response->successful()) {
            $forecastData = $response->json();
            Cache::put($cacheKey, $forecastData, now()->addHour());
            return $forecastData;
        }

        return null;
    }

    private function makeRequest(array $params)
    {

        try {
            $response = Http::get($this->baseUrl, $params);

            if ($response) {
                return $response;
            }

            Log::error("OpenWeatherMap API error: " . $response->body());
            return ['error' => 'Failed to fetch data.'];
        } catch (\Exception $e) {
            Log::error("OpenWeatherMap API request failed: " . $e->getMessage());
            return ['error' => 'Service unavailable.'];
        }
    }
}
