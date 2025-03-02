<?php

namespace App\Services;

use App\Adapters\UnsplashAdapter;
use App\Repositories\DestinationRepository;

class DestinationService
{
    public function __construct(
        protected UnsplashAdapter $unsplashAdapter,
        protected DestinationRepository $destinationRepository
    ) {
        $this->unsplashAdapter = $unsplashAdapter;
        $this->destinationRepository = $destinationRepository;
    }
    public function showDestination($destination)
    {
        $reviews = $this->destinationRepository->getDestinationReviews($destination);
        $destinationImages = $this->unsplashAdapter->getImageUrls($destination->name);

        return view('Front.destination.show', compact('destination', 'destinationImages', 'reviews'));
    }
}
