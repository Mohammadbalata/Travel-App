<?php

namespace App\Services\ExternalApis;

use App\Contracts\ImageServiceInterface;
use Illuminate\Support\Facades\Cache;

class UnsplashAdapter extends BaseApiAdapter implements ImageServiceInterface
{
    protected string $baseUrl = 'https://api.unsplash.com';

    public function __construct()
    {
        $this->apiKey = config('services.unsplash.api_key');
    }

    /**
     * Fetch images for a destination
     * 
     * @param string $query
     * @param int $perPage
     * @return array
     */
    public function fetchImages(string $query, int $perPage = 10): array
    {
        $cacheKey = "unsplash_images_{$query}_{$perPage}";

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $params = [
            'client_id' => $this->apiKey,
            'query' => $query,
            'per_page' => $perPage,
            'orientation' => 'landscape',
        ];

        $response = $this->makeRequest('search/photos', $params);

        $imageUrls = $this->getImageUrls($response);

        if (!empty($imageUrls)) {
            Cache::put($cacheKey, $imageUrls, now()->addMinutes(60));
        }

        return $imageUrls;
    }


    public function getImageUrls($data): array
    {
        if (!isset($data['results'])) {
            return [];
        }
        return array_map(fn($image) => $image['urls']['regular'], $data['results']);
    }
}
