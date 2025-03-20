<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array fetchImages(string $query, int $perPage = 10)
 * @method static array getImageUrls(array $data)
 * 
 * @see \App\Services\ExternalApis\UnsplashAdapter
 */
class Images extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'images.service';
    }
}