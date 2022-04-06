@push('styles')
    <link href="{{ asset('js/Leaflet-1.7.1/leaflet.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('js/Leaflet.GestureHandling-1.2.1/leaflet-gesture-handling.css') }}" rel="stylesheet" type="text/css">
@endpush

<div class="row text-right">
    <div class="col-6 offset-md-9 col-md-3">
        <button id="resetCoordinates" type="button" class="btn btn-danger">
            Reiniciar el mapa
        </button>
    </div>
</div>
<div id="leafletMap" style="height: 450px"></div>
<input
    type="number"
    step="0.000001" min="-90" max="90"
    id="fallbackLatitude"
    value="{{ config('fulljaus.organization.lat') }}"
    disabled  hidden
/>
<input
    type="number"
    step="0.000001" min="-180" max="180"
    id="fallbackLongitude"
    value="{{ config('fulljaus.organization.lng') }}"
    disabled hidden
/>
<input
    type="number"
    step="0.000001" min="-90" max="90"
    id="latitude"
    name="latitude"
    value="{{ $latitude }}"
    readonly hidden
/>
<input
    type="number"
    step="0.000001" min="-180" max="180"
    id="longitude"
    name="longitude"
    value="{{ $longitude }}"
    readonly hidden
/>

@push('scripts')
    <script src="{{ asset('js/Leaflet-1.7.1/leaflet.js') }}"></script>
    <script src="{{ asset('js/Leaflet.GestureHandling-1.2.1/leaflet-gesture-handling.min.js') }}"></script>
    <script>
        "use strict";

        const fallbackLatitude = parseFloat(document.querySelector("#fallbackLatitude").value);
        const fallbackLongitude = parseFloat(document.querySelector("#fallbackLongitude").value);
        const latitude = parseFloat(document.querySelector("#latitude").value);
        const longitude = parseFloat(document.querySelector("#longitude").value);

        let coordinates;
        if (isNaN(latitude) && isNaN(longitude)) {
            coordinates = L.latLng(fallbackLatitude, fallbackLongitude);
        } else {
            coordinates = L.latLng(latitude, longitude);
        }

        const leafletMap = L.map("leafletMap", {
            center: coordinates,
            zoom: 18,
            gestureHandling: true,
        });

        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
            maxZoom: 18,
        }).addTo(leafletMap);

        const marker = L.marker(coordinates).addTo(leafletMap);

        leafletMap.on("click", e => changeMapLocation(e.latlng));

        const changeMapLocation = (latlng) => {
            document.querySelector("#latitude").value = latlng.lat;
            document.querySelector("#longitude").value = latlng.lng;
            marker.setLatLng(latlng);
            leafletMap.panTo(latlng);
        };

        const resetMapLocation = () => {
            document.querySelector("#latitude").value = coordinates.lat;
            document.querySelector("#longitude").value = coordinates.lng;
            marker.setLatLng(coordinates);
            leafletMap.panTo(coordinates);
        };

        document
            .querySelector("#resetCoordinates")
            .addEventListener("click", resetMapLocation);
    </script>
@endpush
