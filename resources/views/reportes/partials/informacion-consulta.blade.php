<div class="reporte-seccion">
    <h2>
        Información de la consulta
    </h2>

    <table class="w-full border text-sm">
        <tbody>
            <tr>
                <td class="border px-3 py-2 font-semibold bg-gray-100 w-40">Período</td>
                <td class="border px-3 py-2">{{ $reporte['encabezado']['periodo']['tipo'] }}</td>
                <td class="border px-3 py-2 font-semibold bg-gray-100 w-40">Módulo</td>
                <td class="border px-3 py-2">{{ $reporte['encabezado']['modulo'] }}</td>
            </tr>
            <tr>
                <td class="border px-3 py-2 font-semibold bg-gray-100">Del</td>
                <td class="border px-3 py-2">
                    {{ \Carbon\Carbon::parse($reporte['encabezado']['periodo']['fecha_inicio'])->format('d/m/Y') }}
                </td>
                <td class="border px-3 py-2 font-semibold bg-gray-100">Al</td>
                <td class="border px-3 py-2">
                    {{ \Carbon\Carbon::parse($reporte['encabezado']['periodo']['fecha_fin'])->format('d/m/Y') }}
                </td>
            </tr>
            <tr>
                <td class="border px-3 py-2 font-semibold bg-gray-100">Asesor</td>
                <td class="border px-3 py-2">{{ $reporte['encabezado']['consulta']['asesor'] ?? 'TODOS' }}</td>
                <td class="border px-3 py-2 font-semibold bg-gray-100">Modalidad</td>
                <td class="border px-3 py-2">{{ $reporte['encabezado']['consulta']['modalidad'] ?? 'TODAS' }}</td>
            </tr>
        </tbody>
    </table>
</div>