@extends('Admin.Views.admin')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="alert alert-danger alert-styled-left alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
                <p class="font-weight-semibold">
                    Su contraseña es muy debil para autorizar el acceso a este contenido
                </p>
                <p>
                    Actualice su contraseña desde su perfíl haciendo clic
                    <a href="{{ route('admin.profile.edit') }}">aquí</a>
                </p>
            </div>
        </div>
    </div>
@endsection
