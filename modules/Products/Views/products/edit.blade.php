@extends('Admin.Views.edit')

@section('editform')
    @php if (! isset($data)) { $old = old(); if (! empty($old)) { $data = $old; } else { $data = []; } } @endphp

    @isset($data['id'])
        <x-fieldhidden name='id' :data='$data' />
    @endisset

    <x-fieldtext
        label='Nombre'
        name='name'
        :data='$data'
        placeholder='Nombre'
    />
    <x-fieldswitch
        label='Estado'
        name='status'
        :data='$data'
    />
@endsection
