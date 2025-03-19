<x-app-layout>
    <x-slot name="header">
        <!-- Search Form -->
        <form action="{{ URL::current() }}" method="get" class="d-flex justify-content-between gap-4 mb-4">
            <x-form.input name="place" placeholder="Country, City, Regoin" class="mx-2" :value="request('place')" />
            <select name="interest" class="form-select flex-grow-1">
                <option value="">Select Your Interest</option>
                @foreach(\App\Constants\Lists::INTEREST as $category => $items)
                <optgroup label="{{ ucfirst($category) }}">
                    @foreach($items as $key)
                    <option value="{{ $key }}" {{ request('interest') == $key ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_', ' ', $key)) }}
                    </option>
                    @endforeach
                </optgroup>
                @endforeach
            </select>
            <button type="submit" class="btn btn-dark mx-2">Search</button>
        </form>
    </x-slot>

    <!-- Error Display -->
    @if($errors->any())
    <div class="alert alert-danger">
        <h2>Errors</h2>
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Main Content -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 grid">
                    <!-- Destinations Section -->
                    <div class="container my-5">
                        <h1 class="text-center mb-4">Destinations</h1>
                        <div class="row">
                            @if(!isset($destinations['error']))
                            @foreach ($destinations as $destination)
                            <div class="col-sm-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body d-flex flex-column gap-2">
                                        <h5 class="card-title">{{ $destination['name'] }}</h5>
                                        <p class="card-text">{{ $destination['display_name'] }}</p>
                                        @auth
                                        <!-- Dropdown to Select Itinerary -->
                                        <form class="d-flex flex-row justify-content-between align-items-center gap-3" action="{{ route('destinations.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="name" value="{{ $destination['name'] }}">
                                            <input type="hidden" name="lat" value="{{ $destination['lat'] }}">
                                            <input type="hidden" name="lng" value="{{ $destination['lon'] }}">
                                            <select required name="itinerary_id" class="form-select flex-grow-1">
                                                <option value="">Select an Itinerary</option>
                                                @foreach ($itineraries as $itinerary)
                                                <option value="{{ $itinerary->id }}">{{ $itinerary->name }}</option>
                                                @endforeach
                                            </select>
                                            <!-- Button to Add Destination -->
                                            <button type="submit" class="btn btn-success text-sm">
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

                    <!-- Other Users' Itineraries Section -->
                    <div class="container my-5">
                        <h1 class="text-center mb-4">Explore Itineraries</h1>
                        <div class="row">
                            @foreach ($otherUsersItineraries as $itinerary)
                            <div class="col-sm-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body d-flex flex-column gap-2">
                                        <h5 class="card-title">
                                            <a href="{{ route('itineraries.show', $itinerary) }}" class="text-decoration-none">
                                                {{ $itinerary->name }}
                                            </a>
                                        </h5>
                                        <p class="card-text mb-1"><strong>Creator:</strong> {{ $itinerary->creator }}</p>
                                        <p class="card-text"><strong>Duration:</strong> {{ $itinerary->duration }} days</p>
                                        @auth
                                        <form action="{{ route('itineraries.collaborate',$itinerary) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary text-sm">
                                                Collaborate
                                            </button>
                                        </form>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>