<x-app-layout>
    <div class="container">
        <h1 class="my-4">{{ $itinerary->name }}</h1>
        <!-- Social Sharing Buttons -->
        <div class="card mt-4">
            <div class="card-body">

                <div class="d-flex gap-2">
                    <!-- Facebook -->
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="btn btn-primary btn-sm">
                        <i class="fab fa-facebook-f"></i> Facebook
                    </a>

                    <!-- Twitter -->
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text=Check out this itinerary: {{ $itinerary->name }}" target="_blank" class="btn btn-info btn-sm">
                        <i class="fab fa-twitter"></i> Twitter
                    </a>

                    <!-- LinkedIn -->
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ $itinerary->name }}" target="_blank" class="btn btn-secondary btn-sm">
                        <i class="fab fa-linkedin-in"></i> LinkedIn
                    </a>

                    <!-- WhatsApp -->
                    <a href="https://wa.me/?text=Check out this itinerary: {{ $itinerary->name }} - {{ urlencode(url()->current()) }}" target="_blank" class="btn btn-success btn-sm">
                        <i class="fab fa-whatsapp"></i> WhatsApp
                    </a>
                    <!-- Email -->
                    <a href="mailto:?subject=Check out this itinerary&body=Check out this itinerary: {{ $itinerary->name }} - {{ urlencode(url()->current()) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-envelope"></i> Email
                    </a>
                </div>
            </div>
        </div>
        <!-- Itinerary Details -->
        <div class="card mb-4">
            <div class="card-body">
                <p class="card-text"><strong>Budget:</strong> {{ \App\Helpers\Currency::format($itinerary->budget)  }}</p>
                <p class="card-text"><strong>Start Date:</strong> {{ $itinerary->start_date->format('Y-m-d') }}</p>
                <p class="card-text"><strong>End Date:</strong> {{ $itinerary->end_date->format('Y-m-d') }}</p>
                <p class="card-text"><strong>Duration:</strong> {{ $itinerary->duration }} days</p>
                <p class="card-text"><strong>Created By:</strong> {{ $itinerary->user->name }}</p> <!-- Assuming creator is a User model -->
            </div>
        </div>

        <!-- Destinations Section -->
        <div class="card">

            <div class="card-body">
                <ul class="list-group">
                    @forelse ($destinations as $destination)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="{{ route('destinations.show',$destination)}}">{{ $destination->name }}</a>
                        <form action="{{ route('destinations.destroy', $destination) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </li>
                    @empty
                    <p>No destinations added yet.</p>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

</x-app-layout>