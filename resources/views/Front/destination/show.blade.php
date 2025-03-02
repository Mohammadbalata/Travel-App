<x-app-layout>
    <div class="container mx-auto py-12 px-6">
        <div class="bg-white border-b rounded-t-lg p-6">
            <p class=" text-2xl font-bold text-gray-800">{{ $destination->name }}</p>
            <p class="text-gray-600 mt-2">{{ $destination->description }}</p>

            <div class="mt-4">
                <p class="text-lg font-semibold">Region</p>
                <p class="text-gray-500">{{ $destination->region }}</p>
            </div>

            <div class="mt-4">
                <p class="text-lg font-semibold">Interests</p>
                <ul>
                    @foreach (json_decode($destination->interests) as $interest)
                    <li class="bg-blue-500  px-3 py-1 rounded-full">{{ $interest }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="mt-6 flex flex-wrap gap-4">
                @foreach ($destinationImages as $image)
                <img style="width: 20%; height: 20%;" src="{{ $image }}" class="rounded-lg shadow-md object-cover" alt="Destination Image">
                @endforeach
            </div>

            <div class="mt-6">
                <p class="text-lg mb-3 font-semibold">Location</h2>
                <div id="map" style="height: 50vh; width: 100vh;"></div>
            </div>
        </div>

        <!--  show destination reviews  -->
        <div class=" bg-white shadow-lg rounded-b-lg p-6">
        <div>
        
            <p class="text-2xl font-bold text-gray-800">Rating:
                <span class="inline-flex items-center gap-2 text-yellow-500">
                    @for ($i = 1; $i <= $destination->rate_avg; $i++)
                    <span > ★ </span>
                    @endfor
                </span>
                </p>
                <span class="text-gray-500 text-sm">({{ $reviews->count() }} reviews)</span>
        </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Reviews</h2>
            <div class="space-y-4">
                @forelse ($reviews as $review)
                <div class="border-b pb-4">
                    <div class="flex items-center gap-2">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($review->user->name) }}&background=random" class="w-10 h-10 rounded-full" alt="User Avatar">
                        <div>
                            <p class="font-semibold text-gray-700">{{ $review->user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="mt-2">
                        <p class="text-gray-600">{{ $review->description }}</p>
                    </div>
                </div>
                @empty
                <p class="text-gray-500">No reviews yet. Be the first to review this destination!</p>
                @endforelse
            </div>
        </div>

    </div>

    <script>
        let map;
        async function initMap() {
            const position = {
                lat: Number("{{ $destination->lat }}"),
                lng: Number("{{ $destination->lng }}")
            };
            const {
                Map
            } = await google.maps.importLibrary("maps");
            const {
                AdvancedMarkerElement
            } = await google.maps.importLibrary("marker");

            map = new Map(document.getElementById("map"), {
                zoom: 10,
                center: position,
                mapId: "DEMO_MAP_ID",
            });

            new AdvancedMarkerElement({
                map: map,
                position: position,
                title: "{{ $destination->name }}",
            });
        }
        initMap();
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.api_key') }}&callback=initMap&v=weekly" defer></script>
</x-app-layout>