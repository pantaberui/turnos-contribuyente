<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Debug Reporte
        </h2>
    </x-slot>

    <div class="p-6 space-y-4">

        <form method="GET" class="bg-white border rounded p-4 flex gap-4 items-end">
            <div>
                <label class="block text-sm font-medium">Periodo</label>
                <select name="periodo" class="rounded border-gray-300">
                    @foreach(['Semanal', 'Quincenal', 'Mensual', 'Personalizado'] as $periodo)
                        <option value="{{ $periodo }}" @selected($tipoPeriodo === $periodo)>
                            {{ $periodo }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium">Fecha inicio</label>
                <input type="date" name="inicio" value="{{ $fechaInicio }}" class="rounded border-gray-300">
            </div>

            <div>
                <label class="block text-sm font-medium">Fecha fin</label>
                <input type="date" name="fin" value="{{ $fechaFin }}" class="rounded border-gray-300">
            </div>

            <div>
                <label class="block text-sm font-medium">Modalidad</label>
                <select name="modalidad" class="rounded border-gray-300">
                    <option value="">Todas</option>
                    <option value="PRESENCIAL" @selected($modalidad === 'PRESENCIAL')>Presencial</option>
                    <option value="TELEFONICA" @selected($modalidad === 'TELEFONICA')>Telefónica</option>
                    <option value="CORREO" @selected($modalidad === 'CORREO')>Correo electrónico</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium">Asesor</label>
                <select name="asesor_id" class="rounded border-gray-300">
                    <option value="">TODOS</option>
                    @foreach($asesores as $asesor)
                        <option value="{{ $asesor->id }}" @selected((string) $asesorId === (string) $asesor->id)>
                           {{ mb_strtoupper($asesor->name, 'UTF-8') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit"
                    style="background:#1f2937;color:white;padding:9px 16px;border-radius:6px;font-weight:bold;">
                Consultar
            </button>
        </form>


        <details open class="bg-white border rounded p-4">
            <summary class="font-bold cursor-pointer">Totales principales</summary>

            <table class="mt-4 min-w-full border text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-3 py-2 text-left">Concepto</th>
                        <th class="border px-3 py-2 text-right">Presencial</th>
                        <th class="border px-3 py-2 text-right">Telefónica</th>
                        <th class="border px-3 py-2 text-right">Correo</th>
                        <th class="border px-3 py-2 text-right">Total</th>
                        <th class="border px-3 py-2 text-right">Monto virtual</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($reporte['totales'] as $concepto => $datos)
                        <tr>
                            <td class="border px-3 py-2 font-semibold">
                                {{ str_replace('_', ' ', mb_strtoupper($concepto, 'UTF-8')) }}
                            </td>
                            <td class="border px-3 py-2 text-right">{{ $datos['PRESENCIAL'] }}</td>
                            <td class="border px-3 py-2 text-right">{{ $datos['TELEFONICA'] }}</td>
                            <td class="border px-3 py-2 text-right">{{ $datos['CORREO'] }}</td>
                            <td class="border px-3 py-2 text-right font-bold">{{ $datos['TOTAL'] }}</td>
                            <td class="border px-3 py-2 text-right">
                                ${{ number_format($datos['MONTO_VIRTUAL'], 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </details>

        <details open class="bg-white border rounded p-4">
            <summary class="font-bold cursor-pointer">RIF</summary>

            @foreach($reporte['rif']['clasificaciones'] ?? [] as $clasificacion)
                <h3 class="mt-4 font-bold text-slate-800">
                    {{ $clasificacion['catalogo']['nombre'] }}
                </h3>

                <table class="mt-2 min-w-full border text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-3 py-2 text-left">Trámite</th>
                            <th class="border px-3 py-2 text-right">Presencial</th>
                            <th class="border px-3 py-2 text-right">Telefónica</th>
                            <th class="border px-3 py-2 text-right">Correo</th>
                            <th class="border px-3 py-2 text-right">Total</th>
                            <th class="border px-3 py-2 text-right">Monto virtual</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($clasificacion['tramites'] as $tramite)
                            <tr>
                                <td class="border px-3 py-2">
                                    {{ $tramite['catalogo']['nombre'] }}
                                </td>
                                <td class="border px-3 py-2 text-right">{{ $tramite['estadisticas']['PRESENCIAL'] }}</td>
                                <td class="border px-3 py-2 text-right">{{ $tramite['estadisticas']['TELEFONICA'] }}</td>
                                <td class="border px-3 py-2 text-right">{{ $tramite['estadisticas']['CORREO'] }}</td>
                                <td class="border px-3 py-2 text-right font-bold">{{ $tramite['estadisticas']['TOTAL'] }}</td>
                                <td class="border px-3 py-2 text-right">
                                    ${{ number_format($tramite['estadisticas']['MONTO_VIRTUAL'], 2) }}
                                </td>
                            </tr>
                        @endforeach

                        <tr class="bg-slate-100 font-bold">
                            <td class="border px-3 py-2">TOTAL {{ $clasificacion['catalogo']['nombre'] }}</td>
                            <td class="border px-3 py-2 text-right">{{ $clasificacion['estadisticas']['PRESENCIAL'] }}</td>
                            <td class="border px-3 py-2 text-right">{{ $clasificacion['estadisticas']['TELEFONICA'] }}</td>
                            <td class="border px-3 py-2 text-right">{{ $clasificacion['estadisticas']['CORREO'] }}</td>
                            <td class="border px-3 py-2 text-right">{{ $clasificacion['estadisticas']['TOTAL'] }}</td>
                            <td class="border px-3 py-2 text-right">
                                ${{ number_format($clasificacion['estadisticas']['MONTO_VIRTUAL'], 2) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            @endforeach
        </details>


        <details class="bg-white border rounded p-4">
            <summary class="font-bold cursor-pointer">Resúmenes</summary>
            <pre class="mt-3 text-xs overflow-auto">{{ json_encode($reporte['resumenes'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
        </details>

        <details open class="bg-white border rounded p-4">
            <summary class="font-bold cursor-pointer">Estatales</summary>

            @foreach($reporte['estatales']['clasificaciones'] ?? [] as $clasificacion)
                <h3 class="mt-4 font-bold text-slate-800">
                    {{ $clasificacion['catalogo']['nombre'] }}
                </h3>

                <table class="mt-2 min-w-full border text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-3 py-2 text-left">Trámite</th>
                            <th class="border px-3 py-2 text-right">Presencial</th>
                            <th class="border px-3 py-2 text-right">Telefónica</th>
                            <th class="border px-3 py-2 text-right">Correo</th>
                            <th class="border px-3 py-2 text-right">Total</th>
                            <th class="border px-3 py-2 text-right">Monto virtual</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($clasificacion['tramites'] as $tramite)
                            <tr>
                                <td class="border px-3 py-2">
                                    {{ $tramite['catalogo']['nombre'] }}
                                </td>
                                <td class="border px-3 py-2 text-right">{{ $tramite['estadisticas']['PRESENCIAL'] }}</td>
                                <td class="border px-3 py-2 text-right">{{ $tramite['estadisticas']['TELEFONICA'] }}</td>
                                <td class="border px-3 py-2 text-right">{{ $tramite['estadisticas']['CORREO'] }}</td>
                                <td class="border px-3 py-2 text-right font-bold">{{ $tramite['estadisticas']['TOTAL'] }}</td>
                                <td class="border px-3 py-2 text-right">
                                    ${{ number_format($tramite['estadisticas']['MONTO_VIRTUAL'], 2) }}
                                </td>
                            </tr>
                        @endforeach

                        <tr class="bg-slate-100 font-bold">
                            <td class="border px-3 py-2">TOTAL {{ $clasificacion['catalogo']['nombre'] }}</td>
                            <td class="border px-3 py-2 text-right">{{ $clasificacion['estadisticas']['PRESENCIAL'] }}</td>
                            <td class="border px-3 py-2 text-right">{{ $clasificacion['estadisticas']['TELEFONICA'] }}</td>
                            <td class="border px-3 py-2 text-right">{{ $clasificacion['estadisticas']['CORREO'] }}</td>
                            <td class="border px-3 py-2 text-right">{{ $clasificacion['estadisticas']['TOTAL'] }}</td>
                            <td class="border px-3 py-2 text-right">
                                ${{ number_format($clasificacion['estadisticas']['MONTO_VIRTUAL'], 2) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            @endforeach
        </details>

    </div>
</x-app-layout>