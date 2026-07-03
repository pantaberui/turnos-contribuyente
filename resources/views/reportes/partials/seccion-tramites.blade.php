<div class="reporte-bloque">
    <h2 class="documento-titulo-seccion">
        {{ $titulo }}
    </h2>

    @foreach($seccion['clasificaciones'] ?? [] as $clasificacion)
        <h3 class="documento-titulo-clasificacion">
            {{ $clasificacion['catalogo']['nombre'] }}
        </h3>

        <table class="reporte-tabla">
            <thead class="bg-gray-100">
                <tr>
                    <th>Trámite</th>
                    <th>Presencial</th>
                    <th>Telefónica</th>
                    <th>Correo</th>                    
                    <th class="reporte-total-columna">TOTAL</th>
                    <th class="reporte-monto-columna">Monto virtual</th>
                </tr>
            </thead>

            <tbody>
                @foreach($clasificacion['tramites'] as $tramite)
                    <tr>
                        <td class="border px-3 py-2">
                            {{ $tramite['catalogo']['nombre'] }}
                        </td>
                        <td class="reporte-numero">
                            {{ number_format($tramite['estadisticas']['PRESENCIAL']) }}
                        </td>
                        <td class="reporte-numero">
                            {{ number_format($tramite['estadisticas']['TELEFONICA']) }}
                        </td>
                        <td class="reporte-numero">
                            {{ number_format($tramite['estadisticas']['CORREO']) }}
                        </td>
                        <td class="reporte-numero reporte-total-columna">
                            {{ number_format($tramite['estadisticas']['TOTAL']) }}
                        </td>
                        <td class="reporte-numero reporte-monto-columna">
                            ${{ number_format($tramite['estadisticas']['MONTO_VIRTUAL'], 2) }}
                        </td>
                    </tr>
                @endforeach

                <tr class="reporte-fila-total">
                    <td class="border px-3 py-2">TOTAL {{ $clasificacion['catalogo']['nombre'] }}</td>
                    <td class="reporte-numero">{{ $clasificacion['estadisticas']['PRESENCIAL'] }}</td>
                    <td class="reporte-numero">{{ $clasificacion['estadisticas']['TELEFONICA'] }}</td>
                    <td class="reporte-numero">{{ $clasificacion['estadisticas']['CORREO'] }}</td>
                    <td class="reporte-numero reporte-total-columna">
                        {{ number_format($tramite['estadisticas']['TOTAL']) }}
                    </td>
                    <td class="reporte-numero reporte-monto-columna">
                        ${{ number_format($clasificacion['estadisticas']['MONTO_VIRTUAL'], 2) }}
                    </td>
                </tr>
            </tbody>
        </table>
    @endforeach
</div>