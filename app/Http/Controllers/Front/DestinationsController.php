<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\DestinationRequest;
use App\Models\Destination;
use App\Models\Itinerary;
use App\Services\Front\DestinationService;


class DestinationsController extends Controller
{

    public function __construct(protected DestinationService $destinationService)
    {
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DestinationRequest $request)
    {
        return $this->destinationService->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Itinerary $itinerary,Destination $destination)
    {
        return $this->destinationService->show($destination);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DestinationRequest $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Itinerary $itinerary,Destination $destination)
    {
        return $this->destinationService->destroy($destination);

    }

}
