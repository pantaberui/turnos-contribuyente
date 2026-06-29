<div class="reporte-bloque">
    <h2 class="documento-titulo-seccion">
        {{ $titulo }}
    </h2>

    @foreach($seccion['clasificaciones'] ?? [] as $clasificacion)
        <h3 class="documento-titulo-clasificacion">
            {{ $clasificacion['catalogo']['nombre'] }}
        </h3>

        <table class="mt-2 min-w-full border text-xs">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-3 py-2 text-left">Trámite</th>
                    <th class="border px-3 py-2 text-center">Presencial</th>
                    <th class="border px-3 py-2 text-center">Telefónica</th>
                    <th class="border px-3 py-2 text-center">Correo</th>                    
                    <th class="border px-3 py-2 text-center bg-slate-300 font-bold">TOTAL</th>
                    <th class="border px-3 py-2 text-center bg-green-100 font-bold">Monto virtual</th>
                </tr>
            </thead>

            <tbody>
                @foreach($clasificacion['tramites'] as $tramite)
                    <tr>
                        <td class="border px-3 py-2">
                            {{ $tramite['catalogo']['nombre'] }}
                        </td>
                        <td class="border px-3 py-2 text-right">
                            {{ number_format($tramite['estadisticas']['PRESENCIAL']) }}
                        </td>
                        <td class="border px-3 py-2 text-right">
                            {{ number_format($tramite['estadisticas']['TELEFONICA']) }}
                        </td>
                        <td class="border px-3 py-2 text-right">
                            {{ number_format($tramite['estadisticas']['CORREO']) }}
                        </td>
                        <td class="border px-3 py-2 text-right font-bold bg-slate-50">
                            {{ number_format($tramite['estadisticas']['TOTAL']) }}
                        </td>
                        <td class="border px-3 py-2 text-right bg-green-50">
                            ${{ number_format($tramite['estadisticas']['MONTO_VIRTUAL'], 2) }}
                        </td>
                    </tr>
                @endforeach

                <tr class="bg-slate-200 font-bold border-t-2 border-slate-400">
                    <td class="border px-3 py-2">TOTAL {{ $clasificacion['catalogo']['nombre'] }}</td>
                    <td class="border px-3 py-2 text-right">{{ $clasificacion['estadisticas']['PRESENCIAL'] }}</td>
                    <td class="border px-3 py-2 text-right">{{ $clasificacion['estadisticas']['TELEFONICA'] }}</td>
                    <td class="border px-3 py-2 text-right">{{ $clasificacion['estadisticas']['CORREO'] }}</td>
                    <td class="border px-3 py-2 text-right font-bold bg-slate-50">
                        {{ number_format($tramite['estadisticas']['TOTAL']) }}
                    </td>
                    <td class="border px-3 py-2 text-right bg-green-50">
                        ${{ number_format($clasificacion['estadisticas']['MONTO_VIRTUAL'], 2) }}
                    </td>
                </tr>
            </tbody>
        </table>
    @endforeach
</div>