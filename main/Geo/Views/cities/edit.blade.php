@extends('Admin.Views.edit')

@include('auth::sidebar')

@section('editform')
    @php if (! isset($data)) { $old = old(); if (! empty($old)) { $data = $old; } else { $data = []; } } @endphp

    @if (isset($data['id']))
        <x-fieldhidden name='id' :data='$data' />
        <x-fieldhidden name='position' :data='$data' />
    @endif
    <x-fieldselect label="{{__('messages.countryCityEditView')}}" name='region_id' :data='$data' :items='$model_info->regions' itemtext='name' itemindex='id' />
    <x-fieldtext label="{{__('messages.zoneDepartmentCityEditView')}}"  name='zonename' :data='$data' placeholder="{{__('messages.zoneDepartmentCityEditView')}}" maxlength="200"/>
    <x-fieldtext label="{{__('messages.nameCityEditView')}}"  name='name' :data='$data' placeholder="{{__('messages.nameCityEditView')}}" maxlength="200" />
    <x-fieldnumber label="{{__('messages.latitudeCityEditView')}}"  name='latitude' :data='$data' placeholder="{{__('messages.latitudeCityEditView')}}" min="0" max="99999999999999999999" />
    <x-fieldnumber label="{{__('messages.longitudeCityEditView')}}"  name='longitude' :data='$data' placeholder="{{__('messages.longitudeCityEditView')}}" min="0" max="99999999999999999999" />
    <x-fieldswitch label="{{__('messages.statusCityEditView')}}"  name='status' :data='$data' />
@endsection
