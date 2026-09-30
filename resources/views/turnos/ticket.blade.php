<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <title>Turno {{ $turno->folio }}</title>

    <style>
        @page {
            size: 80mm auto;
            margin: 3mm;
        }

        body {
            width: 74mm;
            margin: 0;
            padding: 0;
            font-family: monospace;
            font-size: 12px;
            color: #000;
        }

        .ticket {
            text-align: center;
        }

        .folio {
            font-size: 34px;
            font-weight: bold;
            margin: 8px 0;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 8px 0;
        }

        .small {
            font-size: 11px;
        }

        .no-print {
            margin-top: 10px;
            text-align: center;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="ticket">
        <strong>ATENCIÓN AL CONTRIBUYENTE</strong>

        <div class="line"></div>

        <div>TURNO</div>

        <div class="folio">
            {{ $turno->folio }}
        </div>

        <div class="line"></div>

        <div class="small">
            {{ $turno->contribuyente->razon_social }}
        </div>

        <div class="small">
            RFC: {{ $turno->contribuyente->rfc }}
        </div>

        <div class="line"></div>

        <div class="small">
            Fecha: {{ $turno->fecha->format('d/m/Y') }}
        </div>

        <div class="small">
            Hora: {{ $turno->hora_generado }}
        </div>

        <div class="line"></div>

        <strong>ESPERE SU LLAMADO</strong>
    </div>

    <div class="no-print">
        <button onclick="window.print()">
            Imprimir
        </button>
    </div>
</body>
</html>