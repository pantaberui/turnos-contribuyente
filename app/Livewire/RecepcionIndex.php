<?php

namespace App\Livewire;

use App\Models\Contribuyente;
use Livewire\Component;
use App\Models\Asistencia;
use Illuminate\Support\Facades\Auth;
use App\Models\TipoTramite;
use App\Models\Turno;
use App\Models\TurnoContribuyente;


class RecepcionIndex extends Component
{
    public string $buscar = '';
    public string $buscarEjecutado = '';

    public ?int $contribuyenteSeleccionadoId = null;
    public ?Contribuyente $contribuyenteSeleccionado = null;
    public string $modalidad_id = '1';
    public ?int $asistenciaActivaId = null;

    public string $tipo_tramite_id = '';
    public string $observaciones = '';
    public bool $requiere_turno = false;

    public string $buscarContribuyenteAdicional = '';
    public string $buscarContribuyenteAdicionalEjecutado = '';
    public array $lista_contribuyentes = [];
    public ?int $turnoGeneradoId = null;
    public int $mensajeContribuyenteAdicionalKey = 0;

    public ?string $mensajeFinalizacion = null;
    public bool $asistenciaFinalizadaSinTurno = false;


    public function getContribuyentesProperty()
    {
        if (strlen(trim($this->buscarEjecutado)) < 2) {
            return collect();
        }

        $buscar = mb_strtoupper(trim($this->buscarEjecutado), 'UTF-8');

        return Contribuyente::query()
            ->where('activo', true)
            ->where(function ($q) use ($buscar) {
                $q->where('rfc', 'like', "%{$buscar}%")
                    ->orWhere('curp', 'like', "%{$buscar}%")
                    ->orWhere('razon_social', 'like', "%{$buscar}%");
            })
            ->orderBy('razon_social')
            ->limit(10)
            ->get();
    }

    public function buscarContribuyentes(): void
    {
        $this->buscarEjecutado = trim($this->buscar);
    }

    public function getContribuyentesAdicionalesProperty()
    {
        if (strlen(trim($this->buscarContribuyenteAdicionalEjecutado)) < 2) {
            return collect();
        }

        $buscar = mb_strtoupper(
            trim($this->buscarContribuyenteAdicionalEjecutado),
            'UTF-8'
        );

        return Contribuyente::query()
            ->where('activo', true)
            ->where(function ($q) use ($buscar) {
                $q->where('rfc', 'like', "%{$buscar}%")
                    ->orWhere('curp', 'like', "%{$buscar}%")
                    ->orWhere('razon_social', 'like', "%{$buscar}%");
            })
            ->orderBy('razon_social')
            ->limit(10)
            ->get();
    }

    public function buscarContribuyentesAdicionales(): void
    {
        $this->buscarContribuyenteAdicionalEjecutado =
            trim($this->buscarContribuyenteAdicional);
    }

    public ?string $mensajeContribuyenteAdicional = null;

    public function agregarContribuyenteAdicionalDesdeBD(int $contribuyenteId): void
    {
        $this->mensajeContribuyenteAdicional = null;

        $contribuyente = Contribuyente::findOrFail($contribuyenteId);

        $asistenciaActiva = $this->asistenciaActiva;

        if (
            $asistenciaActiva &&
            $contribuyente->id === $asistenciaActiva->contribuyente_id
        ) {
            $this->mensajeContribuyenteAdicional = 'NO PUEDES AGREGAR AL CONTRIBUYENTE PRINCIPAL COMO ADICIONAL.';
            return;
        }

        foreach ($this->lista_contribuyentes as $item) {
            if (($item['id'] ?? null) === $contribuyente->id) {
                $this->mensajeContribuyenteAdicional = 'EL CONTRIBUYENTE YA SE ENCUENTRA AGREGADO EN LA LISTA.';
                $this->mensajeContribuyenteAdicionalKey++;
                return;
            }
        }

        $this->lista_contribuyentes[] = [
            'id' => $contribuyente->id,
            'rfc' => $contribuyente->rfc,
            'nombre' => $contribuyente->razon_social,
        ];

        $this->buscarContribuyenteAdicional = '';
        $this->buscarContribuyenteAdicionalEjecutado = '';
        $this->mensajeContribuyenteAdicional = "SE AGREGÓ {$contribuyente->razon_social} A LA LISTA.";
        $this->mensajeContribuyenteAdicionalKey++;
    }

