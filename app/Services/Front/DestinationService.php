<?php

namespace App\Services\Front;

use App\Facades\Images;
use App\Facades\Weather;
use App\Repositories\DestinationRepository;
use App\Services\ExternalApis\WeatherServiceAdapter;

class DestinationService
{
    public function __construct(
        protected DestinationRepository $destinationRepository,
        protected WeatherServiceAdapter $weatherService,
    ) {}
    public function show($destination)
    {
        $forecastData = Weather::getForecastByCoordinates($destination->lat,$destination->lng);
        
        $destinationImages = Images::fetchImages($destination->name);
        
        return view('Front.destination.show', compact('destination', 'destinationImages','forecastData'));
    }

    public function store($request){
        $destination = $this->destinationRepository->createDestination($request->all());
        return redirect()->route('home')->with('success', 'Destination added successfully');
    }

    public function destroy($destination){
        $this->destinationRepository->deleteDestination($destination);
        return redirect()->route('itineraries.show',$destination->itinerary_id)->with('success', 'Destination Deleted successfully');
    }
}
