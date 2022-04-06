@extends('model.list')

@section('breadcrumb')
    <a href="{{ route('admin.home') }}" class="breadcrumb-item">
        <i class="icon-home2 mr-2"></i>
        Inicio
    </a>
    <span class="breadcrumb-item active">
        Listado de actividad
    </span>
@endsection

@section('card-title', 'Listado de actividad')

@section('content')
    <x-alert type="info">
        A continuación podrá ver las actividades realizadas con su cuenta.
        <br>
        En caso de detectar actividades <b>no realizadas por Ud.</b> recomendamos
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
        <th width="170px">Fecha</th>
        <th>Actividad</th>
        <th>Dispositivo</th>
        <th width="150px">IP</th>
    </tr>
@endsection

@section('table-body')
    @forelse($data as $row)
        <tr>
            <td>{{ $row->id }}</td>
            <td>{{ Carbon\Carbon::parse($row->when)->format('d/m/Y H:i:s') }}</td>
            <td>{{ $row->description }}</td>
            <td>{{ $row->device }}</td>
            <td>{{ $row->ip }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="100">
                <h4 class="text-center mt-4 mb-4">
                    Sin datos para esta selecci&oacute;n.
                </h4>
            </td>
        </tr>
    @endforelse
@endsection
