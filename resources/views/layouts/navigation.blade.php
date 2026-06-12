<nav x-data="{ open: false }" class="!bg-slate-900 border-b border-slate-700 shadow-lg">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- ENCABEZADO ESCRITORIO --}}
        <div class="hidden sm:flex min-h-[125px]">

            {{-- LOGO GRANDE IZQUIERDO --}}
            <div class="flex items-center justify-center pe-6">
                <a href="{{ route('dashboard') }}">
                    <img
                        src="{{ asset('images/institucional/logo-nayarit.png') }}"
                        alt="Gobierno del Estado de Nayarit"
                        class="h-28 w-auto object-contain"
                    >
                </a>
            </div>

            {{-- CONTENIDO DERECHO --}}
            <div class="flex-1">

                {{-- FILA SUPERIOR --}}
                <div class="flex justify-between items-center h-20 border-b border-slate-700">
                    <a href="{{ route('dashboard') }}" class="leading-tight">
                        <div class="text-white font-bold text-base">
                            Gobierno del Estado de Nayarit
                        </div>

                        <div class="text-slate-200 text-xs">
                            Secretaría de Finanzas
                        </div>

                        <div class="text-slate-300 text-xs">
                            Departamento de Asistencia al Contribuyente
                        </div>
                    </a>

                    {{-- MENÚ ADMINISTRADOR --}}
                    <div class="hidden sm:flex sm:items-center">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-4 py-2 bg-white text-slate-700 rounded-md text-sm font-medium hover:bg-slate-100">
                                    {{ Auth::user()->name }}

                                    <svg class="ms-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 20 20" stroke="currentColor">
                                        <path fill-rule="evenodd"
                                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                              clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    Perfil
                                </x-dropdown-link>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                        Cerrar sesión
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>

                {{-- FILA INFERIOR: MENÚ PRINCIPAL --}}
                <div class="flex items-center sm:space-x-2 h-14">

                    <x-nav-link :href="route('recepcion.index')" :active="request()->routeIs('recepcion.*')">
                        🏠 Recepción
                    </x-nav-link>

                    <x-nav-link :href="route('turnos.index')" :active="request()->routeIs('turnos.*')">
                        🎟️ Turnos
                    </x-nav-link>

                    <x-nav-link :href="route('contribuyentes.index')" :active="request()->routeIs('contribuyentes.*')">
                        👥 Contribuyentes
                    </x-nav-link>

                    @role('Asesor Fiscal|Administrador')
                        <x-nav-link :href="route('asesoria.index')" :active="request()->routeIs('asesoria.*')">
                            🧑‍💼 Asesoría
                        </x-nav-link>
                    @endrole

                    @role('Administrador')
                        {{-- CATÁLOGOS --}}
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-4 py-2 border-b-2 border-transparent text-sm font-medium leading-5 text-slate-200 hover:text-white hover:bg-slate-800 hover:border-blue-400 rounded-t-md focus:outline-none transition duration-150 ease-in-out">
                                    ⚙️ Catálogos

                                    <svg class="ms-1 h-4 w-4 fill-current" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                              clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('catalogos.usuarios.index')">
                                    Usuarios
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('catalogos.modulos-asesoria.index')">
                                    Módulos de asesoría
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('catalogos.tipo-tramites.index')">
                                    Tipos de trámite
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('catalogos.clasificacion-tramites.index')">
                                    Clasificaciones
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('catalogos.tramites.index')">
                                    Trámites
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>

                        <x-nav-link :href="route('display.turnos')" :active="request()->routeIs('display.turnos')">
                            📺 Display
                        </x-nav-link>
                    @endrole

                </div>
            </div>
        </div>

        {{-- ENCABEZADO MÓVIL --}}
        <div class="sm:hidden flex justify-between items-center min-h-[80px]">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                <img
                    src="{{ asset('images/institucional/logo-nayarit.png') }}"
                    alt="Gobierno del Estado de Nayarit"
                    class="h-16 w-auto object-contain"
                >

                <div class="leading-tight">
                    <div class="text-white font-bold text-sm">
                        Gobierno del Estado de Nayarit
                    </div>

                    <div class="text-slate-300 text-xs">
                        Secretaría de Finanzas
                    </div>
                </div>
            </a>

            {{-- BOTÓN HAMBURGUESA --}}
            <button @click="open = ! open"
                class="inline-flex items-center justify-center p-2 rounded-md text-slate-300 hover:text-white hover:bg-slate-800 focus:outline-none transition duration-150 ease-in-out">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                          stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16" />

                    <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                          stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    {{-- RESPONSIVE NAVIGATION MENU --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-slate-900 border-t border-slate-700">

        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                🏠 Recepción
            </x-responsive-nav-link>

            @role('Orientador Fiscal|Administrador')
                <x-responsive-nav-link :href="route('turnos.index')" :active="request()->routeIs('turnos.*')">
                    🎟️ Turnos
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('contribuyentes.index')" :active="request()->routeIs('contribuyentes.*')">
                    👥 Contribuyentes
                </x-responsive-nav-link>
            @endrole

            @role('Asesor Fiscal|Administrador')
                <x-responsive-nav-link :href="route('asesoria.index')" :active="request()->routeIs('asesoria.*')">
                    🧑‍💼 Asesoría
                </x-responsive-nav-link>
            @endrole

            @role('Administrador')
                <div class="px-4 py-2 text-xs uppercase tracking-wide text-slate-400">
                    Catálogos
                </div>

                <x-responsive-nav-link :href="route('catalogos.usuarios.index')" :active="request()->routeIs('catalogos.usuarios.*')">
                    Usuarios
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('catalogos.modulos-asesoria.index')" :active="request()->routeIs('catalogos.modulos-asesoria.*')">
                    Módulos de asesoría
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('catalogos.tipo-tramites.index')" :active="request()->routeIs('catalogos.tipo-tramites.*')">
                    Tipos de trámite
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('catalogos.clasificacion-tramites.index')" :active="request()->routeIs('catalogos.clasificacion-tramites.*')">
                    Clasificaciones
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('catalogos.tramites.index')" :active="request()->routeIs('catalogos.tramites.*')">
                    Trámites
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('display.turnos')" :active="request()->routeIs('display.turnos')">
                    📺 Display
                </x-responsive-nav-link>
            @endrole
        </div>

        {{-- RESPONSIVE SETTINGS OPTIONS --}}
        <div class="pt-4 pb-1 border-t border-slate-700">
            <div class="px-4">
                <div class="font-medium text-base text-white">
                    {{ Auth::user()->name }}
                </div>

                <div class="font-medium text-sm text-slate-400">
                    {{ Auth::user()->email }}
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    Perfil
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        Cerrar sesión
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>