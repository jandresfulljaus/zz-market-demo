@extends('layouts.sidebar-secondary')

@section('sidebar-title', 'Mis Notificaciones')

@section('sidebar-content')
    <x-sidebar.nav>
        <x-sidebar.header>Mis notificaciones</x-sidebar.header>
        <x-sidebar.item
            :is-active="request()->routeIs('admin.notifications.index') && request('f') === 'unread'"
            :url="route('admin.notifications.index', ['f' => 'unread'])"
            icon="mi-visibility-off"
            title="Notificaciones no leídas"
        >
            No le&iacute;das
            <span class="badge badge-info ml-auto">
                {{ auth()->user()->unreadNotifications()->count() }}
            </span>
        </x-sidebar.item>
        <x-sidebar.item
            :is-active="request()->routeIs('admin.notifications.index') && request('f') === 'read'"
            :url="route('admin.notifications.index', ['f' => 'read'])"
            icon="mi-visibility"
            title="Notificaciones leídas"
        >
            Le&iacute;das
        </x-sidebar.item>
        <x-sidebar.item
            :is-active="request()->routeIs('admin.notifications.index') && request('f') === 'all'"
            :url="route('admin.notifications.index', ['f' => 'all'])"
            icon="mi-content-paste"
            title="Todas las notificaciones"
        >
            Todas
        </x-sidebar.item>
    </x-sidebar.nav>
@endsection
