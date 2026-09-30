<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UsuariosIndex extends Component
{
    public $usuarioId;
    public $nombre = '';
    public $apellido_paterno = '';
    public $apellido_materno = '';
    public $email = '';
    public $role = '';
    public $password = '';
    public $password_confirmation = '';
    public $activo = true;
    public ?string $mensajeSuccess = null;
    public bool $mostrarModal = false;

    public function nuevo(): void
    {
        $this->resetFormulario();
        $this->mensajeSuccess = null;
        $this->mostrarModal = true;
    }

    public function cerrarModal(): void
    {
        $this->resetFormulario();
        $this->mostrarModal = false;
    }

    private function resetFormulario(): void
    {
        $this->reset([
            'usuarioId',
            'nombre',
            'apellido_paterno',
            'apellido_materno',
            'email',
            'role',
            'password',
            'password_confirmation',
        ]);

        $this->activo = true;
    }

    public function guardar(): void
    {
        $rules = [
            'nombre' => ['required', 'max:100'],
            'apellido_paterno' => ['required', 'max:100'],
            'email' => [
                'required',
                'email',
                'unique:users,email,' . $this->usuarioId,
            ],
            'role' => ['required'],
        ];

        if (! $this->usuarioId) {
            $rules['password'] = ['required', 'confirmed', 'min:8'];
        }

        $this->validate($rules);

        $name = trim(
            $this->nombre . ' ' .
            $this->apellido_paterno . ' ' .
            $this->apellido_materno
        );

        $datos = [
            'name' => $name,
            'nombre' => mb_strtoupper(trim($this->nombre), 'UTF-8'),
            'apellido_paterno' => mb_strtoupper(trim($this->apellido_paterno), 'UTF-8'),
            'apellido_materno' => mb_strtoupper(trim($this->apellido_materno), 'UTF-8'),
            'email' => strtolower(trim($this->email)),
            'activo' => $this->activo,
        ];

        if ($this->password) {
            $datos['password'] = Hash::make($this->password);
        }

        $user = User::updateOrCreate(
            ['id' => $this->usuarioId],
            $datos
        );

        $user->syncRoles([$this->role]);

        $this->cerrarModal();

        $this->mensajeSuccess =
            'USUARIO GUARDADO CORRECTAMENTE.';
    }

    public function editar(int $id): void
    {
        $this->mensajeSuccess = null;

        $user = User::findOrFail($id);

        $this->usuarioId = $user->id;
        $this->nombre = $user->nombre;
        $this->apellido_paterno = $user->apellido_paterno;
        $this->apellido_materno = $user->apellido_materno;
        $this->email = $user->email;
        $this->activo = $user->activo;

        $this->role = $user->roles->first()?->name;

        $this->mostrarModal = true;
    }

    public function cambiarEstatus(int $id): void
    {
        $user = User::findOrFail($id);

        $user->update([
            'activo' => ! $user->activo,
        ]);
    }

    public function render()
    {
        return view('livewire.usuarios-index', [
            'usuarios' => User::with('roles')
                ->orderBy('apellido_paterno')
                ->orderBy('apellido_materno')
                ->orderBy('nombre')
                ->get(),

            'roles' => Role::orderBy('name')->get(),
        ]);
    }
}