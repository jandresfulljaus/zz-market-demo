<?php

namespace Modules\Form\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DataUpdateRequest extends FormRequest
{
    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;

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
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'has_children' => (isset($this->has_children) && $this->has_children === 'on') ? 1 : 0,
            'has_children_with_disabilities' => (isset($this->has_children_with_disabilities) && $this->has_children_with_disabilities === 'on') ? 1 : 0,
            'owns_home' => (isset($this->owns_home) && $this->owns_home === 'on') ? 1 : 0,
            'shares_home' => (isset($this->shares_home) && $this->shares_home === 'on') ? 1 : 0,
            'has_alzheimer' => (isset($this->has_alzheimer) && $this->has_alzheimer === 'on') ? 1 : 0,
            'has_parkinson' => (isset($this->has_parkinson) && $this->has_parkinson === 'on') ? 1 : 0,
            'has_diabetes' => (isset($this->has_diabetes) && $this->has_diabetes === 'on') ? 1 : 0,
            'has_hipertension' => (isset($this->has_hipertension) && $this->has_hipertension === 'on') ? 1 : 0,
            'has_thyroid_disease' => (isset($this->has_thyroid_disease) && $this->has_thyroid_disease === 'on') ? 1 : 0,
            'has_celiac_disease' => (isset($this->has_celiac_disease) && $this->has_celiac_disease === 'on') ? 1 : 0,
            'has_depression' => (isset($this->has_depression) && $this->has_depression === 'on') ? 1 : 0,
            'has_arthrosis' => (isset($this->has_arthrosis) && $this->has_arthrosis === 'on') ? 1 : 0,
            'has_hearing_disease' => (isset($this->has_hearing_disease) && $this->has_hearing_disease === 'on') ? 1 : 0,
            'has_cardiac_disease' => (isset($this->has_cardiac_disease) && $this->has_cardiac_disease === 'on') ? 1 : 0,
            'had_stroke_recently' => (isset($this->had_stroke_recently) && $this->had_stroke_recently === 'on') ? 1 : 0,
            'has_chronic_disease_medication' => (isset($this->has_chronic_disease_medication) && $this->has_chronic_disease_medication === 'on') ? 1 : 0,
            'has_whatsapp' => (isset($this->has_whatsapp) && $this->has_whatsapp === 'on') ? 1 : 0,
            'has_facebook' => (isset($this->has_facebook) && $this->has_facebook === 'on') ? 1 : 0,
            'has_email' => (isset($this->has_email) && $this->has_email === 'on') ? 1 : 0,
            'has_instagram' => (isset($this->has_instagram) && $this->has_instagram === 'on') ? 1 : 0,
            'has_home_banking' => (isset($this->has_home_banking) && $this->has_home_banking === 'on') ? 1 : 0,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'surname' => ['required', 'string', 'max:100'],
            'name' => ['required', 'string', 'max:100'],
            'dni' => ['required', 'string', 'max:16'],
            'file' => ['required', 'numeric', 'gt:0'],
            'gender' => ['required'],
            'birthday' => ['required', 'date'],
            'phone' => ['required', 'string', 'max:40'],
            'education' => ['required'],
            'marital_status' => ['required'],
            'spouse_name' => ['nullable', 'string', 'max:200'],
            'has_children' => ['boolean'],
            'children_amount' => ['nullable', 'integer'],
            'children_age_range' => ['nullable'],
            'has_children_with_disabilities' => ['boolean'],
            'children_disabilities' => ['nullable', 'string', 'max:200'],
            'address' => ['required', 'string', 'max:200'],
            'owns_home' => ['boolean'],
            'rent' => ['nullable', 'numeric'],
            'shares_home' => ['boolean'],
            'housing_improvement' => ['required', 'string'],
            'has_alzheimer' => ['boolean'],
            'has_parkinson' => ['boolean'],
            'has_diabetes' => ['boolean'],
            'has_hipertension' => ['boolean'],
            'has_thyroid_disease' => ['boolean'],
            'has_celiac_disease' => ['boolean'],
            'has_depression' => ['boolean'],
            'has_arthrosis' => ['boolean'],
            'has_hearing_disease' => ['boolean'],
            'has_cardiac_disease' => ['boolean'],
            'had_stroke_recently' => ['boolean'],
            'has_chronic_disease_medication' => ['boolean'],
            'chronic_disease_medication' => ['nullable', 'string', 'max:200'],
            'doctor_visit_frequency' => ['nullable'],
            'emergency_contact_name' => ['required', 'string', 'max:200'],
            'emergency_contact_relationship' => ['required', 'string', 'max:50'],
            'emergency_contact_phone' => ['required', 'string', 'max:40'],
            'emergency_contact_email' => ['nullable', 'email'],
            'has_whatsapp' => ['boolean'],
            'has_facebook' => ['boolean'],
            'has_email' => ['boolean'],
            'has_instagram' => ['boolean'],
            'has_home_banking' => ['boolean'],
            'suggestions' => ['nullable', 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            'surname' => 'Apellido',
            'name' => 'Nombre',
            'dni' => 'DNI',
            'file' => 'Legajo',
            'gender' => 'Género',
            'birthday' => 'Fecha de nacimiento',
            'phone' => 'Teléfono',
            'education' => 'Grado de escolaridad',
            'marital_status' => 'Estado civil',
            'spouse_name' => 'Nombre de su cónyugue',
            'has_children' => '¿Tiene hijos?',
            'children_amount' => 'Cantidad de hijos',
            'children_age_range' => '¿Cuál es la edad de sus hijos?',
            'has_children_with_disabilities' => '¿Tiene hijos con capacidades diferentes?',
            'children_disabilities' => 'Indicar capacidades diferentes',
            'address' => 'Domicilio actual',
            'owns_home' => '¿Posee vivienda propia?',
            'rent' => 'Monto de alquiler',
            'shares_home' => '¿Vive con más personas en su vivienda?',
            'housing_improvement' => '¿Qué cree necesitar para mejorar su calidad habitacional?',
            'has_alzheimer' => 'Alzheimer',
            'has_parkinson' => 'Parkinson',
            'has_diabetes' => 'Diabetes',
            'has_hipertension' => 'Hipertensión',
            'has_thyroid_disease' => 'Tiroides',
            'has_celiac_disease' => 'Celiaquía',
            'has_depression' => 'Depresión?',
            'has_arthrosis' => 'Artrosis?',
            'has_hearing_disease' => 'Auditivas',
            'has_cardiac_disease' => 'Cardíacas',
            'had_stroke_recently' => '¿Sufrió de ACV en el último tiempo?',
            'has_chronic_disease_medication' => '¿Le han indicado alguna medicación por enfermedad crónica?',
            'chronic_disease_medication' => 'Medicación Indicada',
            'doctor_visit_frequency' => '¿Con qué frecuencia visita a su médico?',
            'emergency_contact_name' => 'Nombre (contacto de emergencia)',
            'emergency_contact_relationship' => 'Parentesco (contacto de emergencia)',
            'emergency_contact_phone' => 'Teléfono (contacto de emergencia)',
            'emergency_contact_email' => 'Email (contacto de emergencia)',
            'has_whatsapp' => 'WhatsApp',
            'has_facebook' => 'Facebook',
            'has_email' => 'Hotmail - Gmail',
            'has_instagram' => 'Instagram',
            'has_home_banking' => 'Home Banking',
            'suggestions' => 'Sugerencias',
        ];
    }
}
