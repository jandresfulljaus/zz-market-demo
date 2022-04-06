@extends('Admin.Views.edit')

@include('auth::sidebar')

@section('editform')
    @php if (! isset($data)) { $old = old(); if (! empty($old)) { $data = $old; } else { $data = []; } } @endphp
    @php $access = Config::get('data.role.access'); @endphp

    @if (isset($data['id']))
        <x-fieldhidden name='id' :data='$data' />
    @endif

    <x-fieldtext label="{{__('messages.NameNewRol')}}" name='name' :data='$data' placeholder="{{__('messages.NameNewRol')}}" maxlength="200" />
    <x-fieldtext label='Slug' name='slug' :data='$data' placeholder='Slug' />
    <x-fieldselect label="{{__('messages.AccessTypeNewRol')}}" name='access' :data='$data' :items='$access' itemtext='name' itemindex='id' />
    <x-fieldswitch label="{{__('messages.StatusNewRol')}}" name='status' :data='$data' />
    <x-fieldduallist label="{{__('messages.PermissionsNewRol')}}" name='perm[]' :data='$data' :datapivot='$model_info->perms_role' :items='$model_info->perms' itemtext='name' itemindex='id' />

@endsection
