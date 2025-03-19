<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePersonalInformationRequest extends FormRequest
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
            'second_last_name' => ['nullable','string'],
            'married_name' => ['nullable', 'string'],
            'phone_number' => ['required', 'integer'],
            'image' => ['nullable', 'file','mimes:jpeg,png,jpg','max:5120'],
             'user_id' => 'required|exists:users,id'
            
            
        ];
    }
    public function messages(): array{
        return [
            'first_name.required' => 'El campo nombre es obligatorio',
            'first_name.string' => 'El campo nombre debe ser una cadena',
            'second_name.string' => 'El campo segundo nombre debe ser una cadena',
            'third_name.string' => 'El campo tercer nombre debe ser una cadena',
            'first_last_name.required' => 'El campo primer apellido es obligatorio',
            'first_last_name.string' => 'El campo primer apellido debe ser una cadena',
            'second_last_name.string' => 'El campo segundo apellido debe ser una cadena',
            'married_name.string' => 'El campo nombre en caso de matrimonio debe ser una cadena',
            'phone_number.required' => 'El campo número de teléfono es obligatorio',
            'phone_number.integer' => 'El campo número de teléfono debe ser un número',
            'image.file' => 'El campo imagen debe ser un archivo',
            'image.mimes' => 'El campo imagen debe ser un archivo con extensión jpeg, png o jpg',
            'image.max' => 'El tamaño del archivo imagen debe ser menor a 5MB',
            'user_id.required' => 'El campo usuario es obligatorio',
            'user_id.exists' => 'El usuario no existe'
        ];
    }
    public function prepareForValidation(){
        $this->merge([
            'user_id'=> auth()->user()->id
        ]);
    }

}