    public function eliminarContribuyenteAdicional(int $index): void
    {
        unset($this->lista_contribuyentes[$index]);

        $this->lista_contribuyentes = array_values($this->lista_contribuyentes);

        $this->mensajeContribuyenteAdicional = 'CONTRIBUYENTE ELIMINADO DE LA LISTA.';
    }

    public function iniciarAsistencia(): void
    {
        $fecha = now()->toDateString();

        $ultimoNumero = Asistencia::query()
            ->whereDate('fecha', $fecha)
            ->max('numero_asistencia');

        $numeroAsistencia = ($ultimoNumero ?? 0) + 1;

        $asistencia = Asistencia::create([
            'contribuyente_id' => null,
            'orientador_id' => Auth::id(),
            'modalidad_id' => $this->modalidad_id,
            'fecha' => $fecha,
            'numero_asistencia' => $numeroAsistencia,
            'hora_inicio' => now()->format('H:i:s'),
            'requiere_turno' => false,
        ]);

        $this->asistenciaActivaId = $asistencia->id;

        session()->flash(
            'success',
            "ASISTENCIA #{$asistencia->numero_asistencia} INICIADA CORRECTAMENTE."
        );
    }

    public function registrarNuevoContribuyentePrincipal(): void
    {
        $asistencia = $this->asistenciaActiva;

        if (! $asistencia) {
            return;
        }

        session()->put('recepcion_registro_contexto', [
            'origen' => 'principal',
            'asistencia_id' => $asistencia->id,
            'tipo_tramite_id' => $this->tipo_tramite_id,
            'requiere_turno' => $this->requiere_turno,
            'observaciones' => $this->observaciones,
            'lista_contribuyentes' => $this->lista_contribuyentes,
        ]);

        $this->redirectRoute('contribuyentes.create', [
            'return' => 'recepcion',
        ]);
    }

    public function registrarNuevoContribuyenteAdicional(): void
    {
        $asistencia = $this->asistenciaActiva;

        if (! $asistencia) {
            return;
        }

        session()->put('recepcion_registro_contexto', [
            'origen' => 'adicional',
            'asistencia_id' => $asistencia->id,
            'tipo_tramite_id' => $this->tipo_tramite_id,
            'requiere_turno' => $this->requiere_turno,
            'observaciones' => $this->observaciones,
            'lista_contribuyentes' => $this->lista_contribuyentes,
        ]);

        $this->redirectRoute('contribuyentes.create', [
            'return' => 'recepcion',
        ]);
    }

    public function seleccionarContribuyenteParaAsistencia(int $contribuyenteId): void
    {
        $asistencia = $this->asistenciaActiva;

        if (! $asistencia) {
            return;
        }

        $contribuyente = Contribuyente::findOrFail($contribuyenteId);

        $asistencia->update([
            'contribuyente_id' => $contribuyente->id,
        ]);

        unset($this->asistenciaActiva);
        $this->buscar = '';
        $this->buscarEjecutado = '';
    }

