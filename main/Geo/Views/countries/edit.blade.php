@extends('Admin.Views.edit')

@include('auth::sidebar')

@section('editform')
    @php if (! isset($data)) { $old = old(); if (! empty($old)) { $data = $old; } else { $data = []; } } @endphp

    @if (isset($data['id']))
        <x-fieldhidden name='id' :data='$data' />
        <x-fieldhidden name='position' :data='$data' />
    @endif

    <x-fieldtext label="{{__('messages.nameCountryEditView')}}" name='name' :data='$data' placeholder="{{__('messages.nameCountryEditView')}}"  maxlength="200" />
    <x-fieldtext label="{{__('messages.isoCodeCountryEditView')}}" name='iso' :data='$data' placeholder="{{__('messages.isoCodeCountryEditView')}}" maxlength="3" />
    <x-fieldtext label="{{__('messages.phoneCodeCountryEditView')}}" name='phone' :data='$data' placeholder="{{__('messages.phoneCodeCountryEditView')}}" maxlength="4" />
    <x-fieldswitch label="{{__('messages.statusCountryEditView')}}" name='status' :data='$data' />
@endsection
