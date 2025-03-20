<?php

namespace App\Services\ExternalApis;

use App\Constants\Lists;
use App\Contracts\LocationServiceInterface;
use Illuminate\Support\Arr;

class OpenStreetMapAdapter extends BaseApiAdapter implements LocationServiceInterface
{
    protected string $baseUrl = 'https://nominatim.openstreetmap.org';
    
    public function __construct()
    {
        $this->headers = [
            'User-Agent' => 'MyLaravelApp/1.0 (contact@example.com)'
        ];
    }

    /**
     * Search for a destination
     * 
     * @param array $query
     * @return array
     */
    public function searchDestination(array $query): array
    {
        $place = $query['place'] ?? Arr::random(Lists::RANDOM_CITIES);
        $interest = $query['interest'] ?? '';
        $searchQuery = $place;

        if ($interest) {
            $searchQuery = "$interest in $place";
        }

        $params = [
            'q' => $searchQuery,
            'format' => 'json'
        ];

        return $this->makeRequest('search', $params);
    }
}