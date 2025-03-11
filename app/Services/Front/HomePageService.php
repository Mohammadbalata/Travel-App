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
       
        $user = $request->user();
        $filter = request()->input('filter');

        $itineraries = [];
        $destinations = [];
        $otherUsersItineraries = $this->itineraryRepository->getOtherUsersItineraries($user);


        if (!$filter && $user) {
            $filter = $this->userRepository->getUserTravelPreferences($user);
        }

        if ($filter) {
            $destinations = $this->openStreetMapService->searchDestination($filter);
        }

        if ($user) {
            $userItineraries = $this->itineraryRepository->getUserItineraries($user);
            $collaboratedItineraries = $this->itineraryRepository->getCollaboratedItineraries($user);
            $itineraries = $userItineraries->merge($collaboratedItineraries)->unique('id');
        }
        return view('home', compact('destinations', 'itineraries', 'otherUsersItineraries'));
    }
}
