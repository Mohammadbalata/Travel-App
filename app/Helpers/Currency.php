<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use NumberFormatter;

class Currency
{
    public function __invoke(...$params)
    {
        return static::format(...$params);
    }

    public static function format($amount, $toCurrency = null)
    {
        $baseCurrency = config('app.currency', 'EUR');

        if ($toCurrency === null) {
            $toCurrency = Session::get('currency_code', $baseCurrency);
        }

        $rates = Cache::get('currency_rate', []);
        if ($toCurrency !== $baseCurrency && isset($rates[$toCurrency])) {
            $amount *= $rates[$toCurrency];
        }

        $formatter = new NumberFormatter(config('app.locale'), NumberFormatter::CURRENCY);
        return $formatter->formatCurrency($amount, $toCurrency);
    }
}
