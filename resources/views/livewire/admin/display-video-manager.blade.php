<div style="max-width:1000px; margin:40px auto; padding:30px;">

    {{-- Encabezado --}}
    <div style="
        background:#111827;
        color:white;
        border-radius:16px;
        padding:24px;
        box-shadow:0 8px 20px rgba(0,0,0,.20);
        margin-bottom:24px;
    ">

        <h1 style="
            font-size:28px;
            font-weight:900;
            margin-bottom:8px;
        ">
            Video del Display
        </h1>

        <p style="
            color:#d1d5db;
            font-size:16px;
        ">
            Administra el video que se muestra en la pantalla de turnos.
        </p>

    </div>


    {{-- Mensaje de éxito --}}
    @if (session()->has('mensaje'))

        <div style="
            background:#dcfce7;
            color:#166534;
            border:1px solid #86efac;
            border-radius:12px;
            padding:14px 18px;
            margin-bottom:20px;
            font-weight:800;
        ">
            {{ session('mensaje') }}
        </div>

    @endif


    {{-- Video actual --}}
    @if($videoActual)

        <div style="
            background:#ffffff;
            border-radius:20px;
            padding:24px;
            box-shadow:0 8px 20px rgba(0,0,0,.15);
            margin-bottom:24px;
        ">

            <div style="
                font-size:22px;
                font-weight:900;
                color:#111827;
                margin-bottom:15px;
            ">
                Video actual
            </div>

            <div style="
                background:#111827;
                border-radius:16px;
                padding:12px;
                margin-bottom:18px;
            ">

                <video
                    controls
                    preload="metadata"
                    style="
                        width:100%;
                        max-height:500px;
                        border-radius:12px;
                        display:block;
                        background:#000;
                    "
                >
                    <source
                        src="{{ asset('storage/' . $videoActual->archivo) }}"
                        type="video/mp4"
                    >
                    Tu navegador no puede reproducir este video.
                </video>

            </div>

            <div style="
                color:#374151;
                font-size:16px;
            ">
                <strong>Archivo:</strong>
                {{ $videoActual->nombre }}
            </div>

        </div>

    @else

        <div style="
            background:#fef3c7;
            color:#92400e;
            border:1px solid #fcd34d;
            border-radius:16px;
            padding:20px;
            margin-bottom:24px;
            font-weight:800;
        ">
            Actualmente no hay ningún video configurado para el Display.
        </div>

    @endif


    {{-- Subir / reemplazar --}}
    <div style="
        background:#ffffff;
        border-radius:20px;
        padding:24px;
        box-shadow:0 8px 20px rgba(0,0,0,.15);
    ">

        <div style="
            font-size:22px;
            font-weight:900;
            color:#111827;
            margin-bottom:8px;
        ">
            {{ $videoActual ? 'Reemplazar video' : 'Subir video' }}
        </div>

        <div style="
            color:#6b7280;
            margin-bottom:20px;
        ">
            Selecciona un archivo de video en formato MP4.
            Tamaño máximo: 500 MB.
        </div>


        <form wire:submit="guardarVideo">

            <div style="margin-bottom:20px;">

                <input
                    type="file"
                    wire:model="video"
                    accept="video/mp4"
                    style="
                        display:block;
                        width:100%;
                        padding:14px;
                        border:2px dashed #9ca3af;
                        border-radius:12px;
                        background:#f9fafb;
                        cursor:pointer;
                    "
                >

                @error('video')
                    <div style="
                        color:#dc2626;
                        font-weight:700;
                        margin-top:8px;
                    ">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            {{-- Indicador de progreso de carga --}}
            <div
                x-data="{
                    uploading: false,
                    progress: 0,
                    processing: false
                }"

                x-on:livewire-upload-start="
                    uploading = true;
                    processing = false;
                    progress = 0;
                "

                x-on:livewire-upload-progress="
                    progress = $event.detail.progress;
                "

                x-on:livewire-upload-finish="
                    uploading = false;
                    processing = true;
                    progress = 100;
                "

                x-on:livewire-upload-error="
                    uploading = false;
                    processing = false;
                    progress = 0;
                "

                x-on:livewire-upload-cancel="
                    uploading = false;
                    processing = false;
                    progress = 0;
                "

                x-show="uploading || processing"
                x-cloak

                style="
                    position:fixed;
                    inset:0;
                    z-index:99999;
                    background:rgba(17,24,39,.82);
                    align-items:center;
                    justify-content:center;
                "
            >
                <div style="
                    background:white;
                    border-radius:20px;
                    padding:35px 50px;
                    text-align:center;
                    box-shadow:0 15px 40px rgba(0,0,0,.40);
                    min-width:300px;
                ">

                    {{-- Anillo --}}
                    <div style="
                        width:110px;
                        height:110px;
                        margin:0 auto 20px;
                        position:relative;
                    ">

                        <svg
                            width="110"
                            height="110"
                            viewBox="0 0 110 110"
                            style="transform:rotate(-90deg);"
                        >
                            <circle
                                cx="55"
                                cy="55"
                                r="46"
                                fill="none"
                                stroke="#e5e7eb"
                                stroke-width="9"
                            />

                            <circle
                                cx="55"
                                cy="55"
                                r="46"
                                fill="none"
                                stroke="#2563eb"
                                stroke-width="9"
                                stroke-linecap="round"
                                stroke-dasharray="289"
                                :stroke-dashoffset="289 - (289 * progress / 100)"
                                style="transition:stroke-dashoffset .2s ease;"
                            />
                        </svg>

                        {{-- Porcentaje --}}
                        <div
                            x-text="Math.round(progress) + '%'"
                            style="
                                position:absolute;
                                inset:0;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                                font-size:24px;
                                font-weight:900;
                                color:#111827;
                            "
                        ></div>

                    </div>


                    {{-- Texto --}}
                    <div
                        x-show="uploading"
                        style="
                            font-size:22px;
                            font-weight:900;
                            color:#111827;
                        "
                    >
                        Subiendo video...
                    </div>

                    <div
                        x-show="processing"
                        style="
                            font-size:22px;
                            font-weight:900;
                            color:#111827;
                        "
                    >
                        Procesando video...
                    </div>

                    <div
                        x-show="uploading"
                        style="
                            margin-top:8px;
                            color:#6b7280;
                            font-size:15px;
                        "
                    >
                        Por favor espera, no cierres esta ventana.
                    </div>

                    <div
                        x-show="processing"
                        style="
                            margin-top:8px;
                            color:#6b7280;
                            font-size:15px;
                        "
                    >
                        El video se está guardando...
                    </div>

                </div>
            </div>



            <button
                type="submit"
                wire:loading.attr="disabled"
                wire:target="guardarVideo"
                style="
                    background:#2563eb;
                    color:white;
                    border:none;
                    border-radius:12px;
                    padding:14px 24px;
                    font-size:16px;
                    font-weight:900;
                    cursor:pointer;
                    box-shadow:0 6px 15px rgba(37,99,235,.30);
                "
            >
                {{ $videoActual ? '🔄 Reemplazar video' : '📤 Subir video' }}
            </button>

        </form>

    </div>


    {{-- Eliminar --}}
    @if($videoActual)

        <div style="
            background:#ffffff;
            border-radius:20px;
            padding:24px;
            margin-top:24px;
            box-shadow:0 8px 20px rgba(0,0,0,.15);
        ">

            <div style="
                font-size:18px;
                font-weight:900;
                color:#991b1b;
                margin-bottom:8px;
            ">
                Eliminar video
            </div>

            <div style="
                color:#6b7280;
                margin-bottom:15px;
            ">
                Si eliminas el video, el Display mostrará el mensaje
                de video institucional hasta que se cargue uno nuevo.
            </div>

            <button
                type="button"
                wire:click="eliminarVideo"
                wire:confirm="¿Estás seguro de eliminar el video actual?"
                style="
                    background:#dc2626;
                    color:white;
                    border:none;
                    border-radius:12px;
                    padding:12px 20px;
                    font-weight:900;
                    cursor:pointer;
                "
            >
                🗑️ Eliminar video
            </button>

        </div>

    @endif

</div>

<style>
    @keyframes girarAnillo {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }
    [x-cloak] {
        display: none !important;
    }
</style>