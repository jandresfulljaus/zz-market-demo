@extends('Admin.Views.admin')

@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">
                @if (isset($data['id']))
                    {{__('messages.editingAdminModel')}}
                @else
                    {{__('messages.insertingAdminModel')}}
                @endif
                {{ $model_info->model_titles[app()->getLocale()]['plural'] }}
            </h5>
            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item" data-action="collapse"></a>
                    <a class="list-icons-item" data-action="reload"></a>
                    <a class="list-icons-item" data-action="remove"></a>
                </div>
            </div>
        </div>
        <form
            action="{{ route( $model_info->routes['save']) }}"
            method="POST"
            enctype="multipart/form-data"
        >
            <div class="card-body">
                @csrf
                @yield('editform')
            </div>
            <div class="card-footer">
                    <div class="row">
                        <div class="text-right col-12">
                            <div class="form-group">
                                @hasSection('edit-buttons')
                                    @yield('edit-buttons')
                                @else
                                    <button type="submit" class="btn btn-success">
                                        {{ __('messages.saveButton') }}
                                        <i class="mi-save ml-2"></i>
                                    </button>
                                    <a
                                        href="{{ url()->previous() }}"
                                        class="btn btn-danger"
                                    >
                                        {{ __('messages.continueWithoutSavingButton') }}
                                        <i class="mi-backspace ml-2"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
        </form>
    </div>
@endsection
