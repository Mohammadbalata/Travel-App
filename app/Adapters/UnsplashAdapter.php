<?php
namespace App\Adapters;

use App\Services\UnsplashService;

class UnsplashAdapter
{
    protected UnsplashService $unsplashService;

    public function __construct(UnsplashService $unsplashService)
    {
        $this->unsplashService = $unsplashService;
    }

    public function getImageUrls(string $query, int $count = 10): array
    {
        $response = $this->unsplashService->fetchDestinationImages($query, $count);
        if (!isset($response['results'])) {
            return [];
        }
        return array_map(fn($image) => $image['urls']['regular'], $response['results']);
    }
}
