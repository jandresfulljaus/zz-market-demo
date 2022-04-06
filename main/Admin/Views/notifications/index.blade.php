@extends('layouts.base')

@include('Admin.Views.notifications.sidebar')

@section('breadcrumb')
    <a href="{{ route('admin.home') }}" class="breadcrumb-item">
        <i class="icon-home2 mr-2"></i>
        Inicio
    </a>
    <span class="breadcrumb-item active">
        Mis Notificaciones
    </span>
@endsection

@section('table-header')
    <tr>
        <th>M&oacute;dulo</th>
        <th>T&iacute;tulo</th>
        <th>Recibida el</th>
        <th>Le&iacute;da el</th>
        <th>Acciones</th>
    </tr>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Mis Notificaciones [{{ $filter }}]</h5>
        </div>
        <div class="card-body d-flex justify-content-end">
            <form
                id="read-selected"
                action="{{ route('admin.notifications.read-selected') }}"
                method="POST"
            >
                @csrf
                @method('PATCH')
                <select name="notifications[]" multiple hidden></select>
                <button
                    class="d-flex p-1 m-1 font-size-sm font-weight-semibold btn btn-link btn-float btn-success"
                    type="submit"
                    disabled
                >
                    <i class="mi-visibility text-white"></i>
                    <i class="mi-check-box text-white"></i>
                </button>
            </form>
            <form
                id="unread-selected"
                action="{{ route('admin.notifications.unread-selected') }}"
                method="POST"
            >
                @csrf
                @method('PATCH')
                <select name="notifications[]" multiple hidden></select>
                <button
                    class="d-flex p-1 m-1 font-size-sm font-weight-semibold btn btn-link btn-float btn-danger"
                    type="submit"
                    disabled
                >
                    <i class="mi-visibility-off text-white"></i>
                    <i class="mi-check-box text-white"></i>
                </button>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" id="toggle-all">
                        </th>
                        <th>M&oacute;dulo</th>
                        <th>Descripci&oacute;n</th>
                        <th>Recibida el</th>
                        <th>Le&iacute;da el</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $row)
                        <tr>
                            <td>
                                <input type="checkbox" name="notification" value="{{ $row->id }}">
                            </td>
                            @if (isset($row->data['module']))
                                <td>{{ $templateData->modulesNames[$row->data['module']] }}</td>
                            @else
                                <td>&#126;</td>
                            @endif
                            <td>{{ $row->data['description'] ?? '~' }}</td>
                            <td>{{ $row->created_at->isoFormat('L LT') }}</td>
                            <td>{{ $row->read_at === null ? '~' : $row->read_at->isoFormat('L LT') }}</td>
                            <td>
                                @if ($row->data['url'] !== null)
                                    <a
                                        class="p-1 m-1 font-size-sm font-weight-semibold btn btn-link btn-float btn-info"
                                        href="{{ $row->data['url'] }}{{ $row->read_at === null ? '?n='.$row->id : '' }}"
                                    >
                                        <i class="mi-link text-white"></i>
                                    </a>
                                @endif
                                @if ($row->read_at === null)
                                    <form
                                        class="d-inline"
                                        action="{{ route('admin.notifications.read', $row->id) }}"
                                        method="POST"
                                    >
                                        @csrf
                                        @method('PATCH')
                                        <button
                                            class="p-1 m-1 font-size-sm font-weight-semibold btn btn-link btn-float btn-success"
                                            type="submit"
                                        >
                                            <i class="mi-visibility text-white"></i>
                                        </button>
                                    </form>
                                @else
                                    <form
                                        class="d-inline"
                                        action="{{ route('admin.notifications.unread', $row->id) }}"
                                        method="POST"
                                    >
                                        @csrf
                                        @method('PATCH')
                                        <button
                                            class="p-1 m-1 font-size-sm font-weight-semibold btn btn-link btn-float btn-danger"
                                            type="submit"
                                        >
                                            <i class="mi-visibility-off text-white"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100">
                                <h4 class="text-center mt-4 mb-4">
                                    No hay notificaciones disponibles.
                                </h4>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $data->onEachSide(1)->links() }}
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/notifications-index.js') }}"></script>
@endpush
