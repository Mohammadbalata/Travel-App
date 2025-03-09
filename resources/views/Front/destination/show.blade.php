<x-app-layout>
    <div class="container mx-auto py-12 px-6">
        <div class="bg-white border-b rounded-t-lg p-6">
            <!-- Destination Name -->
            <p class="text-2xl font-bold text-gray-800">{{ $destination->name }}</p>

            <!-- Weather Section -->
            <div class="mt-6">
                <p class="text-lg font-semibold">5-Day Forecast</p>
                @if ($forecastData)
                <div class="mt-4 overflow-x-auto">
                    <div class="flex gap-4 pb-4">
                        @foreach ($forecastData['list'] as $forecast)
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm flex-shrink-0" style="min-width: 150px;">
                            <p class="text-sm font-semibold">{{ date('D, M j', $forecast['dt']) }}</p>
                            <p class="text-sm">{{ date('h:i A', $forecast['dt']) }}</p>
                            <img src="http://openweathermap.org/img/wn/{{ $forecast['weather'][0]['icon'] }}@2x.png" alt="Weather Icon" class="w-12 h-12 mx-auto">
                            <p class="text-center">{{ $forecast['main']['temp'] }}°C</p>
                            <p class="text-center text-sm capitalize">{{ $forecast['weather'][0]['description'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                @else
                <p class="text-gray-600 mt-4">Forecast data not available.</p>
                @endif
            </div>

            <!-- Images Section -->
            <div class="mt-6">
                <p class="text-lg font-semibold">Images</p>
                <div class="mt-4 flex flex-wrap gap-4">
                    @foreach ($destinationImages as $image)
                    <img style="width: 20%; height: 20%;" src="{{ $image }}" class="rounded-lg shadow-md object-cover" alt="Destination Image">
                    @endforeach
                </div>
            </div>

            <!-- Map Section -->
            <div class="mt-6">
                <p class="text-lg mb-3 font-semibold">Location</p>
                <div id="map" style="height: 50vh; width: 100%;"></div>
            </div>
        </div>
    </div>

    <!-- Google Maps Script -->
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