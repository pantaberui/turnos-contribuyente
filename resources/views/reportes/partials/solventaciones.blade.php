<div class="reporte-seccion">
    <h2 class="documento-titulo-seccion">
        SOLVENTACIONES
    </h2>

    <table class="reporte-tabla">
        <tbody>
            <tr>
                <td>
                    SOLVENTACIÓN DE REQUERIMIENTOS OBLIGACIONES ESTATALES
                </td>
                <td class="reporte-numero">
                    {{ number_format($reporte->solventaciones['estatales'] ?? 0) }}
                </td>
            </tr>

            <tr>
                <td>
                    SOLVENTACIÓN DE REQUERIMIENTOS OBLIGACIONES FEDERALES
                </td>
                <td class="reporte-numero">
                    {{ number_format($reporte->solventaciones['federales'] ?? 0) }}
                </td>
            </tr>

            <tr>
                <td>
                    SOLVENTACIÓN Y/O VERIFICACIÓN DE DATOS O EXHORTOS
                </td>
                <td class="reporte-numero">
                    {{ number_format($reporte->solventaciones['exhortos'] ?? 0) }}
                </td>
            </tr>

            <tr class="reporte-fila-total">
                <td>
                    TOTAL DE REQUERIMIENTO Y EXHORTOS
                </td>
                <td class="reporte-numero">
                    {{ number_format($reporte->solventaciones['total'] ?? 0) }}
                </td>
            </tr>
        </tbody>
    </table>
</div>