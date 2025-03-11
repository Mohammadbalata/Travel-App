<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\ItineraryRequest;
use App\Models\Itinerary;
use App\Services\Front\ItineraryService;
use Illuminate\Http\Request;

class ItinerariesController extends Controller
{


    public function __construct(protected ItineraryService $itineraryService) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->itineraryService->index();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->itineraryService->create();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ItineraryRequest $request)
    {
        return $this->itineraryService->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Itinerary $itinerary) {
        return $this->itineraryService->show($itinerary);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Itinerary $itinerary)
    {
        return $this->itineraryService->edit($itinerary);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ItineraryRequest $request, Itinerary $itinerary)
    {
        return $this->itineraryService->update($request, $itinerary);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Itinerary $itinerary)
    {
        return $this->itineraryService->destroy($itinerary);
    }

    public function collaborate(Itinerary $itinerary){
        return $this->itineraryService->collaborate($itinerary);

    }

    public function leave(Itinerary $itinerary){
        return $this->itineraryService->leave($itinerary);

    }

}
