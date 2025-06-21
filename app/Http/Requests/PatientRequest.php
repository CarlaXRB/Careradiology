<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name_patient'=>['max:100','min:3'],
            'ci_patient' => ['required', 'numeric', 'unique:patients,ci_patient'],
            'patient_contact'=>['nullable','max:100'],
            'family_contact'=>['nullable','max:100']
        ];
    }
}
