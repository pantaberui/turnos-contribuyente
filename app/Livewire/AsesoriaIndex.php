<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Turno;
use Illuminate\Support\Facades\Auth;
use App\Models\TipoTramite;
use App\Models\DetalleTramite;
use App\Models\ModuloAsesoria;
use App\Models\Asesoria;
use App\Models\AsesoriaTramite;
use App\Models\AsesoriaContribuyente;

class AsesoriaIndex extends Component
{
    public array $tramitesSeleccionados = [];
    public ?string $mensajeInfo = null;
    public bool $turnoCerrado = false;
    public ?ModuloAsesoria $moduloAsignado = null;

    public bool $mostrandoLlamada = false;
    public string $paisOrigenLlamada = '';
    public string $ciudadOrigenLlamada = '';
    public string $telefonoOrigenLlamada = '';
    public ?int $contribuyenteLlamadaId = null;
    public ?Asesoria $asesoriaTelefonicaActual = null;
    public string $buscarRfc = '';
    public string $buscarCurp = '';
    public string $buscarNombre = '';
    public array $resultadosBusqueda = [];
    public ?array $contribuyenteLlamadaSeleccionado = null;
    public bool $llamadaEnCurso = false;
    public ?int $asesoriaTelefonicaId = null;
    public bool $mostrandoAgregarContribuyente = false;
    public string $buscarRfcAdicional = '';
    public string $buscarCurpAdicional = '';
    public string $buscarNombreAdicional = '';
    public array $resultadosBusquedaAdicional = [];
    
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
            ->whereIn('estatus_turno_id', [7, 2]) // solo llamado o atendiendo
            ->orderByDesc('id')
            ->first();
    }

    public function llamarSiguienteTurno(): void
    {   
        $this->turnoCerrado = false;
        $turno = $this->turnoActual;
        $moduloNombre = $this->moduloAsignado?->nombre ?? 'correspondiente';

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

        if (! $this->moduloAsignado) {
            session()->flash('info', 'NO TIENES UN MÓDULO DE ASESORÍA ASIGNADO.');
            return;
        }

       $turno->update([
            'asesor_id' => Auth::id(),
            'modulo_asesoria_id' => $this->moduloAsignado?->id,
            'estatus_turno_id' => 7,
            'hora_llamado' => now()->format('H:i:s'),
            'hora_ultimo_llamado' => now()->format('H:i:s'),
            'numero_llamados' => 1,
        ]);

        $this->turnoActual = $turno->fresh();
        $this->dispatch(
            'reproducir-llamado',
            texto: 'Turno número ' . $this->turnoActual->numero . ', favor de pasar al ' . $moduloNombre
        );
    }

    public function llamarNuevamente(): void
    {
        $turno = $this->turnoActual;
        $moduloNombre = $this->moduloAsignado?->nombre ?? 'correspondiente';

        if (! $turno) {
            return;
        }

        if ((int) $turno->estatus_turno_id !== 7) {
            return;
        }

        if ((int) $turno->numero_llamados >= 3) {
            session()->flash('info', 'EL TURNO YA FUE LLAMADO 3 VECES.');
            return;
        }

        $turno->increment('numero_llamados');

        $turno->update([
            'hora_ultimo_llamado' => now()->format('H:i:s'),
            'hora_llamado' => now()->format('H:i:s'),
        ]);

        $this->turnoActual = $turno->fresh();

        
        $this->dispatch(
            'reproducir-llamado',
            texto: 'Turno número ' . $this->turnoActual->numero . ', favor de pasar al ' . $moduloNombre    
        );

        session()->flash('success', 'TURNO LLAMADO NUEVAMENTE.');
    }

    public function iniciarAtencion(): void
    {
        $turno = $this->turnoActual;

        if (! $turno) {
            return;
        }
        
        if ($turno->estatus_turno_id != 7) {
            return;
        }

        $inicio = now();

        $turno->update([
            'estatus_turno_id' => 2,
            'hora_inicio_atencion' => $inicio->format('H:i:s'),
            'asesor_id' => auth()->id(),
            'modulo_asesoria_id' => $this->moduloAsignado?->id,
        ]);

        Asesoria::firstOrCreate(
            [
                'turno_id' => $turno->id,
            ],
            [
                'contribuyente_id' => $turno->contribuyente_id,
                'asesor_id' => Auth::id(),
                'modalidad' => 'PRESENCIAL',
                'estatus' => 'INICIADA',
                'inicio_atencion' => $inicio,
                'created_by' => Auth::id(),
            ]
        );
        
    }

    public function getResumenAtencionProperty(): array
    {
        $resumen = [];

        foreach ($this->tramitesSeleccionados as $contribuyenteId => $tramites) {

            $contribuyente = collect($this->contribuyentesAtencion)
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

        $asesoria = Asesoria::where('turno_id', $turno->id)
            ->where('estatus', 'INICIADA')
            ->first();

        if ($asesoria) {
            $fin = now();

            $asesoria->update([
                'estatus' => 'CANCELADA',
                'fin_atencion' => $fin,
                'duracion_segundos' => $asesoria->inicio_atencion
                    ? $asesoria->inicio_atencion->diffInSeconds($fin)
                    : null,
                'updated_by' => Auth::id(),
            ]);
        }

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

        $asesoria = Asesoria::where('turno_id', $turno->id)
            ->where('estatus', 'INICIADA')
            ->first();

        foreach ($this->tramitesSeleccionados as $contribuyenteId => $tramites) {
            foreach ($tramites as $tramiteId => $datos) {

                DetalleTramite::create([
                    'turno_id' => $turno->id,
                    'contribuyente_id' => $contribuyenteId,
                    'tramite_id' => $tramiteId,
                    'cantidad' => $datos['cantidad'] ?? 1,
                    'importe_declaracion' => $datos['importe_declaracion'] ?: null,
                ]);

                if ($asesoria) {
                    AsesoriaTramite::create([
                        'asesoria_id' => $asesoria->id,
                        'contribuyente_id' => $contribuyenteId,
                        'tramite_id' => $tramiteId,
                        'cantidad' => $datos['cantidad'] ?? 1,
                        'importe_declaracion' => $datos['importe_declaracion'] ?: null,
                    ]);
                }
            }
        }
        
        $inicioAtencion = \Carbon\Carbon::parse(
            $turno->fecha->format('Y-m-d') . ' ' . $turno->hora_inicio_atencion
        );

        $tiempoAtencion = $inicioAtencion->diffInSeconds(now());

        $finAtencion = now();

        $turno->update([
            'estatus_turno_id' => 3,
            'hora_fin_atencion' => $finAtencion->format('H:i:s'),
            'tiempo_atencion_segundos' => $tiempoAtencion,
        ]);

        $asesoria = Asesoria::where('turno_id', $turno->id)
            ->where('estatus', 'INICIADA')
            ->first();

        if ($asesoria) {
            $asesoria->update([
                'estatus' => 'FINALIZADA',
                'fin_atencion' => $finAtencion,
                'duracion_segundos' => $asesoria->inicio_atencion
                    ? $asesoria->inicio_atencion->diffInSeconds($finAtencion)
                    : null,
                'updated_by' => Auth::id(),
            ]);
        }

        $this->tramitesSeleccionados = [];
        $this->mensajeInfo = null;
        $this->turnoCerrado = false;

        session()->flash(
            'success',
            'ATENCIÓN FINALIZADA CORRECTAMENTE.'
        );

        $this->redirectRoute('asesoria.index');
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

    public function nuevaLlamada(): void
    {
        if ($this->turnoActual) {
            session()->flash(
                'info',
                'DEBES FINALIZAR EL TURNO ACTUAL ANTES DE INICIAR UNA LLAMADA.'
            );

            return;
        }

        $this->mostrandoLlamada = true;
        $this->mensajeInfo = null;
    }

    public function cancelarLlamada(): void
    {
        $this->mostrandoLlamada = false;

        $this->paisOrigenLlamada = '';
        $this->ciudadOrigenLlamada = '';
        $this->telefonoOrigenLlamada = '';

        $this->contribuyenteLlamadaId = null;
        $this->asesoriaTelefonicaActual = null;

        $this->mensajeInfo = null;
    }

    public function buscarContribuyente(): void
    {
        $this->contribuyenteLlamadaSeleccionado = null;
        $this->contribuyenteLlamadaId = null;
        $this->resultadosBusqueda = [];

        $query = \App\Models\Contribuyente::query();

        if ($this->buscarRfc !== '') {
            $query->where('rfc', 'like', '%' . mb_strtoupper(trim($this->buscarRfc), 'UTF-8') . '%');
        }

        if ($this->buscarCurp !== '') {
            $query->where('curp', 'like', '%' . mb_strtoupper(trim($this->buscarCurp), 'UTF-8') . '%');
        }

        if ($this->buscarNombre !== '') {
            $query->where('razon_social', 'like', '%' . mb_strtoupper(trim($this->buscarNombre), 'UTF-8') . '%');
        }

        $this->resultadosBusqueda = $query
            ->limit(10)
            ->get()
            ->toArray();
    }

    public function seleccionarContribuyente(int $id): void
    {
        $contribuyente = \App\Models\Contribuyente::find($id);

        if (! $contribuyente) {
            session()->flash('info', 'NO SE ENCONTRÓ EL CONTRIBUYENTE.');
            return;
        }

        $this->contribuyenteLlamadaId = $contribuyente->id;

        $this->contribuyenteLlamadaSeleccionado = [
            'id' => $contribuyente->id,
            'rfc' => $contribuyente->rfc,
            'curp' => $contribuyente->curp,
            'razon_social' => $contribuyente->razon_social,
        ];

        $this->buscarRfc = '';
        $this->buscarCurp = '';
        $this->buscarNombre = '';
        $this->resultadosBusqueda = [];
    }

    public function iniciarLlamadaTelefonica(): void
    {
        


        if (! $this->contribuyenteLlamadaId) {
            $this->mensajeInfo = 'DEBES SELECCIONAR UN CONTRIBUYENTE.';
            return;
        }

        $this->validate([
            'paisOrigenLlamada' => ['required', 'string', 'max:255'],
            'ciudadOrigenLlamada' => ['required', 'string', 'max:255'],
            'telefonoOrigenLlamada' => ['required', 'digits:10'],
        ], [
            'paisOrigenLlamada.required' => 'EL PAÍS DE ORIGEN ES OBLIGATORIO.',
            'ciudadOrigenLlamada.required' => 'LA CIUDAD DE ORIGEN ES OBLIGATORIA.',
            'telefonoOrigenLlamada.required' => 'EL TELÉFONO DE ORIGEN ES OBLIGATORIO.',
            'telefonoOrigenLlamada.digits' => 'EL TELÉFONO DE ORIGEN DEBE CONTENER 10 DÍGITOS.',
        ]);

        $inicio = now();

        $asesoria = Asesoria::create([
            'turno_id' => null,
            'contribuyente_id' => $this->contribuyenteLlamadaId,
            'asesor_id' => Auth::id(),
            'modalidad' => 'TELEFONICA',
            'estatus' => 'INICIADA',
            'inicio_atencion' => $inicio,
            

            'pais_origen_llamada' => mb_strtoupper($this->paisOrigenLlamada, 'UTF-8'),
            'ciudad_origen_llamada' => mb_strtoupper($this->ciudadOrigenLlamada, 'UTF-8'),
            'telefono_origen_llamada' => $this->telefonoOrigenLlamada,

            'created_by' => Auth::id(),
        ]);

        AsesoriaContribuyente::create([
            'asesoria_id'      => $asesoria->id,
            'contribuyente_id' => $this->contribuyenteLlamadaId,
            'es_principal'     => true,
            'orden'            => 1,
        ]);

        $this->asesoriaTelefonicaId = $asesoria->id;
        $this->asesoriaTelefonicaActual = $asesoria;
        $this->llamadaEnCurso = true;
        $this->mostrandoLlamada = false;

        $this->buscarRfc = '';
        $this->buscarCurp = '';
        $this->buscarNombre = '';
        $this->resultadosBusqueda = [];

        $this->contribuyenteLlamadaSeleccionado = null;
        $this->contribuyenteLlamadaId = null;

        session()->flash('success', 'ASESORÍA TELEFÓNICA INICIADA.');
    }

    public function updatedBuscarRfc($value): void
    {
        $this->buscarRfc = mb_strtoupper($value, 'UTF-8');
    }

    public function updatedBuscarCurp($value): void
    {
        $this->buscarCurp = mb_strtoupper($value, 'UTF-8');
    }

    public function updatedBuscarNombre($value): void
    {
        $this->buscarNombre = mb_strtoupper($value, 'UTF-8');
    }

    public function updatedPaisOrigenLlamada(): void
    {
        $this->paisOrigenLlamada = mb_strtoupper($this->paisOrigenLlamada, 'UTF-8');
    }

    public function updatedCiudadOrigenLlamada(): void
    {
        $this->ciudadOrigenLlamada = mb_strtoupper($this->ciudadOrigenLlamada, 'UTF-8');
    }


    public function finalizarLlamadaTelefonica(): void
    {
        if (! $this->asesoriaTelefonicaId) {
            $this->mensajeInfo = 'NO HAY UNA ASESORÍA TELEFÓNICA EN CURSO.';
            return;
        }

        $asesoria = Asesoria::find($this->asesoriaTelefonicaId);

        if (! $asesoria || $asesoria->estatus !== 'INICIADA') {
            $this->mensajeInfo = 'NO SE ENCONTRÓ UNA ASESORÍA TELEFÓNICA ACTIVA.';
            return;
        }


        if (count($this->tramitesSeleccionados) === 0) {
            $this->mensajeInfo = 'DEBES SELECCIONAR AL MENOS UN TRÁMITE ATENDIDO.';
            $this->dispatch('scroll-top');
            return;
        }

        foreach ($this->tramitesSeleccionados as $contribuyenteId => $tramites) {
            foreach ($tramites as $tramiteId => $datos) {
                AsesoriaTramite::create([
                    'asesoria_id' => $asesoria->id,
                    'contribuyente_id' => $contribuyenteId,
                    'tramite_id' => $tramiteId,
                    'cantidad' => $datos['cantidad'] ?? 1,
                    'importe_declaracion' => $datos['importe_declaracion'] ?: null,
                ]);
            }
        }



        $fin = now();

        $asesoria->update([
            'estatus' => 'FINALIZADA',
            'fin_atencion' => $fin,
            'duracion_segundos' => $asesoria->inicio_atencion
                ? $asesoria->inicio_atencion->diffInSeconds($fin)
                : null,
            'updated_by' => Auth::id(),
        ]);

        $this->llamadaEnCurso = false;
        $this->asesoriaTelefonicaId = null;
        $this->asesoriaTelefonicaActual = null;

        $this->paisOrigenLlamada = '';
        $this->ciudadOrigenLlamada = '';
        $this->telefonoOrigenLlamada = '';

        $this->contribuyenteLlamadaId = null;
        $this->contribuyenteLlamadaSeleccionado = null;
        $this->tramitesSeleccionados = [];
        $this->mensajeInfo = null;

        session()->flash('success', 'ASESORÍA TELEFÓNICA FINALIZADA CORRECTAMENTE.');
    }

    public function getAsesoriaActualProperty()
    {
        if ($this->turnoActual) {
            return Asesoria::where('turno_id', $this->turnoActual->id)
                ->where('estatus', 'INICIADA')
                ->first();
        }

        return $this->asesoriaTelefonicaActual;
    }

    public function getContribuyentesAtencionProperty()
    {
        if ($this->turnoActual) {
            return $this->turnoActual->contribuyentes;
        }

        if ($this->asesoriaTelefonicaActual) {
            return $this->asesoriaTelefonicaActual
                ->contribuyentes()
                ->with('contribuyente')
                ->orderBy('orden')
                ->get();
        }

        return collect();
    }

    public function mostrarAgregarContribuyente(): void
    {
        $this->mostrandoAgregarContribuyente = true;
        $this->resultadosBusquedaAdicional = [];
    }

    public function cancelarAgregarContribuyente(): void
    {
        $this->mostrandoAgregarContribuyente = false;
        $this->buscarRfcAdicional = '';
        $this->buscarCurpAdicional = '';
        $this->buscarNombreAdicional = '';
        $this->resultadosBusquedaAdicional = [];
    }

    public function buscarContribuyenteAdicional(): void
    {
        $this->resultadosBusquedaAdicional = [];

        $query = \App\Models\Contribuyente::query();

        if ($this->buscarRfcAdicional !== '') {
            $query->where('rfc', 'like', '%' . mb_strtoupper(trim($this->buscarRfcAdicional), 'UTF-8') . '%');
        }

        if ($this->buscarCurpAdicional !== '') {
            $query->where('curp', 'like', '%' . mb_strtoupper(trim($this->buscarCurpAdicional), 'UTF-8') . '%');
        }

        if ($this->buscarNombreAdicional !== '') {
            $query->where('razon_social', 'like', '%' . mb_strtoupper(trim($this->buscarNombreAdicional), 'UTF-8') . '%');
        }

        $this->resultadosBusquedaAdicional = $query
            ->limit(10)
            ->get()
            ->toArray();
    }

    public function agregarContribuyenteAdicional(int $contribuyenteId): void
    {
        if (! $this->asesoriaActual) {
            $this->mensajeInfo = 'NO HAY UNA ASESORÍA ACTIVA.';
            return;
        }

        $existe = AsesoriaContribuyente::where('asesoria_id', $this->asesoriaActual->id)
            ->where('contribuyente_id', $contribuyenteId)
            ->exists();

        if ($existe) {
            $this->mensajeInfo = 'EL CONTRIBUYENTE YA ESTÁ AGREGADO A ESTA ASESORÍA.';
            return;
        }

        $orden = AsesoriaContribuyente::where('asesoria_id', $this->asesoriaActual->id)
            ->max('orden') + 1;

        AsesoriaContribuyente::create([
            'asesoria_id' => $this->asesoriaActual->id,
            'contribuyente_id' => $contribuyenteId,
            'es_principal' => false,
            'orden' => $orden,
        ]);

        $this->cancelarAgregarContribuyente();

        $this->asesoriaTelefonicaActual = Asesoria::with([
            'contribuyente',
            'contribuyentes.contribuyente',
        ])->find($this->asesoriaActual->id);

        session()->flash('success', 'CONTRIBUYENTE AGREGADO A LA ASESORÍA.');
    }


}