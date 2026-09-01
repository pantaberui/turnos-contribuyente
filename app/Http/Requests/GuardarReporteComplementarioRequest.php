<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuardarReporteComplementarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'asesor_id' => ['required', 'exists:users,id'],

            'fecha_inicio' => ['required', 'date'],
            'fecha_fin' => ['required', 'date'],

            'tipo_periodo' => ['required', 'string', 'max:30'],

            'talleres_rif' => ['required', 'integer', 'min:0'],
            'talleres_estatales' => ['required', 'integer', 'min:0'],
            'proyectos_realizados' => ['required', 'integer', 'min:0'],

            'actividades_adicionales' => [
                'nullable',
                'string',
                'max:3000',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'talleres_rif' => 'talleres fiscales RIF',
            'talleres_estatales' => 'talleres fiscales estatales',
            'proyectos_realizados' => 'proyectos realizados',
            'actividades_adicionales' => 'actividades adicionales',
        ];
    }
}
