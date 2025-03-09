<x-app-layout>
    <x-slot name="header">

        <form action="{{URL::current()}}" method="get" class="d-flex justify-content-between gap-4 mb-4">
            <x-form.input name="filter" placeholder="Search Destinations" class="mx-2" :value="request('filter')" />
            <button type="submit" class="btn btn-dark mx-2">Search</button>
        </form>
    </x-slot>
    @if($errors->any())
<div class="alert alert-danger">
  <h2>Errors</h2>
  @foreach($errors->all() as $error)
  <li>{{$error}}</li>
  @endforeach
</div>
@endif
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
                                        <div class="flex flex-col gap-2 card-body ">
                                            <h5 class="card-title">{{$destination['name']}}</h5>
                                            <p class="card-text">{{$destination['display_name']}}</p>
                                            @auth
                                            <!-- Dropdown to Select Itinerary -->

                                            <form class="flex flex-row justify-center gap-3" action="{{ route('destinations.store','') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="name" value="{{ $destination['name'] }}">
                                                <input type="hidden" name="lat" value="{{ $destination['lat'] }}">
                                                <input type="hidden" name="lng" value="{{ $destination['lon'] }}">
                                                <select required name="itinerary_id" class="form-select">
                                                    <option value="">Select an Itinerary</option>
                                                    @foreach ($itineraries as $itinerary)
                                                    <option value="{{ $itinerary->id }}">{{ $itinerary->name }}</option>
                                                    @endforeach
                                                </select>
                                                <!-- Button to Add Destination -->
                                                <button type="submit" class="btn btn-success text-sm ">
                                                    Add
                                                </button>
                                            </form>

                                            @endauth

                                        </div>
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