<?php

namespace App\Contracts;

/**
 * Interface for currency service
 */
interface CurrencyServiceInterface
{
    /**
     * Get latest exchange rates
     * 
     * @return array
     */
    public function getLatestRates(): array;
}