<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreContribuyenteRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tipo_persona' => ['required', 'in:FISICA,MORAL'],

            'rfc' => ['required', 'string', 'max:20', 'unique:contribuyentes,rfc'],
            'curp' => ['nullable', 'string', 'max:25'],

            'nombre' => ['nullable', 'string', 'max:255'],
            'apellido_paterno' => ['nullable', 'string', 'max:255'],
            'apellido_materno' => ['nullable', 'string', 'max:255'],

            'razon_social' => ['required', 'string', 'max:255'],

            'correo_electronico' => ['nullable', 'email', 'max:255'],
            'telefono_movil' => ['nullable', 'string', 'max:25'],
            'cuenta_estatal' => ['nullable', 'string', 'max:50'],

            'requiere_representante_legal' => ['boolean'],

            'nombre_representante_legal' => [
                'nullable',
                'required_if:tipo_persona,MORAL',
                'string',
                'max:255',
            ],

            'curp_representante_legal' => ['nullable', 'string', 'max:25'],
            'telefono_representante_legal' => ['nullable', 'string', 'max:25'],

            'tipo_identificacion' => ['nullable', 'in:INE,PASAPORTE'],
            'clave_identificacion' => ['nullable', 'string', 'max:255'],

            'activo' => ['boolean'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if ($this->input('tipo_persona') === 'FISICA') {
                if (! $this->filled('nombre')) {
                    $validator->errors()->add('nombre', 'EL NOMBRE ES OBLIGATORIO PARA PERSONA FÍSICA.');
                }

                if (! $this->filled('apellido_paterno')) {
                    $validator->errors()->add('apellido_paterno', 'EL APELLIDO PATERNO ES OBLIGATORIO PARA PERSONA FÍSICA.');
                }

                if (! $this->filled('curp')) {
                    $validator->errors()->add('curp', 'LA CURP ES OBLIGATORIA PARA PERSONA FÍSICA.');
                }
            }

            if ($this->boolean('requiere_representante_legal')) {
                if (! $this->filled('nombre_representante_legal')) {
                    $validator->errors()->add('nombre_representante_legal', 'EL REPRESENTANTE LEGAL ES OBLIGATORIO.');
                }
            }
        });
    }
}
