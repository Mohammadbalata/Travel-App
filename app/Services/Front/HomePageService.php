<?php

namespace App\Services\Front;

use App\Repositories\ItineraryRepository;
use App\Repositories\UserRepository;
use App\Services\ExternalApis\OpenStreetMapService;

class HomePageService
{
    public function __construct(
        protected OpenStreetMapService $openStreetMapService,
        protected ItineraryRepository $itineraryRepository,
        protected UserRepository $userRepository
    ) {}

    public function index($request)
    {
        $itineraries = [];
        $destinations = [];

        $user = $request->user();
        $filter = request()->input('filter');

       
        if (!$filter && $user) {
            $filter = $this->userRepository->getUserTravelPreferences($user);
        }
        
        if ($filter){
            $destinations = $this->openStreetMapService->searchDestination($filter);
        }

        if ($user) {
            $itineraries = $this->itineraryRepository->getUserItineraries($user);
        }
        return view('home', compact('destinations','itineraries'));
    }
}
