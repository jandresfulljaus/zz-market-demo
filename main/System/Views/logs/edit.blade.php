@extends('system::Panel.edit')

@section('editform')
    @php
        if(!isset($data)) { $data=null; }
        if(isset($data['id']))
        {
            echo set_input_form2('hidden', 'id', '', $data, $errors, true, null);
        }

        $config = new \stdClass();
        $config->attributes = 'autocomplete="off"';
        echo set_input_form2('text', 'slug', 'Slug', $data, $errors, true, $config);

        $config = new \stdClass();
        $config->default = 'checked';
        echo set_input_form2('switch', 'status', 'Estado', $data, $errors, false, $config);

    @endphp
@endsection
