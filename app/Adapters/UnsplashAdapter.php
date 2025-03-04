<?php
namespace App\Adapters;

use App\Services\ExternalApis\UnsplashService;

class UnsplashAdapter
{

    public function __construct(protected UnsplashService $unsplashService)
    {
    }

    public function getImageUrls($data): array
    {
        
        if (!isset($data['results'])) {
            return [];
        }
        return array_map(fn($image) => $image['urls']['regular'], $data['results']);
    }
}
