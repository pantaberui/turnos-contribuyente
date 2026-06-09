@php
    \Carbon\Carbon::setLocale('es');
@endphp

<div wire:poll.keep-alive.5s class="min-h-screen bg-gray-900 text-white p-6">

    {{-- Encabezado institucional --}}   {{-- Fecha y reloj --}}
    <div
        wire:ignore
        style="display:flex; justify-content:space-between; align-items:center; background:#111827; color:white; border-radius:16px; padding:12px 24px; margin-bottom:16px;"
    >
        <div>
            <img
                src="{{ asset('images/institucional/logo-nayarit.png') }}"
                alt="Gobierno del Estado de Nayarit"
                width ="150"
                class="h-10 object-contain"
            >
        </div>
        <div class="text-center">
            <h1 class="text-2xl font-white uppercase">
                Gobierno del Estado de Nayarit
            </h1>

            <p class="text-xl font-semibold text-white-700">
                Secretaría de Administración y Finanzas
            </p>

            <p class="text-lg text-white-600">
                Departamento de Asistencia al Contribuyente
            </p>
        </div>
        <div>
            <div style="font-size:20px; font-weight:600;">
                Tepic, Nayarit a {{ now()->translatedFormat('j \d\e F \d\e Y') }}
            </div>

            <div id="reloj-digital" style="font-size:42px; font-weight:900; font-family:monospace;">
                --:--:--
            </div>
        </div>    
    </div>


    <div style="
        display:grid;
        grid-template-columns:1.2fr 1.6fr .8fr;
        gap:12px;
        margin-bottom:12px;
        align-items:stretch;
    ">

    {{-- Video institucional --}}    
    <div style="
        background:#111827;
        border-radius:24px;
        padding:20px;
        box-shadow:0 8px 20px rgba(0,0,0,.25);
    ">

        <div style="
            color:white;
            font-size:24px;
            font-weight:900;
            text-align:center;
            margin-bottom:12px;
            text-transform:uppercase;
        ">
            Información Institucional
        </div>

        @if(file_exists(public_path('videos/institucional.mp4')))
            <video
                autoplay
                muted
                loop
                playsinline
                style="
                    width:100%;
                    border-radius:16px;
                    display:block;
                "
            >
                <source
                    src="{{ asset('videos/institucional.mp4') }}"
                    type="video/mp4"
                >
            </video>
        @else
            <div style="
                height:220px;
                display:flex;
                align-items:center;
                justify-content:center;
                color:#d1d5db;
                font-size:22px;
                font-weight:700;
            ">
                VIDEO INSTITUCIONAL
            </div>
        @endif

    </div>
    {{-- FIN Video institucional --}}  
    

    {{-- Turno llamado --}}
    <div>
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
                        animation:pulseTurno 1s infinite;
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


        {{-- Mensaje institucional --}}
        <div style="
            background:#ffffff;
            color:#111827;
            border-radius:20px;
            padding:24px;
            margin-top:24px;
            text-align:center;
            box-shadow:0 8px 20px rgba(0,0,0,.25);
            border-left:8px solid #2563eb;
            border-right:8px solid #2563eb;
        ">

            <div style="font-size:25px; font-weight:900; text-transform:uppercase; color:#1d4ed8;">
                Bienvenido al Departamento de Asistencia al Contribuyente
            </div>

            <div style="font-size:20px; font-weight:700; margin-top:10px; color:#374151;">
                Para una mejor atención, tenga a la mano su RFC, CURP e identificación oficial.
            </div>

        </div>




    </div>


    {{-- Próximos turnos --}}   
    <div style="background:#1f2937; border-radius:24px; padding:28px; margin-bottom:24px; box-shadow:0 8px 20px rgba(0,0,0,.25);">

        <h2 style="color:white; font-size:32px; font-weight:800; text-align:center; margin-bottom:20px; text-transform:uppercase;">
            Próximos Turnos
        </h2>

        <div style="display:flex; flex-wrap:wrap; justify-content:center; gap:16px;">

            @forelse($proximosTurnos as $index => $turno)

                <div style="
                    width:220px;
                    background:white;
                    border-radius:16px;
                    overflow:hidden;
                    border:5px solid {{ $index == 0 ? '#2563eb' : '#9ca3af' }};
                    box-shadow:0 10px 25px rgba(0,0,0,.35);
                ">

                    <div style="
                        background:{{ $index == 0 ? '#2563eb' : '#6b7280' }};
                        color:white;
                        padding:10px;
                        text-align:center;
                    ">
                        <div style="
                            font-size:14px;
                            font-weight:900;
                            text-transform:uppercase;
                        ">
                            {{ $index == 0 ? 'Próximo' : 'En espera' }}
                        </div>
                    </div>

                    <div style="
                        background:white;
                        text-align:center;
                        padding:12px;
                    ">
                        <div style="
                            color:#111827;
                            font-size:50px;
                            font-weight:900;
                        ">
                            {{ $turno->folio }}
                        </div>
                    </div>

                </div>
            @empty
                <div style="
                    color:#d1d5db;
                    font-size:28px;
                    text-align:center;
                    padding:24px;
                ">
                    No hay turnos en espera
                </div>
            @endforelse
        </div>
    </div>
</div>  


{{-- Módulos en atención --}}           
<div style="background:#1f2937; border-radius:20px; padding:24px; margin-bottom:18px; box-shadow:0 8px 20px rgba(0,0,0,.25);">
    <h2 style="color:white; font-size:32px; font-weight:800; text-align:center; margin-bottom:24px; text-transform:uppercase;">
        Módulos en atención
    </h2>

    <div style="display:flex; flex-wrap:wrap; justify-content:center; gap:32px;">
        @forelse($turnosEnAtencion as $turno)

            <div style="width:260px; background:white; border-radius:24px; overflow:hidden; border:5px solid #22c55e; box-shadow:0 10px 25px rgba(0,0,0,.35);">

                <div style="background:#16a34a; color:white; padding:15px; text-align:center;">
                    <div style="font-size:30px; font-weight:900; text-transform:uppercase;">
                        {{ $turno->moduloAsesoria?->nombre ?? 'MÓDULO' }}
                    </div>
                </div>

                <div style="background:white; text-align:center; padding:10px;">
                    <div style="color:#4b5563; font-size:20px; font-weight:800; text-transform:uppercase;">
                        Atendiendo
                    </div>

                    <div style="color:#15803d; font-size:50px; font-weight:900; margin-top:10px;">
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


<style>
    @keyframes pulseTurno {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.06); opacity: .75; }
        100% { transform: scale(1); opacity: 1; }
    }
</style>

<script>
    if (!window.relojDisplayTurnosInicializado) {
        window.relojDisplayTurnosInicializado = true;

        function actualizarRelojDisplayTurnos() {
            const reloj = document.getElementById('reloj-digital');

            if (!reloj) {
                return;
            }

            reloj.textContent = new Date().toLocaleTimeString('es-MX', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
        }

        actualizarRelojDisplayTurnos();
        setInterval(actualizarRelojDisplayTurnos, 1000);
    }
</script>