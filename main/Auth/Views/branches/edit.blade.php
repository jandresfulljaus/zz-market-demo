@extends('Admin.Views.edit')
@include('auth::sidebar')

@section('editform')
    @php if (! isset($data)) { $old = old(); if (! empty($old)) { $data = $old; } else { $data = []; } } @endphp

    @if (isset($data['id']))
        <x-fieldhidden name='id' :data='$data' />
    @endif

    <x-fieldtext label="{{__('messages.NameNewBranches')}}" name='name' :data='$data' placeholder="{{__('messages.NameNewBranches')}}" />
    <x-fieldselect label="{{__('messages.applicantNewBranches')}}" name='organization_id' :data='$data' :items='$model_info->organizations' itemtext='name' itemindex='id' />
    <x-fieldtext label="{{__('messages.AdressNewBranches')}}" name='address' :data='$data' placeholder="{{__('messages.AdressNewBranches')}}" />
    <x-fieldselect label="{{__('messages.CitiesNewBranches')}}" name='city_id' :data='$data' :items='$model_info->cities' itemtext='name' itemindex='id' />
@endsection
