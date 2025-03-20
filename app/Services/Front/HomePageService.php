<?php

namespace App\Services\Front;

use App\Facades\Location;
use App\Repositories\ItineraryRepository;
use App\Repositories\UserRepository;

class HomePageService
{
    public function __construct(
        protected ItineraryRepository $itineraryRepository,
        protected UserRepository $userRepository
    ) {}

    public function index($request)
    {
        $user = $request->user();
        $filters = request()->only(['place', 'interest']);
        
        $itineraries = [];
        $destinations = [];
        $otherUsersItineraries = $this->itineraryRepository->getOtherUsersItineraries($user);


        if (!$filters && $user) {
            $filters['interest'] = $this->userRepository->getUserTravelPreferences($user);
        }

        if ($user) {
            $userItineraries = $this->itineraryRepository->getUserItineraries($user);
            $collaboratedItineraries = $this->itineraryRepository->getCollaboratedItineraries($user);
            $itineraries = $userItineraries->merge($collaboratedItineraries)->unique('id');
        }

        $destinations = Location::searchDestination($filters);
        return view('home', compact('destinations', 'itineraries', 'otherUsersItineraries'));
    }
}
