@extends('Admin.Views.edit')

@include('auth::sidebar')

@section('editform')
    @php if (! isset($data)) { $old = old(); if (! empty($old)) { $data = $old; } else { $data = []; } } @endphp

    @if (isset($data['id']))
        <x-fieldhidden name='id' :data='$data' />
    @endif

    <x-fieldtext label='Nombre' name='name' :data='$data' placeholder='Nombre' />
    <x-fieldswitch label='Estado' name='status' :data='$data' />
@endsection
