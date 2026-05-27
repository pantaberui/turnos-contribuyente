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
        if ($this->tipo_persona === 'FISICA') {
            $this->actualizarRazonSocial();
        }    

        $this->validate([
            'rfc' => [
                'required',
                'max:20',
                Rule::unique('contribuyentes', 'rfc')
                    ->ignore($this->contribuyente->id),
            ],
        ]);

        $this->contribuyente->update([
            'tipo_persona' => $this->tipo_persona,

            'rfc' => mb_strtoupper($this->rfc, 'UTF-8'),
            'curp' => mb_strtoupper($this->curp, 'UTF-8'),

            'nombre' => mb_strtoupper($this->nombre, 'UTF-8'),
            'apellido_paterno' => mb_strtoupper($this->apellido_paterno, 'UTF-8'),
            'apellido_materno' => mb_strtoupper($this->apellido_materno, 'UTF-8'),

            'razon_social' => mb_strtoupper($this->razon_social, 'UTF-8'),

            'correo_electronico' => $this->correo_electronico,
            'telefono_movil' => $this->telefono_movil,

            'cuenta_estatal' => mb_strtoupper($this->cuenta_estatal, 'UTF-8'),

            'requiere_representante_legal' => $this->requiere_representante_legal,

            'nombre_representante_legal' =>
                mb_strtoupper($this->nombre_representante_legal, 'UTF-8'),

            'curp_representante_legal' =>
                mb_strtoupper($this->curp_representante_legal, 'UTF-8'),

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