<?php

namespace App\Contracts;

/**
 * Interface for location service
 */
interface LocationServiceInterface
{
    /**
     * Search for a destination
     * 
     * @param array $query
     * @return array
     */
    public function searchDestination(array $query): array;
}
