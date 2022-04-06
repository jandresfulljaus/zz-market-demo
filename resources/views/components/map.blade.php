@push('styles')
    <link href="{{ asset('js/Leaflet-1.7.1/leaflet.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('js/Leaflet.GestureHandling-1.2.1/leaflet-gesture-handling.css') }}" rel="stylesheet" type="text/css">
@endpush

<div id="map" style="height: 450px"></div>
<input type="hidden" id="latitude" value="{{ $latitude }}">
<input type="hidden" id="longitude" value="{{ $longitude }}">

@push('scripts')
    <script src="{{ asset('js/Leaflet-1.7.1/leaflet.js') }}"></script>
    <script src="{{ asset('js/Leaflet.GestureHandling-1.2.1/leaflet-gesture-handling.min.js') }}"></script>
    <script>
        "use strict";

        const latitude = parseFloat(document.querySelector("#latitude").value);
        const longitude = parseFloat(document.querySelector("#longitude").value);

        let coordinates = L.latLng(latitude, longitude);

        const map = L.map("map", {
            center: coordinates,
            zoom: 18,
            gestureHandling: true,
        });

        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
            maxZoom: 18,
        }).addTo(map);

        L.marker(coordinates).addTo(map);
    </script>
@endpush
