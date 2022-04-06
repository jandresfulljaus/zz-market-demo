<div class="form-group">
    <label class="text-primary font-weight-bold text-uppercase">Dirección</label>
    <div class="form-row">
        <input id="addressInput" class="form-control col-12 col-md-9" type="text" name="{{ $addressname }}" value="{{ $addressvalue }}" class="form-control" placeholder="Dirección" />
        <button id="searchAddress" type="button" class="btn btn-primary col-12 col-md-3">
            Ubicar en el mapa
        </button>
    </div>
</div>

<div class="row text-right">
    <div class="col-6 col-md-3 offset-md-6">
        <button id="geolocate" type="button" class="btn btn-info">
            Usar mi ubicación
        </button>
    </div>
    <div class="col-6 col-md-3">
        <button id="resetCoordinates" type="button" class="btn btn-danger">
            Reiniciar el mapa
        </button>
    </div>
</div>

<div id="formMap" style="height: 500px; margin-bottom: 2.25rem !important;"></div>

<input id="defaultLat" type="number" step="0.000001" min="-90" max="90" value="{{ config('fulljaus.organization.lat') }}" disabled  hidden />
<input id="lat" type="number" step="0.000001" min="-90" max="90" name="{{ $latname }}" value="{{ $latvalue }}" class="form-control" placeholder="Latitud" readonly hidden />
<input id="defaultLng" type="number" step="0.000001" min="-180" max="180" value="{{ config('fulljaus.organization.lng') }}" disabled hidden />
<input id="lng" type="number" step="0.000001" min="-180" max="180" name="{{ $lngname }}" value="{{ $lngvalue }}" class="form-control" placeholder="Longitud" readonly hidden />
