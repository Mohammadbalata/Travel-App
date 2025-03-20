<?php

namespace App\Contracts;

/**
 * Interface for image service
 */
interface ImageServiceInterface
{
    /**
     * Fetch images for a destination
     * 
     * @param string $query
     * @param int $perPage
     * @return array
     */
    public function fetchImages(string $query, int $perPage = 10): array;
    public function getImageUrls(array $data): array;
}
