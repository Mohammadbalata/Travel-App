<?php

namespace App\Services;

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

    public function fetchDestinationImages(string $query, int $perPage = 10)
    {
        return $this->makeRequest([
            'query' => $query,
            'per_page' => $perPage,
            'orientation' => 'landscape',
        ]);
    }

    private function makeRequest(array $params)
    {
        $params['client_id'] = $this->apiKey;
        
        try {
            $response = Http::get($this->baseUrl, $params);
            
            if ($response->successful()) {
                return $response->json();
            }

            Log::error("Unsplash API error: " . $response->body());
            return ['error' => 'Failed to fetch images.'];
        } catch (\Exception $e) {
            Log::error("Unsplash API request failed: " . $e->getMessage());
            return ['error' => 'Service unavailable.'];
        }
    }
    
}
