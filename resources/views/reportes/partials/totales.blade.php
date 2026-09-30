<div class="reporte-seccion">
    <h2>
        Totales principales
    </h2>

    @php
        $general = $reporte->totales['total_general'];
    @endphp

    <div class="resumen-ejecutivo">
        <div>
            <span>Presencial</span>
            <strong>{{ number_format($general['PRESENCIAL']) }}</strong>
        </div>

        <div>
            <span>Telefónica</span>
            <strong>{{ number_format($general['TELEFONICA']) }}</strong>
        </div>

        <div>
            <span>Correo</span>
            <strong>{{ number_format($general['CORREO']) }}</strong>
        </div>

        <div>
            <span>Total</span>
            <strong>{{ number_format($general['TOTAL']) }}</strong>
        </div>

        <div>
            <span>Monto virtual</span>
            <strong>${{ number_format($general['MONTO_VIRTUAL'], 2) }}</strong>
        </div>
    </div>

    <table class="reporte-tabla">
        <thead class="bg-gray-100">
            <tr>
                <th>Concepto</th>
                <th>Presencial</th>
                <th>Telefónica</th>
                <th>Correo</th>
                <th class="reporte-total-columna">TOTAL</th>
                <th class="reporte-monto-columna">Monto virtual</th>
            </tr>
        </thead>

        <tbody>
            @foreach($reporte->totales as $concepto => $datos)
                <tr>
                    <td>{{ str_replace('_', ' ', mb_strtoupper($concepto, 'UTF-8')) }}</td>
                    <td class="reporte-numero">{{ number_format($datos['PRESENCIAL']) }}</td>
                    <td class="reporte-numero">{{ number_format($datos['TELEFONICA']) }}</td>
                    <td class="reporte-numero">{{ number_format($datos['CORREO']) }}</td>
                    <td class="reporte-numero reporte-total-columna">{{ number_format($datos['TOTAL']) }}</td>
                    <td class="reporte-numero reporte-monto-columna">${{ number_format($datos['MONTO_VIRTUAL'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>