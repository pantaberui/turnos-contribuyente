@php
    \Carbon\Carbon::setLocale('es');
@endphp

<div wire:poll.keep-alive.5s class="min-h-screen bg-gray-900 text-white p-6">

    <audio id="sonido-llamado" preload="auto">
        <source src="{{ asset('sounds/ding.mp3') }}" type="audio/mpeg">
    </audio>

    {{-- Encabezado institucional --}}   {{-- Fecha y reloj --}}
    <div
        wire:ignore
        style="display:flex; justify-content:space-between; align-items:center; background:#111827; color:white; border-radius:16px; padding:12px 24px; margin-bottom:16px;"
    >
        <div>
            <img
                src="{{ asset('images/institucional/logo-nayarit.png') }}"
                alt="Gobierno del Estado de Nayarit"
                class="h-24 w-auto object-contain"
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
        margin-bottom:5px;
        align-items:stretch;
    ">

        {{-- Video institucional --}}    
        <div wire:ignore style="            
            background:#111827;
            border-radius:24px;
            padding:12px;
            heigh:360px;
            box-shadow:0 8px 20px rgba(0,0,0,.25);
        ">
            
            <div style="
                color:white;
                font-size:32px;
                font-weight:900;
                text-align:center;
                margin-bottom:20px;
                text-transform:uppercase;
            ">
                Información Institucional
            </div>

            @if($videoActual)
                <video
                    id="video-institucional"
                    autoplay
                    muted
                    loop
                    playsinline
                    preload="auto"
                    style="
                        width:100%;
                        border-radius:16px;
                        display:block;
                        object-fit:cover;
                    "
                >
                    <source
                        src="{{ asset('storage/' . $videoActual->archivo) }}"
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
                    font-size:30px;
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
                        padding:10px;
                        max-width:700px;
                        margin:0 auto;
                        box-shadow:0 8px 20px rgba(0,0,0,.25);
                    ">

                        <div 
                            id="turno-llamado-folio"
                            style="
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
                            padding:10px;
                            margin-top:15px;
                            font-size:40px;
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

                <div style="font-size:20px; font-weight:900; text-transform:uppercase; color:#1d4ed8;">
                    Bienvenido al Departamento de Asistencia al Contribuyente
                </div>

                <div style="font-size:20px; font-weight:700; margin-top:10px; color:#374151;">
                    Para una mejor atención, tenga a la mano su RFC, CURP e identificación oficial.
                </div>

            </div>

        </div>
        {{-- Finaliza Turno llamado --}}

        {{-- Próximos turnos --}}   
        <div style="background:#1f2937; border-radius:24px; padding:28px; margin-bottom:24px; box-shadow:0 8px 20px rgba(0,0,0,.25);">

            <h2 style="color:white; font-size:32px; font-weight:800; text-align:center; margin-bottom:20px; text-transform:uppercase;">
                Próximos Turnos
            </h2>

            <div style="display:flex; flex-direction:column; align-items:center; gap:12px;">

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
        {{-- Finaliza Próximos Turnos --}}           
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
    {{-- Finaliza Módulos en atención --}}           



    {{-- Controles de sonido del Display --}}
    <div
        wire:ignore
        style="
            position:fixed;
            bottom:16px;
            right:16px;
            z-index:9999;
            display:flex;
            flex-direction:column;
            gap:10px;
        "
    >

        {{-- Sonido del video --}}
        <button
            id="boton-sonido-video"
            onclick="activarSonidoVideo()"
            style="
                background:#2563eb;
                color:white;
                padding:12px 18px;
                border-radius:12px;
                font-weight:900;
                border:none;
                cursor:pointer;
                box-shadow:0 8px 20px rgba(0,0,0,.35);
            "
        >
            🎬 🔇 Video: Silenciado
        </button>

        {{-- Sonido de llamados --}}
        <button
            id="boton-sonido-turnos"
            onclick="activarSonidoTurnos()"
            style="
                background:#16a34a;
                color:white;
                padding:12px 18px;
                border-radius:12px;
                font-weight:900;
                border:none;
                cursor:pointer;
                box-shadow:0 8px 20px rgba(0,0,0,.35);
            "
        >
            🔔 🔇 Turnos: Silenciados
        </button>

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
        /*
        |--------------------------------------------------------------------------
        | Display de Turnos
        |--------------------------------------------------------------------------
        | Un solo reloj
        | Un solo detector de cambios de turno
        | Los sonidos permanecen independientes
        |--------------------------------------------------------------------------
        */

        if (!window.displayTurnosInicializado) {

            window.displayTurnosInicializado = true;

            window.ultimoTurnoLlamado = null;

            /*
            |--------------------------------------------------------------------------
            | RELOJ
            |--------------------------------------------------------------------------
            */

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


            /*
            |--------------------------------------------------------------------------
            | SONIDO DEL VIDEO
            |--------------------------------------------------------------------------
            */

            function activarSonidoVideo() {

                const video = document.getElementById('video-institucional');
                const boton = document.getElementById('boton-sonido-video');

                if (!video) {
                    return;
                }

                if (video.muted) {

                    video.muted = false;
                    video.volume = 1;

                    video.play().then(() => {

                        window.sonidoVideoActivado = true;

                        if (boton) {
                            boton.textContent = '🎬 🔊 Video: Con sonido';
                        }

                    }).catch(() => {

                        video.muted = true;
                        window.sonidoVideoActivado = false;

                        if (boton) {
                            boton.textContent = '🎬 🔇 Video: Silenciado';
                        }

                    });

                } else {

                    video.muted = true;
                    window.sonidoVideoActivado = false;

                    if (boton) {
                        boton.textContent = '🎬 🔇 Video: Silenciado';
                    }
                }
            }


            /*
            |--------------------------------------------------------------------------
            | SONIDO DE TURNOS
            |--------------------------------------------------------------------------
            */

            function activarSonidoTurnos() {

                const audio = document.getElementById('sonido-llamado');
                const boton = document.getElementById('boton-sonido-turnos');

                if (!audio) {
                    return;
                }

                if (!window.sonidoDisplayActivado) {

                    audio.play().then(() => {

                        audio.pause();
                        audio.currentTime = 0;

                        window.sonidoDisplayActivado = true;

                        if (boton) {
                            boton.textContent = '🔔 🔊 Turnos: Con sonido';
                        }

                    }).catch(() => {

                        window.sonidoDisplayActivado = false;

                        if (boton) {
                            boton.textContent = '🔔 🔇 Turnos: Silenciados';
                        }

                    });

                } else {

                    window.sonidoDisplayActivado = false;

                    if (boton) {
                        boton.textContent = '🔔 🔇 Turnos: Silenciados';
                    }
                }
            }


            /*
            |--------------------------------------------------------------------------
            | DETECTAR NUEVO TURNO
            |--------------------------------------------------------------------------
            */

            function reproducirSonidoSiCambioTurno() {

                const turnoElemento =
                    document.getElementById('turno-llamado-folio');

                if (!turnoElemento) {
                    return;
                }

                const turnoActual =
                    turnoElemento.textContent.trim();

                if (
                    !turnoActual ||
                    turnoActual === window.ultimoTurnoLlamado
                ) {
                    return;
                }

                /*
                |--------------------------------------------------------------------------
                | No reproducir al cargar por primera vez.
                |--------------------------------------------------------------------------
                */

                if (window.ultimoTurnoLlamado !== null) {

                    if (window.sonidoDisplayActivado) {

                        const audio =
                            document.getElementById('sonido-llamado');

                        if (audio) {

                            audio.currentTime = 0;

                            audio.play().catch(() => {});
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Obtener módulo / ventanilla
                        |--------------------------------------------------------------------------
                        */

                        const moduloElemento =
                            document.getElementById(
                                'turno-llamado-modulo'
                            );

                        const moduloActual =
                            moduloElemento
                                ? moduloElemento.textContent.trim()
                                : '';


                        /*
                        |--------------------------------------------------------------------------
                        | Anuncio hablado
                        |--------------------------------------------------------------------------
                        */

                        const mensaje =
                            new SpeechSynthesisUtterance(
                                `Turno ${turnoActual}, favor de pasar al ${moduloActual}`
                            );

                        mensaje.lang = 'es-MX';
                        mensaje.rate = 0.9;
                        mensaje.pitch = 1;

                        window.speechSynthesis.cancel();

                        window.speechSynthesis.speak(mensaje);
                    }
                }

                window.ultimoTurnoLlamado = turnoActual;
            }


            /*
            |--------------------------------------------------------------------------
            | INICIALIZACIÓN
            |--------------------------------------------------------------------------
            */

            actualizarRelojDisplayTurnos();

            reproducirSonidoSiCambioTurno();


            /*
            |--------------------------------------------------------------------------
            | RELOJ
            |--------------------------------------------------------------------------
            */

            setInterval(
                actualizarRelojDisplayTurnos,
                1000
            );


            /*
            |--------------------------------------------------------------------------
            | DETECCIÓN DE NUEVOS TURNOS
            |--------------------------------------------------------------------------
            */

            setInterval(
                reproducirSonidoSiCambioTurno,
                1000
            );
        }


        /*
        |--------------------------------------------------------------------------
        | RESPALDO
        |--------------------------------------------------------------------------
        | Por ahora conservamos la recarga cada 10 minutos.
        | Después podemos evaluar si realmente es necesaria.
        |--------------------------------------------------------------------------
        */

        if (!window.displayRecargaInicializada) {

            window.displayRecargaInicializada = true;

            setInterval(() => {

                window.location.reload();

            }, 10 * 60 * 1000);
        }

    </script>


   
</div> 


