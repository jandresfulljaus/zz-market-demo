@extends('Admin.Views.admin')

@section('content')
    <div class="alert bg-warning text-white alert-styled-left alert-dismissible">
        {{ $error_message }}
    </div>
@endsection
