<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizaci&oacute;n de datos</title>
    <style>
        html {
            font-size: 12px;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0.5cm 0.5cm 0.5cm 2cm;
        }
        h1 {
            font-size: 1.5rem;
        }
        h2 {
            font-size: 1.25rem;
        }
        h3 {
            font-size: 1rem;
        }
        img {
            border: 0;
            margin: 0;
            padding: 0;
            max-width: 70%;
            page-break-inside: avoid;
        }
        header {
            margin-bottom: 3rem;
        }
        footer {
            margin-top: 7rem;
        }
        p {
            margin: 0.5rem 0;
        }
        footer h1 {
            border-top: 1px solid black;
            font-size: 1rem;
            font-style: italic;
            font-weight: normal;
            margin: 0 4rem;
            padding-top: 1rem;
            text-align: center;
        }
        table {
            background-color: transparent;
            border-collapse: collapse;
            border-spacing: 0;
        }
        .table {
            max-width: 100%;
            width: 100%;
        }
        .table>tbody>tr>td,.table>tbody>tr>th {
            border: 1px solid black;
            padding: 5px;
            font-size: 8px;
            text-align: center;
            vertical-align: middle;
        }
        .table>tbody>tr>th {
            background-color: #3c3c3c;
            color: #fff;
        }
        .pb-0 {
            padding-bottom: 0;
        }
        .mb-0 {
            margin-bottom: 0;
        }
        .mb-1 {
            margin-bottom: 1rem;
        }
        .row::after,row::before {
            content: " ";
            display: table;
        }
        .row::after {
            clear: both;
        }
        .col-2,.col-4,.col-6,.col-8,.col-10{
            float: left;
            min-height: 1px;
            position: relative;
        }
        .col-2{
            width:16.66666667%;
        }
        .col-4{
            width:33.33333333%;
        }
        .col-6 {
            width: 50%;
        }
        .col-8{
            width:66.66666667%;
        }
        .col-10{
            width:83.33333333%;
        }
        .text-center{text-align: center;}
        .font-italic {
            font-style: italic;
        }
    </style>
