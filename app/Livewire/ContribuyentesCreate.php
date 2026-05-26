<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Contribuyente;
use Illuminate\Support\Facades\Auth;

class ContribuyentesCreate extends Component
{
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


    public function updated(): void
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
        }
    }
    public function guardar(): void
    {
        $this->validate([
            'tipo_persona' => ['required', 'in:FISICA,MORAL'],
            'rfc' => ['required', 'string', 'max:20', 'unique:contribuyentes,rfc'],
            'curp' => ['nullable', 'string', 'max:25'],
            'nombre' => ['nullable', 'string', 'max:255'],
            'apellido_paterno' => ['nullable', 'string', 'max:255'],
            'apellido_materno' => ['nullable', 'string', 'max:255'],
            'razon_social' => ['required', 'string', 'max:255'],
            'requiere_representante_legal' => ['boolean'],
            'nombre_representante_legal' => ['nullable', 'string', 'max:255'],
            'curp_representante_legal' => ['nullable', 'string', 'max:25'],
            'telefono_representante_legal' => ['nullable', 'digits:10'],
        ]);

        if ($this->tipo_persona === 'MORAL') {
            $this->requiere_representante_legal = true;
        }

        Contribuyente::create([
            'tipo_persona' => $this->tipo_persona,
            'rfc' => mb_strtoupper($this->rfc, 'UTF-8'),
            'curp' => mb_strtoupper($this->curp, 'UTF-8'),
            'nombre' => mb_strtoupper($this->nombre, 'UTF-8'),
            'apellido_paterno' => mb_strtoupper($this->apellido_paterno, 'UTF-8'),
            'apellido_materno' => mb_strtoupper($this->apellido_materno, 'UTF-8'),
            'razon_social' => mb_strtoupper($this->razon_social, 'UTF-8'),
            'requiere_representante_legal' => $this->requiere_representante_legal,
            'nombre_representante_legal' => mb_strtoupper($this->nombre_representante_legal, 'UTF-8'),
            'curp_representante_legal' => mb_strtoupper($this->curp_representante_legal, 'UTF-8'),
            'telefono_representante_legal' => $this->telefono_representante_legal,
            'activo' => true,
            'created_by' => Auth::id(),
        ]);

        session()->flash('success', 'CONTRIBUYENTE REGISTRADO CORRECTAMENTE.');

        $this->redirectRoute('contribuyentes.index');
    }

    public function render()
    {
        return view('livewire.contribuyentes-create');
    }
}