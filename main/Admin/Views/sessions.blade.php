@extends('model.list')

@section('breadcrumb')
    <a href="{{ route('admin.home') }}" class="breadcrumb-item">
        <i class="icon-home2 mr-2"></i>
        Inicio
    </a>
    <span class="breadcrumb-item active">
        Listado de sesiones activas
    </span>
@endsection

@section('card-title', 'Listado de sesiones activas')

@section('content')
    <x-alert type="info">
        A continuación podrá ver los dispositivos en los que tiene una sesión activa.
        <br>
        En caso de detectar sesiones en dispositivos <b>no autorizados</b> recomendamos
        <a href="{{ route('admin.profile.edit') }}">
            <b>cambiar su contraseña</b>
        </a>
        y contactar al área de sistemas de forma inmediata.
    </x-alert>
@parent
@endsection

@section('table-header')
    <tr>
        <th width="70px">ID</th>
        <th>Dispositivo</th>
        <th width="150px">IP</th>
        <th width="150px">Última actividad</th>
    </tr>
@endsection

@section('table-body')
    @forelse($data as $row)
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    @empty
        <tr>
            <td colspan="100">
                <h4 class="text-center mt-4 mb-4">
                    <!--
                    Sin datos para esta selecci&oacute;n.
                    -->
                    Estamos trabajando en esta sección, próximamente estará disponible
                </h4>
            </td>
        </tr>
    @endforelse
@endsection