</head>
<body>
    <header>
        <div class="row">
            <div class="col-2">
                <img src="data:image/png;base64,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" />
            </div>
            <div class="col-10">
                <h1 class="mb-0">Caja Municipal de JUBILACIONES, PENSIONES y RETIRO</h1>
                <p class="mb-0">Gualeguaych&uacute; | Entre R&iacute;os</p>
            </div>
        </div>
        <div class="text-center">
            <h2 class="mb-0">Declaraci&oacute;n Jurada: Actualizaci&oacute;n de datos personales</h2>
        </div>
    </header>
    <main style="margin-top: -1.5rem;">
        <div class="row mb-1">
            <section class="col-6" style="box-sizing:border-box; padding-right: 1rem;">
                <h1>- Datos Personales</h1>
                <p>
                    <strong>Legajo:</strong>
                    {{ $data->personal_data['file'] }}
                </p>
                <p>
                    <strong>Apellido:</strong>
                    {{ $data->personal_data['surname'] }}
                </p>
                <p>
                    <strong>Nombre:</strong>
                    {{ $data->personal_data['name'] }}
                </p>
                <p>
                    <strong>DNI:</strong>
                    {{ $data->personal_data['dni'] }}
                </p>
                <p>
                    <strong>G&eacute;nero:</strong>
                    {{ $data->personal_data['gender'] }}
                </p>
                <p>
                    <strong>Fecha de nacimiento:</strong>
                    {{ \Carbon\Carbon::parse($data->personal_data['birthday'])->isoFormat('L') }}
                </p>
                <p>
                    <strong>Tel&eacute;fono:</strong>
                    {{ $data->personal_data['phone'] }}
                </p>
                <p>
                    <strong>Grado de escolaridad:</strong>
                    {{ $data->personal_data['education'] }}
                </p>
            </section>
            <section class="col-6">
                <h1>- Grupo Familiar</h1>
                <p>
                    <strong>Estado civil:</strong>
                    {{ $data->family_unit['marital_status'] }}
                </p>
                <p>
                    <strong>C&oacute;nyugue:</strong>
                    {{ $data->family_unit['spouse_name'] }}
                </p>
                <p>
                    <strong>&iquest;Tiene hijos?</strong>
                    {{ ((int) $data->family_unit['has_children']) ? 'Si' : 'No' }}
                </p>
                <p>
                    <strong>Cantidad de hijos:</strong>
                    {{ $data->family_unit['children_amount'] ?? '0' }}
                </p>
                <p>
                    <strong>Edad de hijos:</strong>
                    {{ $data->family_unit['children_age_range'] }}
                </p>
                <p>
                    <strong>&iquest;Tiene hijos con capacidades diferentes?</strong>
                    {{ ((int) $data->family_unit['has_children_with_disabilities']) ? 'Si.' : 'No.' }}
                    {{ $data->family_unit['children_disabilities'] }}
                </p>
            </section>
        </div>
        <div class="row mb-1">
            <section class="col-6" style="box-sizing:border-box; padding-right: 1rem;">
                <h1>- Contacto de Emergencia</h1>
                <p>
                    <strong>Nombre:</strong>
                    {{ $data->contact['emergency_contact_name'] }}
                </p>
                <p>
                    <strong>Parentesco:</strong>
                    {{ $data->contact['emergency_contact_relationship'] }}
                </p>
                <p>
                    <strong>Tel&eacute;fono:</strong>
                    {{ $data->contact['emergency_contact_phone'] }}
                </p>
                <p>
                    <strong>Email:</strong>
                    {{ $data->contact['emergency_contact_email'] }}
                </p>
                <p><strong>&iquest;Tiene acceso a alguna de estas redes o medios de comunicaci&oacute;n?</strong></p>
                <table class="table">
                    <tbody>
                        <tr>
                            <td>WhatsApp</td>
                            <td>Facebook</td>
                            <td>Email</td>
                            <td>Instagram</td>
                            <td>Home Banking</td>
                        </tr>
                        <tr>
                            <td>{{ ((int) $data->contact['has_whatsapp']) ? 'Si' : 'No' }}</td>
                            <td>{{ ((int) $data->contact['has_facebook']) ? 'Si' : 'No' }}</td>
                            <td>{{ ((int) $data->contact['has_email']) ? 'Si' : 'No' }}</td>
                            <td>{{ ((int) $data->contact['has_instagram']) ? 'Si' : 'No' }}</td>
                            <td>{{ ((int) $data->contact['has_home_banking']) ? 'Si' : 'No' }}</td>
                        </tr>
                    </tbody>
                </table>
            </section>
            <section class="col-6">
                <h1>- Vivienda</h1>
                <p>
                    <strong>Domicilio actual:</strong>
                    {{ $data->housing['address'] }}
                </p>
                <p>
                    <strong>&iquest;Posee vivienda propia?</strong>
                    {{ ((int) $data->housing['owns_home']) ? 'Si' : 'No' }}
                </p>
                <p>
                    <strong>Monto de alquiler:</strong>
                    {{ $data->housing['rent'] }}
                </p>
                <p>
                    <strong>&iquest;Vive con alguna persona?</strong>
                    {{ ((int) $data->housing['shares_home']) ? 'Si' : 'No' }}
                </p>
                <p>
                    <strong>&iquest;Qu&eacute; cree necesitar para mejorar su calidad habitacional?</strong>
                    {{ $data->housing['housing_improvement'] }}
                </p>
            </section>
        </div>
        <section>
            <h1>- Salud</h1>
            <p>
                <strong>&iquest;Tiene indicada medicaci&oacute;n por enfermedad cr&oacute;nica?</strong>
                {{ ((int) $data->health['has_chronic_disease_medication']) ? 'Si.' : 'No.' }}
                {{ $data->health['chronic_disease_medication'] }}
            </p>
            <p>
                <strong>&iquest;Con qu&eacute; frecuencia visita a su m&eacute;dico?</strong>
                {{ $data->health['doctor_visit_frequency'] }}
            </p>
            <p>
                <strong>&iquest;Sufri&oacute; ACV en el &uacute;ltimo tiempo?</strong>
                {{ ((int) $data->health['had_stroke_recently']) ? 'Si' : 'No' }}
            </p>
            <p><strong>&iquest;Tiene alguna de estas enfermedades?</strong></p>
            <table class="table">
                <tbody>
                    <tr>
                        <td>Alzheimer</td>
                        <td>Parkinson</td>
                        <td>Diabetes</td>
                        <td>Hipertensi&oacute;n</td>
                        <td>Tiroides</td>
                        <td>Celiaqu&iacute;a</td>
                        <td>Depresi&oacute;n</td>
                        <td>Artrosis</td>
                        <td>Auditivas</td>
                        <td>Card&iacute;aca</td>
                    </tr>
                    <tr>
                        <td>{{ ((int) $data->health['has_alzheimer']) ? 'Si' : 'No' }}</td>
                        <td>{{ ((int) $data->health['has_parkinson']) ? 'Si' : 'No' }}</td>
                        <td>{{ ((int) $data->health['has_diabetes']) ? 'Si' : 'No' }}</td>
                        <td>{{ ((int) $data->health['has_hipertension']) ? 'Si' : 'No' }}</td>
                        <td>{{ ((int) $data->health['has_thyroid_disease']) ? 'Si' : 'No' }}</td>
                        <td>{{ ((int) $data->health['has_celiac_disease']) ? 'Si' : 'No' }}</td>
                        <td>{{ ((int) $data->health['has_depression']) ? 'Si' : 'No' }}</td>
                        <td>{{ ((int) $data->health['has_arthrosis']) ? 'Si' : 'No' }}</td>
                        <td>{{ ((int) $data->health['has_hearing_disease']) ? 'Si' : 'No' }}</td>
                        <td>{{ ((int) $data->health['has_cardiac_disease']) ? 'Si' : 'No' }}</td>
                    </tr>
                </tbody>
            </table>
        </section>
    </main>
    <footer>
        <div class="row" style="padding-bottom: 1.125rem;">
            <div class="col-6">
                <h1>Firma Empleado</h1>
            </div>
            <div class="col-6">
                <h1>Firma Afiliado</h1>
            </div>
        </div>
        <div class="font-italic" style="font-size: 9px;">
            <p class="mb-0">
                Registro n&ordm;: {{ $data->id }},
                cargado por {{ $data->user->person->name }}
                el d&iacute;a {{ $data->created_at->isoFormat('L LT') }}
            </p>
            <p class="mb-0">
                Impreso por {{ $printed_by }}
                el d&iacute;a {{ now()->isoFormat('L LT') }}
            </p>
        </div>
    </footer>
</body>
</html>
