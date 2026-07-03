<form method="GET" class="flex flex-wrap gap-4 items-end">
    <div>
        <label class="block text-sm font-medium">Periodo</label>
        <select name="periodo" class="rounded border-gray-300 min-w-[130px]">
            @foreach(['Semanal', 'Quincenal', 'Mensual', 'Personalizado'] as $periodo)
                <option value="{{ $periodo }}" @selected($tipoPeriodo === $periodo)>
                    {{ $periodo }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium">Fecha inicio</label>
        <input type="date" name="inicio" value="{{ $fechaInicio }}" class="rounded border-gray-300">
    </div>

    <div>
        <label class="block text-sm font-medium">Fecha fin</label>
        <input type="date" name="fin" value="{{ $fechaFin }}" class="rounded border-gray-300">
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