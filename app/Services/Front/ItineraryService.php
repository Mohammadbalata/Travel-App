<?php

namespace App\Services\Front;

use App\Events\ItineraryCollaborated;
use App\Models\Itinerary;
use App\Repositories\ItineraryRepository;
use Illuminate\Support\Facades\Auth;

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

        return view('Front.itineraries.index', compact('itineraries','userCollaboratedItineraries'));
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
        $user = Auth::user();
        if ($user && $user->id == $itinerary->user_id) {
            return view('Front.itineraries.edit', compact('itinerary'));
        }
        return redirect()->back();
    }

    public function update($request, $itinerary)
    {
        $data = $request->all();
        $user = Auth::user();
        if ($user && $user->id == $itinerary->user_id) {
            $itinerary = $this->itineraryRepository->updateItinerary($itinerary, $data);
            return redirect()->route('itineraries.index')->with('success', 'Itinerary Updated successfully');
        }
        return redirect()->route('itineraries.index');
    }

    public function destroy($itinerary)
    {
        $user = Auth::user();
        if ($user && $user->id == $itinerary->user_id) {
            $this->itineraryRepository->deleteItinerary($itinerary);
            return redirect()->route('itineraries.index')->with('success', 'Itinerary deleted successfully');
        }
        return redirect()->back();

    }

    public function show($itinerary)
    {
        $destinations = $this->itineraryRepository->getItineraryDestinations($itinerary);
        return view('Front.itineraries.show', compact('itinerary', 'destinations'));
    }

    public function collaborate($itinerary)
    {
        $user = Auth::user();
        if ($user && !$itinerary->users()->where('user_id', $user->id)->exists()) {
            $itinerary->users()->attach($user);
            event(new ItineraryCollaborated($itinerary));
        }
        return redirect()->route('itineraries.show', $itinerary->id);
    }

    public function leave($itinerary){
        $user = Auth::user();
        if($user && $itinerary->users()->where('user_id', $user->id)->exists()){
            $itinerary->users()->detach($user);
        }
        return redirect()->route('itineraries.show', $itinerary->id);
    }
    
}
