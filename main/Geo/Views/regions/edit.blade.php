@extends('Admin.Views.edit')

@include('auth::sidebar')
@section('editform')
    @php if (! isset($data)) { $old = old(); if (! empty($old)) { $data = $old; } else { $data = []; } } @endphp

    @if (isset($data['id']))
        <x-fieldhidden name='id' :data='$data' />
        <x-fieldhidden name='position' :data='$data' />
    @endif
    <x-fieldselect label="{{__('messages.countryProvinceEditView')}}" name='country_id' :data='$data' :items='$model_info->countries' itemtext='name' itemindex='id' />
    <x-fieldtext label="{{__('messages.nameProvinceEditView')}}" name='name' :data='$data' placeholder="{{__('messages.nameProvinceEditView')}}" maxlength="200"/>
    <x-fieldswitch label="{{__('messages.statusProvinceEditView')}}" name='status' :data='$data' />
@endsection
