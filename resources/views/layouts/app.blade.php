<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        @livewireScripts

        <script>
        (function () {
            const originalFetch = window.fetch;

            window.fetch = async (...args) => {
                const response = await originalFetch(...args);

                const url = typeof args[0] === 'string'
                    ? args[0]
                    : args[0]?.url;

                if (
                    url &&
                    url.includes('/livewire') &&
                    [404, 419].includes(response.status)
                ) {
                    console.warn('Error Livewire detectado:', response.status);

                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                }

                return response;
            };
        })();
        </script>        
    </body>
</html>
