<div class="reporte-seccion">
    <h2>
        Información de la consulta
    </h2>

    <table class="reporte-tabla">
        <tbody>
            <tr>
                <td class="font-semibold bg-gray-100 w-40">Período</td>
                <td>{{ $reporte->encabezado['periodo']['tipo'] }}</td>
                <td class="font-semibold bg-gray-100 w-40">Módulo</td>
                <td>{{ $reporte->encabezado['modulo'] }}</td>
            </tr>
            <tr>
                <td class="font-semibold bg-gray-100">Del</td>
                <td>{{ \Carbon\Carbon::parse($reporte->encabezado['periodo']['fecha_inicio'])->format('d/m/Y') }}</td>
                <td class="font-semibold bg-gray-100">Al</td>
                <td>{{ \Carbon\Carbon::parse($reporte->encabezado['periodo']['fecha_fin'])->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td class="font-semibold bg-gray-100">Asesor</td>
                <td>{{ $reporte->encabezado['consulta']['asesor'] ?? 'TODOS' }}</td>
                <td class="font-semibold bg-gray-100">Modalidad</td>
                <td>{{ $reporte->encabezado['consulta']['modalidad'] ?? 'TODAS' }}</td>
            </tr>
        </tbody>
    </table>
</div>