<x-app-layout>
    <div class="container mx-auto py-12 px-6">
        <div class="bg-white border-b rounded-t-lg p-6">
            <p class=" text-2xl font-bold text-gray-800">{{ $destination['name'] }}</p>

            <div class="mt-4">
                <p class="text-lg font-semibold">Images</p>
                <div class="mt-6 flex flex-wrap gap-4">
                    @foreach ($destinationImages as $image)
                    <img style="width: 20%; height: 20%;" src="{{ $image }}" class="rounded-lg shadow-md object-cover" alt="Destination Image">
                    @endforeach
                </div>
            </div>

            <div class="mt-6">
                <p class="text-lg mb-3 font-semibold">Location</h2>
                <div id="map" style="height: 50vh; width: 100vh;"></div>
            </div>
        </div>
      

    </div>

    <script>
        let map;
        async function initMap() {
            const position = {
                lat: Number("{{ $destination['lat'] }}"),
                lng: Number("{{ $destination['lng'] }}")
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
                title: "{{ $destination['en_name'] }}",
            });
        }
        initMap();
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.api_key') }}&callback=initMap&v=weekly" defer></script>
</x-app-layout>