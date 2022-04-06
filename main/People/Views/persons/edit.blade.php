@extends('Admin.Views.edit')

@include('auth::sidebar')

@section('editform')
    @php if (! isset($data)) { $old = old(); if (! empty($old)) { $data = $old; } else { $data = []; } } @endphp

    @if (request()->filled('redirect'))
        <input type="hidden" name="redirect" value="{{ request('redirect') }}">
    @endif

    @if (isset($data['id']))
        <x-fieldhidden name='id' :data='$data' />
    @endif
    <x-fieldtext label="{{__('messages.NameNewPeople')}}" name='name' :data='$data' placeholder="{{__('messages.NameNewPeople')}}" maxlength='200' />
    <x-fieldtextgroup label='DNI' :data='$data' name1='typedni' placeholder1="{{__('messages.documentTypeUserEditView')}}" width1='3' maxlength1='6' name2='dni' placeholder2="{{__('messages.documentNumberUserEditView')}}" width2='9' maxlength2='10' />
    <x-fieldtext label='CUIT' name='cuit' :data='$data' placeholder='CUIT' maxlength='13' />
    <x-fielddate name='birthday' :data='$data' placeholder="{{__('messages.DateOfBirthNewPeople')}}" label="{{__('messages.DateOfBirthNewPeople')}}" />

    <x-fieldselect label="{{__('messages.CityNewPeople')}}" name='city_id' :data='$data' :items='$model_info->cities' itemtext='name' itemindex='id' />
    <x-fieldswitch label="{{__('messages.StatusNewPeople')}}" name='status' :data='$data' />
 @endsection


@section('editform')
    @php
        /*if(!isset($data)) { $data=null; }
        if(isset($data['id']))
        {
            echo set_input_form2('hidden', 'id', '', $data, $errors, true, null);
        }

        $config = new \stdClass();
        $config->attributes = 'autocomplete="off"';
        echo set_input_form2('text', 'name', 'Nombre', $data, $errors, true, $config);

        $config->placeholder = 'dd/mm/yyyy';
        echo set_input_form2('datepicker', 'birthday', 'Fecha Nacimiento', $data, $errors, true, $config);

        $config = new \stdClass();
        echo set_input_form2('text', 'typedni', 'Tipo de DNI', $data, $errors, true, $config);
        echo set_input_form2('text', 'dni', 'DNI', $data, $errors, true, $config);
        echo set_input_form2('text', 'gender', 'Género', $data, $errors, true, $config);
        echo set_input_form2('text', 'address', 'Dirección', $data, $errors, true, $config);

        /*$config = new \stdClass();
        $config->placeholder = '- Seleccione Ciudad -';
        $config->defined_data = $biginfo->cities;
        $config->field_value = 'id';
        $config->field_text = 'name';
        echo set_input_form2('select2', 'city_id', 'Ciudad', $data, $errors, true, $config);
        $config = new \stdClass();
        $config->default = 'checked';
        echo set_input_form2('switch', 'status', 'Estado', $data, $errors, false, $config);
*/

    @endphp
@endsection
