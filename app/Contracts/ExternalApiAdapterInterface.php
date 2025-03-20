<?php

namespace App\Contracts;

/**
 * Interface for all external API services
 */
interface ExternalApiAdapterInterface
{
    /**
     * Make a request to the external API
     * 
     * @param string $endpoint
     * @param array $params
     * @return array
     */
    public function makeRequest(string $endpoint, array $params): array;
}
