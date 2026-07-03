<form method="GET" class="flex flex-wrap gap-4 items-end">
    <div>
        <label class="block text-sm font-medium">Periodo</label>
        <select id="periodo" name="periodo" class="rounded border-gray-300 min-w-[130px]">
            @foreach(['Semanal', 'Quincenal', 'Mensual', 'Personalizado'] as $periodo)
                <option value="{{ $periodo }}" @selected($tipoPeriodo === $periodo)>
                    {{ $periodo }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium">Fecha inicio</label>
        <input id="fecha_inicio" type="date" name="inicio" value="{{ $fechaInicio }}" class="rounded border-gray-300">
    </div>

    <div>
        <label class="block text-sm font-medium">Fecha fin</label>
        <input id="fecha_fin" type="date" name="fin" value="{{ $fechaFin }}" class="rounded border-gray-300">
    </div>

    <div>
        <label class="block text-sm font-medium">Modalidad</label>
        <select name="modalidad" class="rounded border-gray-300 min-w-[150px]">
            <option value="">Todas</option>
            <option value="PRESENCIAL" @selected($modalidad === 'PRESENCIAL')>Presencial</option>
            <option value="TELEFONICA" @selected($modalidad === 'TELEFONICA')>Telefónica</option>
            <option value="CORREO" @selected($modalidad === 'CORREO')>Correo electrónico</option>
        </select>
    </div>

    <div class="flex-1 min-w-[220px]">
        <label class="block text-sm font-medium">Asesor</label>
        <select name="asesor_id" class="w-full rounded border-gray-300">
            <option value="">TODOS</option>
            @foreach($asesores as $asesor)
                <option value="{{ $asesor->id }}" @selected((string) $asesorId === (string) $asesor->id)>
                    {{ mb_strtoupper($asesor->name, 'UTF-8') }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit"
            style="background:#1f2937;color:white;padding:9px 16px;border-radius:6px;font-weight:bold;">
        Consultar
    </button>

    <a href="{{ route('reportes.asesor-fiscal.pdf', request()->query()) }}"
        target="_blank"
        style="background:#991b1b;color:white;padding:9px 16px;border-radius:6px;font-weight:bold;">
            Generar PDF
    </a>
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const periodo = document.getElementById('periodo');
    const inicio = document.getElementById('fecha_inicio');
    const fin = document.getElementById('fecha_fin');

    if (!periodo || !inicio || !fin) {
        return;
    }

    periodo.addEventListener('change', function () {
        const hoy = new Date();
        let fechaInicio = new Date(hoy);
        let fechaFin = new Date(hoy);

        if (this.value === 'Semanal') {
            const dia = hoy.getDay(); // domingo=0
            const diferenciaLunes = dia === 0 ? -6 : 1 - dia;

            fechaInicio = new Date(hoy);
            fechaInicio.setDate(hoy.getDate() + diferenciaLunes);

            fechaFin = new Date(fechaInicio);
            fechaFin.setDate(fechaInicio.getDate() + 6);
        }

        if (this.value === 'Quincenal') {
            fechaInicio = new Date(hoy.getFullYear(), hoy.getMonth(), hoy.getDate() <= 15 ? 1 : 16);
            fechaFin = hoy.getDate() <= 15
                ? new Date(hoy.getFullYear(), hoy.getMonth(), 15)
                : new Date(hoy.getFullYear(), hoy.getMonth() + 1, 0);
        }

        if (this.value === 'Mensual') {
            fechaInicio = new Date(hoy.getFullYear(), hoy.getMonth(), 1);
            fechaFin = new Date(hoy.getFullYear(), hoy.getMonth() + 1, 0);
        }

        if (this.value === 'Personalizado') {
            return;
        }

        inicio.value = formatearFecha(fechaInicio);
        fin.value = formatearFecha(fechaFin);
    });

    function formatearFecha(fecha) {
        const year = fecha.getFullYear();
        const month = String(fecha.getMonth() + 1).padStart(2, '0');
        const day = String(fecha.getDate()).padStart(2, '0');

        return `${year}-${month}-${day}`;
    }
});
</script>