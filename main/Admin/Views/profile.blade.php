@extends('Admin.Views.admin')

@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">
                Editar mi perfíl
            </h5>
        </div>
        <form
            action="{{ route('admin.profile.save') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            <div class="card-body">
                @csrf
                <div class="form-group">
                    <label class="text-primary font-weight-bold text-uppercase">Nombre</label>
                    <p class="font-weight-bold">{{ $model_info->person['name'] }}</p>
                </div>
                <div class="form-group">
                    <label class="text-primary font-weight-bold text-uppercase">Documento</label>
                    <p class="font-weight-bold">{{ $model_info->person->typedni }}: {{ $model_info->person->dni }}</p>
                </div>
                <x-fieldhidden name='id' :data='$data' />
                <x-fieldtext label="Email personal" name="email2" :data='$data' placeholder="" />
                <x-fieldtext label="Teléfono" name="phone" :data='$data' placeholder="" />
                <x-fieldpassword label="Cambiar contraseña" name="password" :data='$data' />
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="text-right col-12">
                        <div class="form-group">
                            <button
                                type="submit"
                                class="btn btn-success"
                            >
                                Guardar
                                <i class="mi-save ml-2"></i>
                            </button>
                            <a
                                href="{{ route('admin.home') }}"
                                class="btn btn-danger"
                            >
                                Salir sin guardar
                                <i class="mi-backspace ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
