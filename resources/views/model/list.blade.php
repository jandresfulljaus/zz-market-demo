@extends('Admin.Views.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">@yield('card-title')</h5>
        </div>
        <div class="card-body">
            {{-- @include('model.partials.filters') --}}
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    @yield('table-header')
                </thead>
                <tbody>
                    @yield('table-body')
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <p>Total de registros: {{ $data->total() }}</p>
            {{ $data->onEachSide(1)->links() }}
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/lists.js') }}"></script>
@endpush
