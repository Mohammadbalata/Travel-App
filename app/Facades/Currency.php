<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array getLatestRates()
 * 
 * @see \App\Services\ExternalApis\CurrencyServiceAdapter
 */
class Currency extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'currency.service';
    }
}