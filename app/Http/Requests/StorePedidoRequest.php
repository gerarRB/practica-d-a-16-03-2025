<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePedidoRequest extends FormRequest
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
            "fecha_pedido"=>["required","date"],
            "client_id"=>["required","exists:mnt_clientes,id"],
            "product_id"=>["required","exists:ctl_productos,id"],
            "cantidad"=>["required","numeric"],
            "precio"=>["required","numeric"],
        ];
    }
    public function messages(): array{
        return [
            "fecha_pedido.required"=>"la fecha de pedido es obligatoria",
            "fecha_pedido.date"=>"La fecha debe de ser formato de fecha",
            "client_id.required"=>"El cliente es requerido",
            "client_id.exists"=> "El cliente debe estar registrado",
            "product_id.required"=>"El producto es obligatorio",
            "product_id.exists"=>"Seleccione un producto existente",
            "cantidad.required"=> "La cantidad es obligatoria",
            "cantidad.numeric"=> "la cantidad debe ser un numero",
            "precio.required"=>"El precio es obligatorio",
            "precio.numeric"=>"El precio debe de ser un numero"
        ];
    }
}
