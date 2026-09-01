<div class="reporte-seccion">

    <h2>
        Contribuyentes atendidos
    </h2>

    <table class="reporte-tabla">

        <thead>
            <tr>
                <th>Concepto</th>
                <th>Total</th>
            </tr>
        </thead>

        <tbody>

            <tr>
                <td>Contribuyentes RIF</td>
                <td class="reporte-numero">
                    {{ number_format($reporte->contribuyentes['rif'] ?? 0) }}
                </td>
            </tr>

            <tr>
                <td>Contribuyentes Estatales</td>
                <td class="reporte-numero">
                    {{ number_format($reporte->contribuyentes['estatales'] ?? 0) }}
                </td>
            </tr>

        </tbody>

    </table>

</div>