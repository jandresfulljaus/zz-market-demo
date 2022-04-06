@extends('Admin.Views.edit')

@include('auth::sidebar')

@section('editform')
    @php if (! isset($data)) { $old = old(); if (! empty($old)) { $data = $old; } else { $data = []; } } @endphp

    @if (isset($data['id']))
        <x-fieldhidden name='id' :data='$data' />
    @endif

    @php $user_role=[];  if(isset($data["role"])) { foreach($data["role"] as $role) { $user_role[]=$role["id"]; } }  @endphp

    @if(!empty($model_info->persons))
    <div class="form-group">
        <label class="text-primary font-weight-bold text-uppercase">{{__('messages.personUserEditView')}}</label>
        <p>{{ $model_info->persons[0]->name }} - {{ $model_info->persons[0]->typedni }}: {{ $model_info->persons[0]->dni }}</p>
    </div>
    @else
    <x-fieldselectajax label="{{__('messages.personUserEditView')}}" name='person_id' :data='$data' template='templateSelectPersons' :items='$model_info->persons' :itemsurl='route("people.persons.find")' itemtext='name' itemindex='id' />
    @endif
    

    <x-fieldselect label="{{__('messages.applicantUserEditView')}}" name='organization_id' :data='$data' :items='$model_info->organizations' itemtext='name' itemindex='id' />


    <x-fieldtext label="{{__('messages.workEmailUserEditView')}}" name="email" :data='$data' placeholder="" />
    <x-fieldtext label="{{__('messages.personalEmailUserEditView')}}" name="email2" :data='$data' placeholder="" />
    <x-fieldtext label="{{__('messages.phoneNumberUserEditView')}}" name="phone" :data='$data' placeholder="" />

    @if (isset($data['id']))
        <x-fieldpassword label="{{__('messages.changePasswordUserEditView')}}" autocomplete="off" name="password" :data='$data' />
    @endif

    <x-fieldduallist label="{{__('messages.rolesUserEditView')}}" name='role[]' :data='$data' :datapivot='$model_info->user_role' :items='$model_info->roles' itemtext='name' itemindex='id' />
    <x-fieldswitch label="{{__('messages.statusUserEditView')}}" name='status' :data='$data' />

@endsection
