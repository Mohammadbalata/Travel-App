<?php

namespace App\Services\Front;

use App\Adapters\OpenStreetMapAdapter;
use App\Adapters\UnsplashAdapter;
use App\Models\Destination;
use App\Repositories\DestinationRepository;
use App\Services\ExternalApis\OpenStreetMapService;
use App\Services\ExternalApis\UnsplashService;
use App\Services\ExternalApis\WeatherService;
use Illuminate\Support\Facades\Auth;

class DestinationService
{
    public function __construct(
        protected UnsplashAdapter $unsplashAdapter,
        protected UnsplashService $unsplashService,
        protected DestinationRepository $destinationRepository,
        protected WeatherService $weatherService,
    ) {}
    public function show($destination)
    {
        $forecastData = $this->weatherService->getForecastByCoordinates($destination->lat,$destination->lng);
        $destinationImagesResponse = $this->unsplashService->fetchDestinationImages($destination->name);
        $destinationImages = $this->unsplashAdapter->getImageUrls($destinationImagesResponse);

        return view('Front.destination.show', compact('destination', 'destinationImages','forecastData'));
    }

    public function store($request){
        $destination = $this->destinationRepository->createDestination($request->all());
        return redirect()->route('home')->with('success', 'Destination added successfully');
    }

    public function destroy($destination){
        $d = $this->destinationRepository->deleteDestination($destination);
        return redirect()->route('itineraries.show',$destination->itinerary_id)->with('success', 'Destination Deleted successfully');
    }
}
