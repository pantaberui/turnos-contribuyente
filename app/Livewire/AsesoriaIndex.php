<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Turno;
use Illuminate\Support\Facades\Auth;
use App\Models\TipoTramite;
use App\Models\DetalleTramite;
use App\Models\ModuloAsesoria;



class AsesoriaIndex extends Component
{
    public array $tramitesSeleccionados = [];
    public ?string $mensajeInfo = null;
    public bool $turnoCerrado = false;
    public ?ModuloAsesoria $moduloAsignado = null;

    public function toggleTramite(
        int $contribuyenteId,
        int $tramiteId
    ): void
    {
        $this->mensajeInfo = null;
        if (isset($this->tramitesSeleccionados[$contribuyenteId][$tramiteId])) {

            unset(
                $this->tramitesSeleccionados[$contribuyenteId][$tramiteId]
            );

            return;
        }

        $this->tramitesSeleccionados[$contribuyenteId][$tramiteId] = [
            'cantidad' => 1,
            'importe_declaracion' => '',
        ];
    }

   public function getTurnoActualProperty()
    {
        return Turno::query()
            ->with([
                'contribuyente',
                'estatusTurno',
                'contribuyentes.contribuyente',
            ])
            ->where('asesor_id', Auth::id())
            ->whereDate('fecha', now()->toDateString())
            ->whereIn('estatus_turno_id', [2, 3])
            ->orderByDesc('id')
            ->first();
    }

    public function llamarSiguienteTurno(): void
    {   
        $this->turnoCerrado = false;

        if ($this->turnoActual) {
            return;
        }

        $turno = Turno::query()
            ->whereDate('fecha', now()->toDateString())
            ->where('estatus_turno_id', 1)
            ->orderBy('numero')
            ->first();

        if (! $turno) {
            session()->flash('info', 'NO HAY TURNOS PENDIENTES.');
            return;
        }

        $turno->update([
            'asesor_id' => Auth::id(),
            'estatus_turno_id' => 2,
            'hora_llamado' => now()->format('H:i:s'),
            'hora_ultimo_llamado' => now()->format('H:i:s'),
            'numero_llamados' => 1,
        ]);
    }

    public function llamarNuevamente(): void
    {
        $turno = $this->turnoActual;

        if (! $turno) {
            return;
        }

        if ($turno->estatus_turno_id != 2) {
            return;
        }

        if ($turno->numero_llamados >= 3) {
            session()->flash(
                'info',
                'EL TURNO YA FUE LLAMADO 3 VECES.'
            );

            return;
        }

        $turno->increment('numero_llamados');

        $turno->update([
            'hora_ultimo_llamado' => now()->format('H:i:s'),
        ]);

        session()->flash(
            'success',
            'TURNO LLAMADO NUEVAMENTE.'
        );
    }

    public function iniciarAtencion(): void
    {
        $turno = $this->turnoActual;

        if (! $turno) {
            return;
        }

        $turno->update([
            'estatus_turno_id' => 3,
            'hora_inicio_atencion' => now()->format('H:i:s'),
            'asesor_id' => auth()->id(),
            'modulo_asesoria_id' => $this->moduloAsignado?->id,
        ]);
        
    }

    public function getResumenAtencionProperty(): array
    {
        $resumen = [];

        foreach ($this->tramitesSeleccionados as $contribuyenteId => $tramites) {

            $contribuyente = $this->turnoActual
                ->contribuyentes
                ->firstWhere('contribuyente_id', $contribuyenteId);

            $nombre = $contribuyente?->contribuyente?->razon_social ?? 'SIN NOMBRE';

            $resumen[$contribuyenteId] = [
                'nombre' => $nombre,
                'tramites' => [],
            ];

            foreach ($tramites as $tramiteId => $datos) {

                $tramite = \App\Models\Tramite::find($tramiteId);

                $resumen[$contribuyenteId]['tramites'][] = [
                    'nombre' => $tramite?->nombre,
                    'cantidad' => $datos['cantidad'] ?? 1,
                    'importe' => $datos['importe_declaracion'] ?? null,
                ];
            }
        }

        return $resumen;
    }

    public function marcarNoSePresento(): void
    {
        $turno = $this->turnoActual;
        

        if (! $turno) {
            return;
        }

        $turno->update([
            'estatus_turno_id' => 6,
            'hora_fin_atencion' => now()->format('H:i:s'),
        ]);

        $this->tramitesSeleccionados = [];
        $this->mensajeInfo = null;
        $this->dispatch('$refresh');
        $this->turnoCerrado = true;

        session()->flash(
            'success',
            'EL TURNO FUE MARCADO COMO NO SE PRESENTÓ.'
        );
    }

    public function finalizarAtencion(): void
    {   
        
        $turno = $this->turnoActual;

        if (! $turno) {
            return;
        }

        
        logger()->info('TRAMITES', $this->tramitesSeleccionados);
        if (count($this->tramitesSeleccionados) === 0) {
            $this->mensajeInfo = 'DEBES SELECCIONAR AL MENOS UN TRÁMITE ATENDIDO.';
            $this->dispatch('scroll-top');
            return;
        }

        foreach ($this->tramitesSeleccionados as $contribuyenteId => $tramites) {
            foreach ($tramites as $tramiteId => $datos) {
                DetalleTramite::create([
                    'turno_id' => $turno->id,
                    'contribuyente_id' => $contribuyenteId,
                    'tramite_id' => $tramiteId,
                    'cantidad' => $datos['cantidad'] ?? 1,
                    'importe_declaracion' => $datos['importe_declaracion'] ?: null,
                ]);
            }
        }

        $turno->update([
            'estatus_turno_id' => 4,
            'hora_fin_atencion' => now()->format('H:i:s'),
        ]);

        $this->tramitesSeleccionados = [];
        $this->mensajeInfo = null;
        $this->turnoCerrado = true;

        session()->flash(
            'success',
            'ATENCIÓN FINALIZADA CORRECTAMENTE.'
        );
    }

    public function getTiempoAtencionProperty(): string
    {
        $turno = $this->turnoActual;

        if (! $turno || ! $turno->hora_inicio_atencion) {
            return '—';
        }

        return \Carbon\Carbon::parse($turno->hora_inicio_atencion)
            ->diff(now())
            ->format('%H:%I:%S');
    }

    public function render()
    {
        return view('livewire.asesoria-index', [
            'tiposTramite' => TipoTramite::where('activo', true)
                ->with('clasificaciones.tramites')
                ->orderBy('id')
                ->get(),
        ]);
    }

    public function mount(): void
    {
        $this->moduloAsignado = ModuloAsesoria::with('asesor')
            ->where('activo', true)
            ->where('asesor_id', Auth::id())
            ->first();
    }
}