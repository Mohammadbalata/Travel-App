<x-app-layout>
    <x-slot name="header">
        <!-- Search Form -->
        <form action="{{ URL::current() }}" method="get" class="d-flex justify-content-between gap-4 mb-4">
            <x-form.input name="filter" placeholder="Search Itineraries" class="mx-2" :value="request('filter')" />
            <button type="submit" class="btn btn-dark mx-2">Search</button>
        </form>
    </x-slot>

    <!-- Main Content -->
    <div class="container mt-4">
        <!-- Create Itinerary Button -->
        <div class="mb-5">
            <a href="{{ route('itineraries.create') }}" class="btn btn-primary mx-2">Create Itinerary</a>
        </div>

        <!-- My Itineraries Section -->
        <div class="mb-5">
            <h2 class="mb-4">My Itineraries</h2>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @forelse ($itineraries as $itinerary)
                    <div class="col">
                        <div class="card h-100 shadow-sm hover-shadow">
                            <div class="card-body">
                                <!-- Itinerary Name -->
                                <h5 class="card-title">
                                    <a href="{{ route('itineraries.show', $itinerary) }}" class="text-decoration-none text-dark">
                                        {{ $itinerary->name }}
                                    </a>
                                </h5>

                                <!-- Itinerary Details -->
                                <div class="card-text">
                                    <p class="mb-1"><strong>Start Date:</strong> {{ $itinerary->start_date?->format('Y-m-d') }}</p>
                                    <p class="mb-1"><strong>End Date:</strong> {{ $itinerary->end_date?->format('Y-m-d') }}</p>
                                    <p class="mb-1"><strong>Duration:</strong> {{ $itinerary->duration }} days</p>
                                    <p class="mb-1"><strong>Budget:</strong> {{ \App\Helpers\Currency::format($itinerary->budget) }}</p>
                                </div>
                            </div>

                            <!-- Card Footer with Actions -->
                            <div class="card-footer bg-transparent border-top-0 d-flex justify-content-start gap-2 align-items-center">
                                <!-- Edit Button -->
                                <a href="{{ route('itineraries.edit', $itinerary->id) }}" class="btn btn-sm btn-outline-success">Edit</a>

                                <!-- Delete Button -->
                                <form action="{{ route('itineraries.destroy', $itinerary->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- No Itineraries Found -->
                    <div class="col">
                        <div class="alert alert-info text-center">
                            No itineraries found.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Collaborated Itineraries Section -->
        <div class="mb-5">
            <h2 class="mb-4">Collaborated Itineraries</h2>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @forelse ($userCollaboratedItineraries as $itinerary)
                    <div class="col">
                        <div class="card h-100 shadow-sm hover-shadow">
                            <div class="card-body">
                                <!-- Itinerary Name -->
                                <h5 class="card-title">
                                    <a href="{{ route('itineraries.show', $itinerary) }}" class="text-decoration-none text-dark">
                                        {{ $itinerary->name }}
                                    </a>
                                </h5>

                                <!-- Itinerary Details -->
                                <div class="card-text">
                                    <p class="mb-1"><strong>Start Date:</strong> {{ $itinerary->start_date?->format('Y-m-d') }}</p>
                                    <p class="mb-1"><strong>End Date:</strong> {{ $itinerary->end_date?->format('Y-m-d') }}</p>
                                    <p class="mb-1"><strong>Duration:</strong> {{ $itinerary->duration }} days</p>
                                    <p class="mb-1"><strong>Budget:</strong> {{ \App\Helpers\Currency::format($itinerary->budget) }}</p>
                                </div>
                            </div>

                            <!-- Card Footer with Leave Button -->
                            <div class="card-footer bg-transparent border-top-0 d-flex justify-content-start gap-2 align-items-center">
                                <!-- Leave Button -->
                                <form action="{{ route('itineraries.leave', $itinerary) }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Leave</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- No Collaborated Itineraries Found -->
                    <div class="col">
                        <div class="alert alert-info text-center">
                            No collaborations yet.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Custom CSS for Hover Effect -->
    <style>
        .hover-shadow:hover {
            transform: translateY(-5px);
            transition: transform 0.2s ease-in-out;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</x-app-layout>