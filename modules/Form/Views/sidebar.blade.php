@extends('layouts.sidebar-secondary')

@section('sidebar-title', 'Formularios')

@section('sidebar-content')
    @can('access', 'form.data_updates.list')
        @can('access','form.data_updates.create')
            <x-sidebar.button
                :url="route('form.data_updates.create')"
                color="bg-indigo-400"
            >
                Nuevo Formulario
            </x-sidebar.button>
        @endcan
        <x-sidebar.nav>
            <x-sidebar.header>Listados</x-sidebar.header>
            <x-sidebar.item
                :is-active="request()->routeIs('form.data_updates.*')"
                :url="route('form.data_updates.list')"
                icon="mi-contacts"
                title="Actualización de Datos"
            >
                Actualizaci&oacute;n de Datos
            </x-sidebar.item>
        </x-sidebar.nav>
    @endcan
@endsection
