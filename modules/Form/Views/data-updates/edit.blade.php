@extends('Admin.Views.admin')

@include('form::.sidebar')

@section('content')
    @php if(! isset($data)) { $old = old(); if(! empty($old)) { $data = $old; } else { $data = []; } } @endphp
    <form
        action="{{ route( $model_info->routes['save']) }}"
        enctype="multipart/form-data"
        method="POST"
    >
        @csrf
        @if (isset($data['id']))
            <x-fieldhidden name='id' :data='$data' />
        @endif
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Datos Personales</h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <x-fieldtext
                            label='Apellido*'
                            name='surname'
                            placeholder='Apellido'
                            :data='$data'
                        />
                    </div>
                    <div class="col-12 col-md-6">
                        <x-fieldtext
                            label='Nombre*'
                            name='name'
                            placeholder='Nombre'
                            :data='$data'
                        />
                    </div>
                    <div class="col-12 col-md-6">
                        <x-fieldtext
                            label='DNI*'
                            name='dni'
                            placeholder='DNI'
                            :data='$data'
                        />
                    </div>
                    <div class="col-12 col-md-6">
                        <x-fieldnumber
                            label='Legajo*'
                            name='file'
                            placeholder="Legajo"
                            min="1"
                            step="1"
                            :data='$data'
                        />
                    </div>
                    <div class="col-12 col-md-6">
                        <x-fieldselect
                            label='Género*'
                            name='gender'
                            itemtext='value'
                            itemindex='value'
                            optionalText='Seleccionar género'
                            :data='$data'
                            :items='$model_info->genders'
                        />
                    </div>
                    <div class="col-12 col-md-6">
                        <x-fielddate
                            label='Fecha de nacimiento*'
                            name='birthday'
                            empty='true'
                            :data='$data'
                        />
                    </div>
                    <div class="col-12 col-md-6">
                        <x-fieldtext
                            label='Teléfono*'
                            name='phone'
                            placeholder='Teléfono'
                            :data='$data'
                        />
                    </div>
                    <div class="col-12 col-md-6">
                        <x-fieldselect
                            label='Grado de escolaridad*'
                            name='education'
                            itemtext='value'
                            itemindex='value'
                            optionalText='Seleccionar grado de escolaridad'
                            :data='$data'
                            :items='$model_info->educations'
                        />
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Grupo Familiar</h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <x-fieldselect
                            label='Estado civil*'
                            name='marital_status'
                            itemtext='value'
                            itemindex='value'
                            optionalText='Seleccionar estado civil'
                            :data='$data'
                            :items='$model_info->marital_statuses'
                        />
                    </div>
                    <div class="col-12 col-md-6">
                        <x-fieldtext
                            label='Nombre de su cónyugue'
                            name='spouse_name'
                            placeholder='Nombre de su cónyugue'
                            :data='$data'
                        />
                    </div>
                    <div class="col-12 col-md-6">
                        <x-fieldswitch
                            label='¿Tiene hijos?*'
                            name='has_children'
                            texton='Si'
                            textoff='No'
                            default='off'
                            :data='$data'
                        />
                    </div>
                    <div class="col-12 col-md-6">
                        <x-fieldnumber
                            label='Cantidad de hijos*'
                            name='children_amount'
                            min="0"
                            step="1"
                            :data='$data'
                        />
                    </div>
                    <div class="col-12 col-md-6">
                        <x-fieldswitch
                            label='¿Tiene hijos con capacidades diferentes?'
                            name='has_children_with_disabilities'
                            texton='Si'
                            textoff='No'
                            default='off'
                            :data='$data'
                        />
                    </div>
                    <div class="col-12 col-md-6">
                        <x-fieldtext
                            label='Indicar capacidades diferentes'
                            name='children_disabilities'
                            placeholder='Capacidades diferentes'
                            :data='$data'
                        />
                    </div>
                    <div class="col-12 col-md-6">
                        <x-fieldselect
                            label='¿Cuál es la edad de sus hijos? (Rango amplio)'
                            name='children_age_range'
                            itemtext='value'
                            itemindex='value'
                            optionalText='Seleccionar rango de edades'
                            :data='$data'
                            :items='$model_info->age_ranges'
                        />
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Vivienda</h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <x-fieldtext
                            label='Domicilio actual*'
                            name='address'
                            placeholder='Domicilio actual'
                            :data='$data'
                        />
                    </div>
                    <div class="col-12 col-md-6">
                        <x-fieldswitch
                            label='¿Vive con alguna persona?*'
                            name='shares_home'
                            texton='Si'
                            textoff='No'
                            default='off'
                            :data='$data'
                        />
                    </div>
                    <div class="col-12 col-md-6">
                        <x-fieldswitch
                            label='¿Posee vivienda propia?*'
                            name='owns_home'
                            texton='Si'
                            textoff='No'
                            default='off'
                            :data='$data'
                        />
                    </div>
                    <div class="col-12 col-md-6">
                        <x-fieldnumber
                            label='Si alquila, ¿Cual es su monto de alquiler?'
                            name='rent'
                            min="1"
                            step=".01"
                            :data='$data'
                        />
                    </div>
                    <div class="col-12 col-md-6">
                        <x-fieldtext
                            label='¿Qué cree necesitar para mejorar su calidad habitacional?*'
                            name='housing_improvement'
                            placeholder='Respuesta'
                            :data='$data'
                        />
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Salud</h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="text-primary font-weight-bold text-uppercase">
                        &iquest;Tiene alguna de estas enfermedades?&ast;
                    </label>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Enfermedad</th>
                                <th>Respuesta</th>
                            </tr>
                        </thead>
                        <tbody>
                            @include('form::.data-updates.partials.row-switch', ['label' => 'Alzheimer', 'name' => 'has_alzheimer'])
                            @include('form::.data-updates.partials.row-switch', ['label' => 'Parkinson', 'name' => 'has_parkinson'])
                            @include('form::.data-updates.partials.row-switch', ['label' => 'Diabetes', 'name' => 'has_diabetes'])
                            @include('form::.data-updates.partials.row-switch', ['label' => 'Hipertensión', 'name' => 'has_hipertension'])
                            @include('form::.data-updates.partials.row-switch', ['label' => 'Tiroides', 'name' => 'has_thyroid_disease'])
                            @include('form::.data-updates.partials.row-switch', ['label' => 'Celiaquía', 'name' => 'has_celiac_disease'])
                            @include('form::.data-updates.partials.row-switch', ['label' => 'Depresión', 'name' => 'has_depression'])
                            @include('form::.data-updates.partials.row-switch', ['label' => 'Artrosis', 'name' => 'has_arthrosis'])
                            @include('form::.data-updates.partials.row-switch', ['label' => 'Auditivas', 'name' => 'has_hearing_disease'])
                            @include('form::.data-updates.partials.row-switch', ['label' => 'Cardíacas', 'name' => 'has_cardiac_disease'])
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <x-fieldswitch
                            label='¿Tiene indicada medicación por enfermedad crónica?*'
                            name='has_chronic_disease_medication'
                            texton='Si'
                            textoff='No'
                            default='off'
                            :data='$data'
                        />
                    </div>
                    <div class="col-12 col-md-6">
                        <x-fieldtext
                            label='Indicar medicación'
                            name='chronic_disease_medication'
                            placeholder='Indicar medicación'
                            :data='$data'
                        />
                    </div>
                    <div class="col-12 col-md-6">
                        <x-fieldswitch
                            label='¿Sufrió de ACV en el último tiempo?'
                            name='had_stroke_recently'
                            texton='Si'
                            textoff='No'
                            default='off'
                            :data='$data'
                        />
                    </div>
                    <div class="col-12 col-md-6">
                        <x-fieldselect
                            label='¿Con qué frecuencia visita a su médico?'
                            name='doctor_visit_frequency'
                            itemtext='value'
                            itemindex='value'
                            optionalText='Seleccionar frecuencia de visitas'
                            :data='$data'
                            :items='$model_info->doctor_visits'
                        />
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Contacto</h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <x-fieldtext
                            label='Nombre de su contacto de emergencia*'
                            name='emergency_contact_name'
                            placeholder='Nombre'
                            :data='$data'
                        />
                    </div>
                    <div class="col-12 col-md-6">
                        <x-fieldtext
                            label='Parentesco con su contacto de emergencia*'
                            name='emergency_contact_relationship'
                            placeholder='Parentesco'
                            :data='$data'
                        />
                    </div>
                    <div class="col-12 col-md-6">
                        <x-fieldtext
                            label='Teléfono de su contacto de emergencia*'
                            name='emergency_contact_phone'
                            placeholder='Teléfono'
                            :data='$data'
                        />
                    </div>
                    <div class="col-12 col-md-6">
                        <x-fieldemail
                            label='Email de su contacto de emergencia'
                            name='emergency_contact_email'
                            placeholder='Email'
                            :data='$data'
                        />
                    </div>
                </div>
                <div class="form-group">
                    <label class="text-primary font-weight-bold text-uppercase">
                        &iquest;Tiene acceso a alguna de estas redes o medios de comunicaci&oacute;n?
                    </label>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Red/Medio</th>
                                <th>Respuesta</th>
                            </tr>
                        </thead>
                        <tbody>
                            @include('form::.data-updates.partials.row-switch', ['label' => 'WhatsApp', 'name' => 'has_whatsapp'])
                            @include('form::.data-updates.partials.row-switch', ['label' => 'Facebook', 'name' => 'has_facebook'])
                            @include('form::.data-updates.partials.row-switch', ['label' => 'Email', 'name' => 'has_email'])
                            @include('form::.data-updates.partials.row-switch', ['label' => 'Instagram', 'name' => 'has_instagram'])
                            @include('form::.data-updates.partials.row-switch', ['label' => 'Home Banking', 'name' => 'has_home_banking'])
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <x-fieldtext
                    label='¿Quisiera hacernos una sugerencia u observación?'
                    name='suggestions'
                    placeholder='Sugerencia u observación'
                    :data='$data'
                />
            </div>
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-success">
                    Guardar <i class="mi-save ml-2"></i>
                </button>
                <a href="{{ route($model_info->routes['list']) }}" class="btn btn-danger">
                    Salir sin guardar <i class="mi-backspace ml-2"></i>
                </a>
            </div>
        </div>
    </form>
@endsection
