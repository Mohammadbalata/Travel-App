<?php

namespace App\Adapters;

use App\Services\ExternalApis\OpenStreetMapService;

class OpenStreetMapAdapter
{

    public function __construct(protected OpenStreetMapService $openStreetMapService)
    {
    }

    public function getFormattedDestinationDetails($data): array
    {

        if (empty($data)) {
            return [];
        }
        return [
            'id' => $data['place_id'] ?? null,
            'name' => $data['localname'] ?? null,
            'en_name' => $data['names']['name:en'] ?? "",
            'lat' =>  $data['geometry']['coordinates'][0] ?? null,
            'lng' => $data['geometry']['coordinates'][1]?? null,
        ];
    }
}
