<?php

namespace App\Services\Front;

use App\Events\ItineraryCollaborated;
use App\Models\Itinerary;
use App\Repositories\ItineraryRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ItineraryService
{
    public function __construct(
        protected ItineraryRepository $itineraryRepository
    ) {}

    public function index()
    {
        $user = Auth::user();
        $itineraries = $this->itineraryRepository->getUserItineraries($user);
        $userCollaboratedItineraries = $this->itineraryRepository->getCollaboratedItineraries($user);

        return view('Front.itineraries.index', compact('itineraries', 'userCollaboratedItineraries'));
    }

    public function create()
    {
        
        $itinerary = new Itinerary();
        return view('Front.itineraries.create', compact('itinerary'));
    }

    public function store($request)
    {

        $data = $request->all();
        $user = Auth::user();
        $data['user_id'] = $user->id;

        $itinerary = $this->itineraryRepository->createItinerary($data);
        return redirect()->route('itineraries.index')->with('success', 'Itinerary added successfully');
    }

    public function edit($itinerary)
    {
        Gate::authorize('update', $itinerary);

        return view('Front.itineraries.edit', compact('itinerary'));
    }

    public function update($request, $itinerary)
    {
        Gate::authorize('update', $itinerary);

        $data = $request->all();

        $itinerary = $this->itineraryRepository->updateItinerary($itinerary, $data);
        return redirect()->route('itineraries.index')->with('success', 'Itinerary Updated successfully');
    }

    public function destroy($itinerary)
    {
        Gate::authorize('destroy', $itinerary);

        $this->itineraryRepository->deleteItinerary($itinerary);
        return redirect()->route('itineraries.index')->with('success', 'Itinerary deleted successfully');
    }

    public function show($itinerary)
    {
        $destinations = $this->itineraryRepository->getItineraryDestinations($itinerary);
        return view('Front.itineraries.show', compact('itinerary', 'destinations'));
    }

    public function collaborate($itinerary)
    {
        Gate::authorize('collaborate', $itinerary);

        $user = Auth::user();

        $itinerary->collaborators()->attach($user);
        event(new ItineraryCollaborated($itinerary));

        return redirect()->route('itineraries.show', $itinerary->id);
    }

    public function leave($itinerary)
    {
        Gate::authorize('leave', $itinerary);

        $user = Auth::user();
        $itinerary->collaborators()->detach($user);
        return redirect()->route('itineraries.show', $itinerary->id);
    }
}
