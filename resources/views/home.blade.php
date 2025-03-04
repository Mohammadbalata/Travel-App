<x-app-layout>
    <x-slot name="header">

        <form action="{{URL::current()}}" method="get" class="d-flex justify-content-between gap-4 mb-4">
            <x-form.input name="filter" placeholder="Search Destinations" class="mx-2" :value="request('filter')" />
            <button type="submit" class="btn btn-dark mx-2">Search</button>
        </form>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 grid">
                    <div class="container my-5">
                        <h1 class="text-center mb-4"></h1>
                        <div class="row">
                            <div class="row">
                                @if(! isset($destinations['error']) )
                                    @foreach ($destinations as $destination)
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{$destination['name']}}</h5>
                                                    <p class="card-text">{{$destination['display_name']}}</p>
                                                    <a href="{{route('destinations.show', $destination['place_id'])}}" class="btn btn-primary">Show Details</a>
                                                </div>
                                                {{-- <!--  <select name="" id="">
                                                    @foreach($itineraries as $itinerary)
                                                    <option value="{{ $itinerary->id  }}">{{$itinerary->name }}</option>
                                                    @endforeach
                                                </select> --> --}} 
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>