<?php

namespace App\Services\ExternalApis;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UnsplashService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://api.unsplash.com/search/photos';

    public function __construct()
    {
        $this->apiKey = config('services.unsplash.api_key');
    }

    public function fetchDestinationImages($query, int $perPage = 10)
    {
        $cacheKey = "forecast_{$query}";

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }
        $response = $this->makeRequest([
            'query' => $query,
            'per_page' => $perPage,
            'orientation' => 'landscape',
        ]);

        if ($response->successful()) {
            $images = $response->json();
            Cache::put($cacheKey, $images, now()->addHour());
            return $images;
        }
    }

    private function makeRequest(array $params)
    {
        $params['client_id'] = $this->apiKey;

        try {
            $response = Http::get($this->baseUrl, $params);

            if ($response) {
                return $response;
            }

            Log::error("Unsplash API error: " . $response->body());
            return ['error' => 'Failed to fetch images.'];
        } catch (\Exception $e) {
            Log::error("Unsplash API request failed: " . $e->getMessage());
            return ['error' => 'Service unavailable.'];
        }
    }
}
