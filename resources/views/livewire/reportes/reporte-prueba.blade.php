<div class="p-6">

    <h2 class="text-xl font-bold mb-4">
        Reporte de Prueba
    </h2>

    <div class="flex gap-4 mb-4">

        <div>
            <label class="block text-sm font-medium mb-1">
                Período
            </label>

            <select wire:model="tipoPeriodo"
                    class="w-full rounded-md border-gray-300">
                <option value="Semanal">Semanal</option>
                <option value="Quincenal">Quincenal</option>
                <option value="Mensual">Mensual</option>
                <option value="Personalizado">Personalizado</option>
            </select>
        </div>



        <div>
            <label>Fecha inicio</label>
            <input type="date"
                   wire:model="fechaInicio"
                   class="border rounded px-2 py-1">
        </div>

        <div>
            <label>Fecha fin</label>
            <input type="date"
                   wire:model="fechaFin"
                   class="border rounded px-2 py-1">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-4">

            <div>
                <label class="block text-sm font-medium mb-1">
                    Modalidad
                </label>

                <select wire:model="modalidad" class="w-full rounded-md border-gray-300">
                    <option value="">Todas</option>
                    <option value="PRESENCIAL">Presencial</option>
                    <option value="TELEFONICA">Telefónica</option>
                    <option value="CORREO">Correo electrónico</option>
                </select>
            </div>

            @role('Administrador')
            <div>
                <label class="block text-sm font-medium mb-1">
                    Asesor
                </label>

                <select
                    wire:model="asesorId"
                    class="w-full rounded-md border-gray-300"
                >
                    <option value="">Todos</option>

                    @foreach($asesores as $asesor)
                        <option value="{{ $asesor->id }}">
                            {{ $asesor->nombre_completo }}
                        </option>
                    @endforeach
                </select>
            </div>
            @endrole

        </div>




        <div class="flex items-end">
            <button
                wire:click="consultar"
                class="bg-slate-800 text-white px-4 py-2 rounded">
                Consultar
            </button>
        </div>
    </div>

    @if(count($resultado) > 0)
        <div class="mb-4 rounded-md bg-blue-50 border border-blue-200 p-3 text-sm text-blue-800">
            <strong>Período:</strong> {{ $tipoPeriodo }} |
            <strong>Del:</strong> {{ \Carbon\Carbon::parse($fechaInicio)->format('d/m/Y') }} |
            <strong>Al:</strong> {{ \Carbon\Carbon::parse($fechaFin)->format('d/m/Y') }}
        </div>
    @endif

    <table class="min-w-full border">
        <thead>
            <tr>
                <th>Modalidad</th>
                <th>Tipo</th>
                <th>Clasificación</th>
                <th>Trámite</th>
                <th>Categoría</th>
                <th>Cantidad</th>
                <th>Importe</th>
            </tr>
        </thead>

        <tbody>
            @foreach($resultado as $fila)
                <tr>
                    <td>{{ $fila['modalidad'] }}</td>
                    <td>{{ $fila['tipo'] }}</td>
                    <td>{{ $fila['clasificacion'] }}</td>
                    <td>{{ $fila['tramite'] }}</td>
                    <td>{{ $fila['categoria'] }}</td>
                    <td>{{ $fila['total_cantidad'] }}</td>
                    <td>{{ number_format($fila['total_importe'],2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>