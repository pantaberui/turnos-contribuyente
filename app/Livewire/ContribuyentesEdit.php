<?php

namespace App\Livewire;

use App\Models\Contribuyente;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ContribuyentesEdit extends Component
{
    public Contribuyente $contribuyente;

    public string $tipo_persona = 'FISICA';

    public string $rfc = '';
    public string $curp = '';

    public string $nombre = '';
    public string $apellido_paterno = '';
    public string $apellido_materno = '';

    public string $razon_social = '';

    public bool $requiere_representante_legal = false;

    public string $nombre_representante_legal = '';
    public string $curp_representante_legal = '';
    public string $telefono_representante_legal = '';

    public string $correo_electronico = '';
    public string $telefono_movil = '';

    public string $cuenta_estatal = '';

    public string $tipo_identificacion = '';
    public string $clave_identificacion = '';

    public function updatedNombre(): void
    {
        $this->actualizarRazonSocial();
    }

    public function updatedApellidoPaterno(): void
    {
        $this->actualizarRazonSocial();
    }

    public function updatedApellidoMaterno(): void
    {
        $this->actualizarRazonSocial();
    }

    private function actualizarRazonSocial(): void
    {
        if ($this->tipo_persona === 'FISICA') {
            $this->razon_social = trim(
                mb_strtoupper(
                    "{$this->nombre} {$this->apellido_paterno} {$this->apellido_materno}",
                    'UTF-8'
                )
            );
        }
    }

    public function updatedTipoPersona(): void
    {
        if ($this->tipo_persona === 'MORAL') {
            $this->requiere_representante_legal = true;

            $this->curp = '';
            $this->nombre = '';
            $this->apellido_paterno = '';
            $this->apellido_materno = '';
            $this->razon_social = '';
        }
    }


    public function mount(Contribuyente $contribuyente): void
    {
        $this->contribuyente = $contribuyente;

        $this->tipo_persona = $contribuyente->tipo_persona;

        $this->rfc = $contribuyente->rfc;
        $this->curp = $contribuyente->curp ?? '';

        $this->nombre = $contribuyente->nombre ?? '';
        $this->apellido_paterno = $contribuyente->apellido_paterno ?? '';
        $this->apellido_materno = $contribuyente->apellido_materno ?? '';

        $this->razon_social = $contribuyente->razon_social;

        $this->requiere_representante_legal =
            $contribuyente->requiere_representante_legal;

        $this->nombre_representante_legal =
            $contribuyente->nombre_representante_legal ?? '';

        $this->curp_representante_legal =
            $contribuyente->curp_representante_legal ?? '';

        $this->telefono_representante_legal =
            $contribuyente->telefono_representante_legal ?? '';

        $this->correo_electronico =
            $contribuyente->correo_electronico ?? '';

        $this->telefono_movil =
            $contribuyente->telefono_movil ?? '';

        $this->cuenta_estatal =
            $contribuyente->cuenta_estatal ?? '';

        $this->tipo_identificacion =
            $contribuyente->tipo_identificacion ?? '';

        $this->clave_identificacion =
            $contribuyente->clave_identificacion ?? '';
    }

    public function actualizar(): void
    {
        $this->rfc = mb_strtoupper(trim($this->rfc), 'UTF-8');
        $this->curp = $this->curp ? mb_strtoupper(trim($this->curp), 'UTF-8') : '';
        $this->curp_representante_legal = $this->curp_representante_legal
            ? mb_strtoupper(trim($this->curp_representante_legal), 'UTF-8')
            : '';

        if ($this->tipo_persona === 'FISICA') {
            $this->actualizarRazonSocial();
        }    

         $this->validate(
            [
                'tipo_persona' => ['required', 'in:FISICA,MORAL'],

                'rfc' => [
                    'required',
                    'string',
                    Rule::unique('contribuyentes', 'rfc')
                        ->ignore($this->contribuyente->id),                   
                    function ($attribute, $value, $fail) {
                        $rfc = mb_strtoupper(trim($value), 'UTF-8');

                        if ($this->tipo_persona === 'FISICA') {
                            if (! preg_match('/^[A-ZÑ&]{4}\d{6}[A-Z0-9]{3}$/', $rfc)) {
                                $fail('EL RFC DE PERSONA FÍSICA DEBE TENER UN FORMATO VÁLIDO.');
                            }
                        }

                        if ($this->tipo_persona === 'MORAL') {
                            if (! preg_match('/^[A-ZÑ&]{3}\d{6}[A-Z0-9]{3}$/', $rfc)) {
                                $fail('EL RFC DE PERSONA MORAL DEBE TENER UN FORMATO VÁLIDO.');
                            }
                        }
                    },
                ],

                'curp' => [
                Rule::requiredIf($this->tipo_persona === 'FISICA'),
                'nullable',
                'string',
                Rule::unique('contribuyentes', 'curp')
                    ->ignore($this->contribuyente->id),        
                    function ($attribute, $value, $fail) {
                        if (blank($value)) {
                            return;
                        }

                        $curp = mb_strtoupper(trim($value), 'UTF-8');

                        if (! preg_match('/^[A-Z][AEIOU][A-Z]{2}\d{6}[HM][A-Z]{5}[A-Z0-9]\d$/', $curp)) {
                            $fail('LA CURP DEBE TENER 18 CARACTERES CON FORMATO VÁLIDO.');
                        }
                    },
                ],

                'nombre' => [
                    'nullable',
                    'string',
                    'max:255',
                    'regex:/^[\pL\s.]+$/u',
                ],

                'apellido_paterno' => [
                    'nullable',
                    'string',
                    'max:255',
                    'regex:/^[\pL\s]+$/u',
                ],

                'apellido_materno' => [
                    'nullable',
                    'string',
                    'max:255',
                    'regex:/^[\pL\s]+$/u',
                ],

                'razon_social' => ['required', 'string', 'max:255'],
                'requiere_representante_legal' => ['boolean'],
                'nombre_representante_legal' => ['nullable', 'string', 'max:255'],

                'curp_representante_legal' => [
                    'required_if:requiere_representante_legal,true',
                    'nullable',
                    'string',
                    function ($attribute, $value, $fail) {
                        if (blank($value)) {
                            return;
                        }

                        $curp = mb_strtoupper(trim($value), 'UTF-8');

                        if (! preg_match('/^[A-Z][AEIOU][A-Z]{2}\d{6}[HM][A-Z]{5}[A-Z0-9]\d$/', $curp)) {
                            $fail('LA CURP DEL REPRESENTANTE LEGAL DEBE TENER FORMATO VÁLIDO.');
                        }
                    },
                ],

                'telefono_representante_legal' => [
                    'required_if:requiere_representante_legal,1',
                    'digits:10',
                ],

                'correo_electronico' => ['nullable', 'email', 'max:255'],
                'telefono_movil' => ['nullable', 'digits:10'],
                'cuenta_estatal' => ['nullable', 'string', 'max:50'],

                'tipo_identificacion' => [
                    Rule::requiredIf($this->tipo_persona === 'FISICA'),
                    'nullable',
                    'in:INE,PASAPORTE',
                ],

                'clave_identificacion' => [
                    Rule::requiredIf($this->tipo_persona === 'FISICA'),
                    'nullable',
                    'string',
                    'max:255',
                ],
            ],
            [
                'rfc.required' => 'EL RFC ES OBLIGATORIO.',
                'rfc.unique' => 'YA EXISTE UN CONTRIBUYENTE REGISTRADO CON ESE RFC.',

                'curp.required' => 'LA CURP ES OBLIGATORIA.',
                'curp.unique' => 'YA EXISTE UN CONTRIBUYENTE REGISTRADO CON ESA CURP.',
                
                'nombre.regex' => 'EL NOMBRE SOLO DEBE CONTENER LETRAS, ESPACIOS Y PUNTO.',
                'apellido_paterno.regex' => 'EL APELLIDO PATERNO SOLO DEBE CONTENER LETRAS Y ESPACIOS.',
                'apellido_materno.regex' => 'EL APELLIDO MATERNO SOLO DEBE CONTENER LETRAS Y ESPACIOS.',

                'telefono_representante_legal.required_if' => 'EL TELÉFONO DEL REPRESENTANTE LEGAL ES OBLIGATORIO.',
                'telefono_representante_legal.digits' => 'EL TELÉFONO DEL REPRESENTANTE LEGAL DEBE CONTENER 10 DÍGITOS.',

                'correo_electronico.email' => 'EL CORREO ELECTRÓNICO NO ES VÁLIDO.',
                'telefono_movil.digits' => 'EL TELÉFONO MÓVIL DEBE CONTENER 10 DÍGITOS.',

                'tipo_identificacion.required' => 'EL TIPO DE IDENTIFICACIÓN ES OBLIGATORIO.',
                'clave_identificacion.required' => 'LA CLAVE DE IDENTIFICACIÓN ES OBLIGATORIA.',
            ]
        );

        $this->contribuyente->update([
            'tipo_persona' => $this->tipo_persona,

            'rfc' => mb_strtoupper($this->rfc, 'UTF-8'),
            'curp' => $this->curp ? mb_strtoupper($this->curp, 'UTF-8') : null,
            'nombre' => $this->nombre ? mb_strtoupper($this->nombre, 'UTF-8') : null,
            'apellido_paterno' => $this->apellido_paterno ? mb_strtoupper($this->apellido_paterno, 'UTF-8') : null,
            'apellido_materno' => $this->apellido_materno ? mb_strtoupper($this->apellido_materno, 'UTF-8') : null,

            'razon_social' => mb_strtoupper($this->razon_social, 'UTF-8'),

            'correo_electronico' => $this->correo_electronico,
            'telefono_movil' => $this->telefono_movil,

            'cuenta_estatal' => $this->cuenta_estatal
                ? mb_strtoupper($this->cuenta_estatal, 'UTF-8')
                : null,

            'requiere_representante_legal' => $this->requiere_representante_legal,

            'nombre_representante_legal' => $this->nombre_representante_legal
                ? mb_strtoupper($this->nombre_representante_legal, 'UTF-8')
                : null,

            'curp_representante_legal' => $this->curp_representante_legal
                ? mb_strtoupper($this->curp_representante_legal, 'UTF-8')
                : null,

            'telefono_representante_legal' =>
                $this->telefono_representante_legal,

            'tipo_identificacion' =>
                $this->tipo_identificacion ?: null,

            'clave_identificacion' =>
                $this->clave_identificacion
                    ? mb_strtoupper($this->clave_identificacion, 'UTF-8')
                    : null,

            'updated_by' => Auth::id(),
        ]);

        session()->flash(
            'success',
            'CONTRIBUYENTE ACTUALIZADO CORRECTAMENTE.'
        );

        $this->redirectRoute('contribuyentes.index');
    }

    public function render()
    {
        return view('livewire.contribuyentes-edit');
    }
}