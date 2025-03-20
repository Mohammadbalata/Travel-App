<?php

namespace App\Providers;

use App\Contracts\CurrencyServiceInterface;
use App\Contracts\ImageServiceInterface;
use App\Contracts\LocationServiceInterface;
use App\Contracts\WeatherServiceInterface;
use App\Services\ExternalApis\CurrencyServiceAdapter;
use App\Services\ExternalApis\OpenStreetMapAdapter;
use App\Services\ExternalApis\UnsplashAdapter;
use App\Services\ExternalApis\WeatherServiceAdapter;
use Illuminate\Support\ServiceProvider;

class ExternalApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Register API adapters
        $this->app->bind(WeatherServiceInterface::class, WeatherServiceAdapter::class);
        $this->app->bind(CurrencyServiceInterface::class, CurrencyServiceAdapter::class);
        $this->app->bind(LocationServiceInterface::class, OpenStreetMapAdapter::class);
        $this->app->bind(ImageServiceInterface::class, UnsplashAdapter::class);

        // Register facades
        $this->app->bind('weather.service', function ($app) {
            return $app->make(WeatherServiceInterface::class);
        });

        $this->app->bind('currency.service', function ($app) {
            return $app->make(CurrencyServiceInterface::class);
        });

        $this->app->bind('location.service', function ($app) {
            return $app->make(LocationServiceInterface::class);
        });

        $this->app->bind('images.service', function ($app) {
            return $app->make(ImageServiceInterface::class);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}