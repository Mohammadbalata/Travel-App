<?php

namespace App\Services\ExternalApis;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class CurrencyService
{
    protected $apiKey;
    protected $baseUrl = 'https://api.exchangeratesapi.io/v1/latest';

    public function __construct()
    {
        $this->apiKey = config('services.exchangerates.api_key');
    }

    public function getLatestRates(){
        $response = Http::get($this->baseUrl,[
            'access_key' => $this->apiKey,
        ]);
        if($response->successful()){
            return $response->json();
        }
        
        return null;
    }
    
}
