<?php

namespace App\Services\Front;

use App\Adapters\OpenStreetMapAdapter;
use App\Adapters\UnsplashAdapter;
use App\Models\Destination;
use App\Repositories\DestinationRepository;
use App\Services\ExternalApis\OpenStreetMapService;
use App\Services\ExternalApis\UnsplashService;

class DestinationService
{
    public function __construct(
        protected UnsplashAdapter $unsplashAdapter,
        protected UnsplashService $unsplashService,
        protected OpenStreetMapService $openStreetMapService,
        protected OpenStreetMapAdapter $openStreetMapAdapter,
        protected DestinationRepository $destinationRepository,
    ) {}
    public function show($id)
    {
        $destinationResponse = $this->openStreetMapService->getDestinationDetails($id);
        $destination = $this->openStreetMapAdapter->getFormattedDestinationDetails($destinationResponse);

        $destinationImagesResponse = $this->unsplashService->fetchDestinationImages($destination['en_name']);
        $destinationImages = $this->unsplashAdapter->getImageUrls($destinationImagesResponse);

        return view('Front.destination.show', compact('destination', 'destinationImages'));
    }

    public function store($request){
        $destination = $this->destinationRepository->createDestination($request->all());
        return redirect()->route('home')->with('success', 'Destination added successfully');
    }
}
