@if(($reporte->complementario['aplica'] ?? false))

    <div class="reporte-seccion">

        <h2 class="documento-titulo-seccion">
            DATOS COMPLEMENTARIOS
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
                    <td>Talleres fiscales RIF</td>
                    <td class="reporte-numero">
                        {{ number_format($reporte->complementario['talleres_rif'] ?? 0) }}
                    </td>
                </tr>

                <tr>
                    <td>Talleres fiscales estatales</td>
                    <td class="reporte-numero">
                        {{ number_format($reporte->complementario['talleres_estatales'] ?? 0) }}
                    </td>
                </tr>

                <tr>
                    <td>Total de proyectos realizados</td>
                    <td class="reporte-numero">
                        {{ number_format($reporte->complementario['proyectos_realizados'] ?? 0) }}
                    </td>
                </tr>

            </tbody>

        </table>

    </div>

@endif