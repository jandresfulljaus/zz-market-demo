<?php

namespace Main\People\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RelativeRequest extends FormRequest
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
            'person_id' => 'required|exists:people_persons,id',
            'relative_id' => 'required|exists:people_persons,id|different:person_id',
            'relationship_a' => 'required|exists:people_family_relationships,id',
            'relationship_b' => 'required|exists:people_family_relationships,id'
        ];
    }

    public function attributes()
    {
        return [
            'person_id' => 'Vecino',
            'relative_id' => 'Familiar',
            'relationship_a' => 'Relación del vecino con el familiar',
            'relationship_b' => 'Relación del familiar con el vecino'
        ];
    }
}
