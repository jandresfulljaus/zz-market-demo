<?php

namespace Main\People\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:200',
            'typedni' => 'required|string|max:6',
            'dni' => 'required|string|max:10',
            'cuit' => 'nullable|string|max:13',
            'birthday' => 'nullable|date',
            'address' => 'nullable|string|max:200',
            'city_id' => 'required|exists:geo_cities,id',
            'gender_id' => 'required|exists:people_genders,id',
            'guardian_id' => 'nullable|exists:people_persons,id',
            'marital_status_id' => 'nullable|exists:people_marital_statuses,id',
            'employment_status_id' => 'nullable|exists:people_employment_statuses,id',
            'health_insurance_id' => 'nullable|exists:insurance_health_insurances,id',
            'phone' => 'nullable|string|max:40',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nombre',
            'typedni' => 'Tipo de documento',
            'dni' => 'Nro. de documento',
            'cuit' => 'CUIT/CUIL',
            'birthday' => 'Fecha de nacimiento',
            'address' => 'Dirección',
            'city_id' => 'Ciudad',
            'guardian_id' => 'Persona a Cargo',
            'marital_status_id' => 'Estado Civil',
            'employment_status_id' => 'Condición Laboral',
            'health_insurance_id' => 'Obra Social',
            'phone' => 'Teléfono',
            'latitude' => 'Latitud',
            'longitude' => 'Longitud',
        ];
    }
}
