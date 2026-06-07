<div wire:poll.keep-alive.5s class="min-h-screen bg-gray-900 text-white p-6">

    {{-- Encabezado institucional --}}
    <div class="bg-white text-gray-900 rounded-2xl shadow-lg p-4 mb-4">
        <div class="flex items-center justify-center gap-10">
            <img
                src="{{ asset('images/institucional/logo-nayarit.png') }}"
                alt="Gobierno del Estado de Nayarit"
                class="h-16 object-contain"
            >

            <div class="text-center">
                <h1 class="text-2xl font-black uppercase">
                    Gobierno del Estado de Nayarit
                </h1>

                <p class="text-xl font-semibold text-gray-700">
                    Secretaría de Administración y Finanzas
                </p>

                <p class="text-lg text-gray-600">
                    Departamento de Asistencia al Contribuyente
                </p>
            </div>
        </div>
    </div>

    {{-- Fecha y reloj --}}
    <div class="flex justify-between items-center mb-4 px-4 text-white">
        <div class="text-3xl font-bold">
            {{ now()->format('d/m/Y') }}
        </div>

        <div id="reloj-digital" class="text-5xl font-mono font-black tracking-wider">
            --:--:--
        </div>
    </div>

    {{-- Turno llamado --}}    
    <div style="
        background:#1d4ed8;
        border-radius:24px;
        padding:30px;
        margin-bottom:24px;
        text-align:center;
        box-shadow:0 10px 25px rgba(0,0,0,.35);
    ">

        <div style="
            color:white;
            font-size:32px;
            font-weight:900;
            text-transform:uppercase;
            margin-bottom:20px;
        ">
            Turno llamado
        </div>

        @if($turnoActual)

            <div style="
                background:white;
                border-radius:20px;
                padding:30px;
                max-width:700px;
                margin:0 auto;
                box-shadow:0 8px 20px rgba(0,0,0,.25);
            ">

                <div style="
                    color:#1d4ed8;
                    font-size:90px;
                    font-weight:900;
                    line-height:1;
                ">
                    {{ $turnoActual->folio }}
                </div>

                <div style="
                    color:#6b7280;
                    font-size:24px;
                    font-weight:700;
                    margin-top:15px;
                    text-transform:uppercase;
                ">
                    Pase al
                </div>

                <div style="
                    background:#16a34a;
                    color:white;
                    border-radius:16px;
                    padding:15px;
                    margin-top:15px;
                    font-size:42px;
                    font-weight:900;
                    text-transform:uppercase;
                ">
                    {{ $turnoActual->moduloAsesoria?->nombre ?? 'MÓDULO ASIGNADO' }}
                </div>

            </div>

        @else

            <div style="
                background:white;
                color:#1d4ed8;
                border-radius:20px;
                padding:30px;
                max-width:700px;
                margin:0 auto;
                font-size:42px;
                font-weight:900;
            ">
                Esperando llamado
            </div>

        @endif

    </div>

    {{-- Módulos en atención --}}    
    <div style="background:#1f2937; border-radius:24px; padding:32px; margin-bottom:24px; box-shadow:0 8px 20px rgba(0,0,0,.25);">

        <h2 style="color:white; font-size:32px; font-weight:800; text-align:center; margin-bottom:24px; text-transform:uppercase;">
            Módulos en atención
        </h2>

        <div style="display:flex; flex-wrap:wrap; justify-content:center; gap:32px;">
            @forelse($turnosEnAtencion as $turno)

                <div style="width:320px; background:white; border-radius:24px; overflow:hidden; border:5px solid #22c55e; box-shadow:0 10px 25px rgba(0,0,0,.35);">

                    <div style="background:#16a34a; color:white; padding:18px; text-align:center;">
                        <div style="font-size:30px; font-weight:900; text-transform:uppercase;">
                            {{ $turno->moduloAsesoria?->nombre ?? 'MÓDULO' }}
                        </div>
                    </div>

                    <div style="background:white; text-align:center; padding:26px;">
                        <div style="color:#4b5563; font-size:22px; font-weight:800; text-transform:uppercase;">
                            Atendiendo
                        </div>

                        <div style="color:#15803d; font-size:64px; font-weight:900; margin-top:12px;">
                            {{ $turno->folio }}
                        </div>
                    </div>

                </div>

            @empty
                <div style="color:#d1d5db; font-size:28px; text-align:center; padding:24px;">
                    No hay módulos en atención
                </div>
            @endforelse
        </div>

    </div>

    {{-- Próximos turnos --}}
    <div class="bg-gray-800 rounded-3xl p-8 shadow-lg">
        <h2 class="text-3xl font-bold text-center mb-6 uppercase">
            Próximos turnos
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($proximosTurnos as $turno)
                <div class="bg-gray-700 rounded-2xl p-6 text-center shadow-lg">
                    <span class="text-6xl font-black">
                        {{ $turno->folio }}
                    </span>
                </div>
            @empty
                <div class="text-center text-gray-400 text-2xl py-10 col-span-full">
                    No hay turnos en espera
                </div>
            @endforelse
        </div>
    </div>

    <div class="mt-6 text-center text-gray-400 text-lg">
        Actualización automática
    </div>

</div>

<script>
    function actualizarReloj() {
        const reloj = document.getElementById('reloj-digital');

        if (! reloj) {
            return;
        }

        reloj.textContent = new Date().toLocaleTimeString('es-MX');
    }

    actualizarReloj();
    setInterval(actualizarReloj, 1000);
</script>