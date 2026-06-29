<div class="reporte-seccion">
    <h2>
        Totales principales
    </h2>

    <table class="mt-4 min-w-full border text-xs">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-3 py-2 text-left">Concepto</th>
                <th class="border px-3 py-2 text-right">Presencial</th>
                <th class="border px-3 py-2 text-right">Telefónica</th>
                <th class="border px-3 py-2 text-right">Correo</th>
                <th class="border px-3 py-2 text-center bg-slate-300 font-bold">TOTAL</th>
                <th class="border px-3 py-2 text-center bg-green-100 font-bold">Monto virtual</th>
            </tr>
        </thead>

        <tbody>
            @foreach($reporte['totales'] as $concepto => $datos)
                <tr>
                    <td class="border px-3 py-2 font-semibold">
                        {{ str_replace('_', ' ', mb_strtoupper($concepto, 'UTF-8')) }}
                    </td>
                    <td class="border px-3 py-2 text-right">{{ number_format($datos['PRESENCIAL']) }}</td>
                    <td class="border px-3 py-2 text-right">{{ number_format($datos['TELEFONICA']) }}</td>
                    <td class="border px-3 py-2 text-right">{{ number_format($datos['CORREO']) }}</td>
                    <td class="border px-3 py-2 text-right font-bold bg-slate-50">{{ number_format($datos['TOTAL']) }}</td>
                    <td class="border px-3 py-2 text-right bg-green-50">${{ number_format($datos['MONTO_VIRTUAL'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>