<?php

namespace App\Services\ExternalApis;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenStreetMapService
{
    protected string $baseURL = 'https://nominatim.openstreetmap.org/';
    protected array $headers = [
        'User-Agent' => 'MyLaravelApp/1.0 (contact@example.com)'
    ];

    public function searchDestination($query = ''): array
    {
        return $this->makeRequest('search', ['q' => $query]);
    }

    public function getDestinationDetails($placeId): array
    {
        return $this->makeRequest('details', ['place_id' => $placeId]);
    }

    protected function makeRequest(string $endpoint, array $params): array
    {
        try {
            $params['format'] = 'json';
            $response = Http::withHeaders($this->headers)->get("{$this->baseURL}{$endpoint}", $params);
            if ($response->successful()) {
                return $response->json();
            }
            Log::error("API Request Failed", [
                'endpoint' => $endpoint,
                'params' => $params,
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return [
                'error' => true,
                'message' => "API request failed with status: " . $response->status(),
            ];
        } catch (\Exception $e) {

            Log::error("API Request Exception", [
                'endpoint' => $endpoint,
                'params' => $params,
                'exception' => $e->getMessage(),
            ]);

            return [
                'error' => true,
                'message' => "An error occurred: " . $e->getMessage(),
            ];
        }
    }
}
