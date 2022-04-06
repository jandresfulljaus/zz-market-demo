@extends('Admin.Views.edit')
@include('auth::sidebar')

@section('editform')
    @php if (! isset($data)) { $old = old(); if (! empty($old)) { $data = $old; } else { $data = []; } } @endphp

    @if (isset($data['id']))
        <x-fieldhidden name='id' :data='$data' />
    @endif

    <x-fieldtext label="{{__('messages.nameOrganizationEditView')}}" name='name' :data='$data' placeholder="{{__('messages.nameOrganizationEditView')}}" maxlength="200" />
    <x-fieldtext label="{{__('messages.institutionalUrlOrganizationEditView')}}" name='url' :data='$data' placeholder="{{__('messages.institutionalUrlOrganizationEditView')}}" maxlength="250" />
    <x-fieldselect label="{{__('messages.cityOrganizationEditView')}}" name='city_id' :data='$data' :items='$model_info->cities' itemtext='name' itemindex='id' />
    <x-fieldswitch label="{{__('messages.statusOrganizationEditView')}}" name='status' :data='$data' />
@endsection
