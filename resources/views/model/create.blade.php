@extends('layouts.base')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">@yield('card-title')</h5>
        </div>
        <form
            action="{{ route($templateData->routes['store']) }}"
            method="POST"
            enctype="multipart/form-data"
        >
            <div class="card-body">
                @csrf
                @yield('form-content')
            </div>
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-success">
                    Crear
                    <i class="mi-add-circle ml-2"></i>
                </button>
                <a
                    href="{{ url()->previous() }}"
                    class="btn btn-danger"
                >
                    Cancelar
                    <i class="mi-backspace ml-2"></i>
                </a>
            </div>
        </form>
    </div>
@endsection
