<?php

namespace App\Services\ExternalApis;

use App\Contracts\ExternalApiAdapterInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Base adapter for external APIs
 */
abstract class BaseApiAdapter implements ExternalApiAdapterInterface
{
    protected string $baseUrl;
    protected array $headers = [];
    protected ?string $apiKey = null;
    protected int $cacheTime = 60; // minutes

    /**
     * Make a request to the external API
     * 
     * @param string $endpoint
     * @param array $params
     * @return array
     */
    public function makeRequest(string $endpoint, array $params): array
    {
        try {
            $url = $this->getFullUrl($endpoint);

            $response = Http::withHeaders($this->headers)->get($url, $params);


            if ($response->successful()) {
                return $response->json();
            }

            Log::error("API Request Failed", [
                'service' => static::class,
                'endpoint' => $endpoint,
                'params' => $params,
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return [
                'success' => false,
                'error' => "API request failed with status: " . $response->status(),
                'status' => $response->status()
            ];
        } catch (\Exception $e) {
            Log::error("API Request Exception", [
                'service' => static::class,
                'endpoint' => $endpoint,
                'params' => $params,
                'exception' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => "An error occurred: " . $e->getMessage(),
                'status' => 500
            ];
        }
    }

    /**
     * Get the full URL for the endpoint
     * 
     * @param string $endpoint
     * @return string
     */
    protected function getFullUrl(string $endpoint): string
    {
        return rtrim($this->baseUrl, '/') . '/' . ltrim($endpoint, '/');
    }
}
