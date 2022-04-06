@extends('Admin.Views.admin')

@section('content')
    <div class="alert bg-warning text-white alert-styled-left alert-dismissible">
        <p>{{__('messages.errorContent404Blade')}}</p>
        <p>{{__('messages.errorContactSystems404Blade')}}</p>
    </div>
@endsection
