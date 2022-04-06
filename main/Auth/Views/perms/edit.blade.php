@extends('Admin.Views.edit')

@include('auth::sidebar')

@section('editform')
    @php if (! isset($data)) { $old = old(); if (! empty($old)) { $data = $old; } else { $data = []; } } @endphp
    @php $access = Config::get('data.role.access'); @endphp
    @if (isset($data['id']))
        <x-fieldhidden name='id' :data='$data' />
    @endif

    <x-fieldtext label="{{__('messages.namePermissionEditView')}}" name='name' :data='$data' placeholder="{{__('messages.namePermissionEditView')}}" />
    <x-fieldtext label="{{__('messages.slugPermissionEditView')}}" name='slug' :data='$data' placeholder="{{__('messages.slugPermissionEditView')}}" />
    <x-fieldswitch label="{{__('messages.statusPermissionEditView')}}" name='status' :data='$data' />

@endsection
