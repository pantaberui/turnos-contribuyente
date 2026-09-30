<style>
    .pdf-header {
        width: 100%;
        font-family: Arial, sans-serif;
        font-size: 8px;
        padding: 0 20px;
        box-sizing: border-box;
    }

    .pdf-header-inner {
        border-bottom: 1px solid #999;
        padding-bottom: 4px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .pdf-title {
        font-weight: bold;
        text-align: right;
        font-size: 9px;
    }

    .pdf-periodo {
        font-size: 7px;
        color: #444;
    }
</style>

<div class="pdf-header">
    <div class="pdf-header-inner">
        <div>
            Secretaría de Administración y Finanzas
        </div>

        <div class="pdf-title">
            {{ $reporte->encabezado['reporte']['nombre'] }}
            <div class="pdf-periodo">
                {{ \Carbon\Carbon::parse($reporte->encabezado['periodo']['fecha_inicio'])->format('d/m/Y') }}
                -
                {{ \Carbon\Carbon::parse($reporte->encabezado['periodo']['fecha_fin'])->format('d/m/Y') }}
            </div>
        </div>
    </div>
</div>