<?php

namespace App\Services\Front;

use App\Facades\Images;
use App\Facades\Weather;
use App\Models\Destination;
use App\Models\Itinerary;
use App\Repositories\DestinationRepository;
use App\Services\ExternalApis\WeatherServiceAdapter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class DestinationService
{
    public function __construct(
        protected DestinationRepository $destinationRepository,
        protected WeatherServiceAdapter $weatherService,
    ) {}
    public function show($destination)
    {
        $forecastData = Weather::getForecastByCoordinates($destination->lat, $destination->lng);

        $destinationImages = Images::fetchImages($destination->name);

        return view('Front.destination.show', compact('destination', 'destinationImages', 'forecastData'));
    }

    public function store($request)
    {
        $itinerary  = Itinerary::findOrFail($request->itinerary_id);
        Gate::authorize('add',[new Destination(),$itinerary]);

        $destination = $this->destinationRepository->createDestination($request->all());
        return redirect()->route('home')->with('success', 'Destination added successfully');
    }

    public function destroy($destination)
    {
        
        Gate::authorize('delete',$destination);

        $this->destinationRepository->deleteDestination($destination);
        return redirect()->route('itineraries.show', $destination->itinerary_id)->with('success', 'Destination Deleted successfully');
    }
}
