<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePersonalInformationResquest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'first_name' => ['required', 'string'],
            'second_name' => ['nullable', 'string'],
            'third_name' => ['nullable', 'string'],
            'first_last_name' => ['required', 'string'],
            'second_last_name' => ['nullable', 'string'],
            'married_name' => ['nullable', 'string'],
           
            'phone_number' => ['numeric' ],
            
            
        ];
    }
    public function messages(){
        return [
            'first_name.required' => 'El campo nombre es obligatorio',
            'first_name.string' => 'El campo nombre debe ser una cadena',
            'second_name.string' => 'El campo segundo nombre debe ser una cadena',
            'third_name.string' => 'El campo tercer nombre debe ser una cadena',
            'first_last_name.required' => 'El campo primer apellido es obligatorio',
            'first_last_name.string' => 'El campo primer apellido debe ser una cadena',
            'second_last_name.string' => 'El campo segundo apellido debe ser una cadena',
            'married_name.string' => 'El campo nombre en caso de matrimonio debe ser una cadena',
            'phone_number.numeric' => 'El número de teléfono debe ser numérico',
            'phone_number.unique' => 'El número de teléfono ya está en uso'
        ];
    }
}
