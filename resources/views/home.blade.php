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
                        <h1 class="text-center mb-4">Explore Destinations</h1>
                        <div class="row">
                            @foreach ($destinations as $destination)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <!-- Destination Image -->
                                    <img src="{{ $destination->image_url }}" class="card-img-top" alt="{{ $destination->name }}" style="height: 200px; object-fit: cover;">

                                    <!-- Card Body -->
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $destination->name }}</h5>
                                        <p class="card-text">{{ Str::limit($destination->description, 100) }}</p>
                                        <ul class="list-unstyled">
                                            <li><strong>Region:</strong> {{ $destination->region }}</li>
                                            <li><strong>Interests:</strong> {{ implode(', ', json_decode($destination->interests)) }}</li>
                                        </ul>
                                    </div>

                                    <!-- Card Footer -->
                                    <div class="card-footer bg-white">
                                        <a href="{{ route('destinations.show',$destination) }}" class="btn btn-primary">View Details</a>
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