    public function finalizarAsistencia(): void
    {
        $asistencia = $this->asistenciaActiva;
        if (! $asistencia) {
            return;
        }

        $this->validate([
            'tipo_tramite_id' => ['required'],
        ], [
            'tipo_tramite_id.required' => 'EL TIPO DE TRÁMITE ES OBLIGATORIO.',
        ]);

        if (! $asistencia->contribuyente_id) {
            $this->addError(
                'contribuyente',
                'DEBES ASIGNAR UN CONTRIBUYENTE A LA ASISTENCIA.'
            );

            return;
        }

        $horaFin = now();
        $inicio = \Carbon\Carbon::parse(
            $asistencia->fecha->format('Y-m-d') . ' ' . $asistencia->hora_inicio
        );

        $tiempoOrientacion = $inicio->diffInSeconds($horaFin);
        $asistencia->update([
            'tipo_tramite_id' => $this->tipo_tramite_id ?: null,
            'observaciones' => $this->observaciones,
            'requiere_turno' => $this->requiere_turno,
            'lista_contribuyentes' => $this->lista_contribuyentes,
            'hora_fin' => $horaFin->format('H:i:s'),
            'tiempo_orientacion_segundos' => $tiempoOrientacion,
        ]);

        if ($this->requiere_turno) {
            $fecha = now()->toDateString();
            $ultimoNumero = Turno::query()
                ->whereDate('fecha', $fecha)
                ->where('modalidad_id', $asistencia->modalidad_id)
                ->max('numero');
            $numero = ($ultimoNumero ?? 0) + 1;
            $prefijo = match ($asistencia->modalidad_id) {
                1 => 'P',
                2 => 'T',
                3 => 'C',
                default => 'X',
            };

            $folio = $prefijo . '-' . str_pad($numero, 3, '0', STR_PAD_LEFT);
            $turno = Turno::create([
                'asistencia_id' => $asistencia->id,
                'contribuyente_id' => $asistencia->contribuyente_id,
                'modalidad_id' => $asistencia->modalidad_id,
                'estatus_turno_id' => 1,
                'fecha' => $fecha,
                'numero' => $numero,
                'folio' => $folio,
                'hora_generado' => now()->format('H:i:s'),
            ]);

            $this->turnoGeneradoId = $turno->id;

            TurnoContribuyente::create([
                'turno_id' => $turno->id,
                'contribuyente_id' => $asistencia->contribuyente_id,
                'es_principal' => true,
                'orden' => 1,
            ]);

            $orden = 2;

            foreach ($this->lista_contribuyentes as $item) {
                if (! isset($item['id'])) {
                    continue;
                }

                TurnoContribuyente::create([
                    'turno_id' => $turno->id,
                    'contribuyente_id' => $item['id'],
                    'es_principal' => false,
                    'orden' => $orden,
                ]);

                $orden++;
            }

        }else{
            $this->asistenciaFinalizadaSinTurno = true;
            $this->mensajeFinalizacion = 'LA ORIENTACIÓN FINALIZÓ EXITOSAMENTE SIN REQUERIR TURNO.';
        }


        session()->flash(
            'success',
            'ASISTENCIA FINALIZADA CORRECTAMENTE.'
        );

        $this->reset([
            'asistenciaActivaId',
            'tipo_tramite_id',
            'observaciones',
            'requiere_turno',
            'lista_contribuyentes',
            'buscar',
            'buscarContribuyenteAdicional',
            'buscarContribuyenteAdicionalEjecutado',
        ]);

        unset($this->asistenciaActiva);
    }

    public function getTurnoGeneradoProperty()
    {
        if (! $this->turnoGeneradoId) {
            return null;
        }

        return Turno::find($this->turnoGeneradoId);
    }

    public function getAsistenciaActivaProperty()
    {
        if (! $this->asistenciaActivaId) {
            return null;
        }

        return Asistencia::with(['contribuyente', 'modalidad'])
            ->find($this->asistenciaActivaId);
    }

    public function mount(): void
    {
        $asistencia = Asistencia::query()
            ->where('orientador_id', Auth::id())
            ->whereDate('fecha', now()->toDateString())
            ->whereNull('hora_fin')
            ->latest()
            ->first();

        if ($asistencia) {
            $this->asistenciaActivaId = $asistencia->id;
        }

        $contexto = session()->pull('recepcion_registro_contexto');

        if ($contexto) {
            $this->tipo_tramite_id = $contexto['tipo_tramite_id'] ?? '';
            $this->requiere_turno = $contexto['requiere_turno'] ?? false;
            $this->observaciones = $contexto['observaciones'] ?? '';
            $this->lista_contribuyentes = $contexto['lista_contribuyentes'] ?? [];
        }

        $nuevoContribuyenteId = session()->pull('recepcion_nuevo_contribuyente_id');

        if ($nuevoContribuyenteId && $this->asistenciaActivaId) {
            $asistencia = Asistencia::find($this->asistenciaActivaId);

            if ($asistencia) {

                if (
                    $contexto &&
                    ($contexto['origen'] ?? null) === 'principal' &&
                    ! $asistencia->contribuyente_id
                ) {
                    $asistencia->update([
                        'contribuyente_id' => $nuevoContribuyenteId,
                    ]);
                }

                if (
                    $contexto &&
                    ($contexto['origen'] ?? null) === 'adicional'
                ) {
                    $contribuyente = Contribuyente::find($nuevoContribuyenteId);

                    if ($contribuyente) {
                        $this->lista_contribuyentes[] = [
                            'id' => $contribuyente->id,
                            'rfc' => $contribuyente->rfc,
                            'nombre' => $contribuyente->razon_social,
                        ];
                    }
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.recepcion-index', [
            'tiposTramite' => TipoTramite::where('activo', true)
                ->orderBy('nombre')
                ->get(),
        ]);
    }
}