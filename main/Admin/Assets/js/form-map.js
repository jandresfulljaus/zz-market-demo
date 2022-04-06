"use strict";

const changeMapLocation = (lat, lng) => {
    document.querySelector("#lat").value = lat;
    document.querySelector("#lng").value = lng;
    marker.setLatLng([lat, lng]);
    formMap.panTo([lat, lng]);
};

const resetMapLocation = () => {
    document.querySelector("#lat").value = coordinates[0];
    document.querySelector("#lng").value = coordinates[1];
    marker.setLatLng(coordinates);
    formMap.panTo(coordinates);
};

const getAddressGeolocation = () => {
    if (!document.querySelector("#addressInput").value) {
        alert("Ingrese una dirección");
        return 0;
    }
    const addressData = JSON.parse(
        document.querySelector("#addressData").innerHTML
    );
    addressData.city = addressData.city.split(" ").join("+");
    addressData.province = addressData.province.split(" ").join("+");
    addressData.country = addressData.country.split(" ").join("+");
    const searchAddress = document
        .querySelector("#addressInput")
        .value.split(" ")
        .join("+");

    const searchQuery = `${searchAddress}+${addressData.city}+${addressData.province}+${addressData.country}`;
    const apiUrl = "https://nominatim.openstreetmap.org/search?q=";
    const apiParameters = "&limit=1&format=json";
    const searchUrl = apiUrl + searchQuery + apiParameters;

    const request = new XMLHttpRequest();
    request.open("GET", searchUrl, true);
    request.setRequestHeader(
        "Access-Control-Allow-Origin",
        "https://nominatim.openstreetmap.org"
    );
    request.setRequestHeader("User-Agent", "Location Search");
    request.responseType = "json";

    request.onload = () => {
        if (request.status === 200) {
            if (typeof request.response[0] !== "undefined") {
                changeMapLocation(
                    request.response[0].lat,
                    request.response[0].lon
                );
            } else {
                alert("No se encontró la dirección solicitada");
            }
        } else {
            alert("Hubo problemas al contactar al servidor");
        }
    };
    request.onerror = () => {
        alert("No pudimos contactar al servidor");
    };
    request.send();
};

const getUserGeolocation = () => {
    const success = (position) => {
        changeMapLocation(position.coords.latitude, position.coords.longitude);
    };

    const error = () => {
        alert("No pudimos obtener su ubicación");
    };

    if (!navigator.geolocation) {
        alert("Actualice su navegador");
    } else {
        navigator.geolocation.getCurrentPosition(success, error);
    }
};

const defaultLat = parseFloat(document.querySelector("#defaultLat").value);
const defaultLng = parseFloat(document.querySelector("#defaultLng").value);

let lat = document.querySelector("#lat").value;
let lng = document.querySelector("#lng").value;
let coordinates = [];

if (lat && lng) {
    lat = parseFloat(lat);
    lng = parseFloat(lng);
    coordinates = [lat, lng];
} else {
    coordinates = [defaultLat, defaultLng];
}

const formMap = L.map("formMap", { scrollWheelZoom: false }).setView(
    coordinates,
    18
);

L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution:
        '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
    maxZoom: 18,
}).addTo(formMap);

const marker = L.marker(coordinates).addTo(formMap);

formMap.on("click", (e) => {
    changeMapLocation(e.latlng.lat, e.latlng.lng);
});

document
    .querySelector("#searchAddress")
    .addEventListener("click", getAddressGeolocation);
document
    .querySelector("#geolocate")
    .addEventListener("click", getUserGeolocation);
document
    .querySelector("#resetCoordinates")
    .addEventListener("click", resetMapLocation);
