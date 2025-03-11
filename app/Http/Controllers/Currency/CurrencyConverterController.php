<?php

namespace App\Http\Controllers\Currency;

use App\Http\Controllers\Controller;
use App\Services\ExternalApis\CurrencyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class CurrencyConverterController extends Controller
{
    public function __construct(protected CurrencyService $currencyService) {}


    public function store(Request $request)
    {
        $request->validate([
            'currency_code' => 'required|string|size:3',
        ]);

        $currencyCode = $request->input('currency_code');
        Session::put('currency_code', $currencyCode);

        
        $rate = Cache::get('currency_rate');
        if(!$rate){
            $rate = $this->currencyService->getLatestRates();
            Cache::put('currency_rate', $rate['rates'], now()->addMinutes(60));
        }


        return redirect()->back();
    }

}
