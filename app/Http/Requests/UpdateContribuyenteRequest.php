<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateContribuyenteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $contribuyenteId = $this->route('contribuyente')?->id ?? $this->route('contribuyente');

        return [
            'tipo_persona' => ['required', 'in:FISICA,MORAL'],

            'rfc' => [
                'required',
                'string',
                'max:20',
                Rule::unique('contribuyentes', 'rfc')->ignore($contribuyenteId),
            ],

            'curp' => ['nullable', 'string', 'max:25'],

            'nombre' => ['nullable', 'string', 'max:255'],
            'apellido_paterno' => ['nullable', 'string', 'max:255'],
            'apellido_materno' => ['nullable', 'string', 'max:255'],

            'razon_social' => ['required', 'string', 'max:255'],

            'correo_electronico' => ['nullable', 'email', 'max:255'],
            'telefono_movil' => ['nullable', 'digits:10'],
            'cuenta_estatal' => ['nullable', 'string', 'max:50'],

            'requiere_representante_legal' => ['boolean'],

            'nombre_representante_legal' => ['nullable', 'string', 'max:255'],
            'curp_representante_legal' => ['nullable', 'string', 'max:25'],
            'telefono_representante_legal' => ['nullable', 'digits:10'],

            'tipo_identificacion' => ['nullable', 'in:INE,PASAPORTE'],
            'clave_identificacion' => ['nullable', 'string', 'max:255'],

            'activo' => ['boolean'],
        ];
    }
}
