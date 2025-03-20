<?php

namespace App\Services\ExternalApis;

use App\Contracts\CurrencyServiceInterface;

class CurrencyServiceAdapter extends BaseApiAdapter implements CurrencyServiceInterface
{
    protected string $baseUrl = 'https://api.exchangeratesapi.io/v1';

    public function __construct()
    {
        $this->apiKey = config('services.exchangerates.api_key');
    }

    /**
     * Get latest exchange rates
     * 
     * @return array
     */
    public function getLatestRates(): array
    {
        $params = [
            'access_key' => $this->apiKey,
        ];

        return $this->makeRequest('latest', $params);
    }
}