<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistema de Turnos') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">

    <link
        href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap"
        rel="stylesheet"
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="m-0 font-sans antialiased">

    <main class="relative min-h-screen overflow-hidden bg-white">

        {{-- Fondo institucional de escritorio --}}
        <img
            src="{{ asset('images/login/fondo-login.webp') }}"
            alt=""
            aria-hidden="true"
            class="absolute inset-0 hidden h-full w-full object-fill lg:block"
        >

        {{-- Fondo para móvil y tablet --}}
        <div
            class="absolute inset-0 bg-gradient-to-br from-slate-50 via-white to-blue-50 lg:hidden"
        ></div>

        {{-- Contenedor general --}}
        <div class="relative z-10 min-h-screen">

            {{-- Área del formulario --}}
            <section
                class="flex min-h-screen items-center justify-center px-5 py-8
                       sm:px-8
                       lg:absolute lg:inset-y-0 lg:right-[5%]
                       lg:w-[32%] lg:px-0
                       xl:right-[7%] xl:w-[29%]
                       2xl:right-[8%] 2xl:w-[27%]"
            >
                <div class="w-full max-w-md">

                    {{-- Encabezado móvil --}}
                    <div class="mb-7 text-center lg:hidden">
                        <img
                            src="{{ asset('images/login/logo-nayarit.webp') }}"
                            alt="Gobierno del Estado de Nayarit"
                            class="mx-auto mb-5 h-auto w-52 max-w-full"
                        >

                        <p class="text-sm font-bold uppercase tracking-[0.15em] text-[#a87925]">
                            Gobierno del Estado de Nayarit
                        </p>

                        <h1 class="mt-3 text-2xl font-extrabold text-[#082b56]">
                            Sistema de Turnos
                        </h1>

                        <p class="mt-1 text-sm text-slate-600">
                            para Asistencia al Contribuyente
                        </p>

                        <p class="mt-4 text-xs leading-relaxed text-slate-500">
                            Secretaría de Administración y Finanzas
                            <br>
                            Departamento de Asistencia al Contribuyente
                        </p>
                    </div>

                    {{ $slot }}

                    <p class="mt-5 text-center text-xs text-slate-400">
                        © {{ now()->year }} Gobierno del Estado de Nayarit
                    </p>

                </div>
            </section>

        </div>

    </main>

</body>
</html>