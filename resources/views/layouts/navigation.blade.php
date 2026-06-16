<nav x-data="{ open: false }" style="background:#0f172a; border-bottom:1px solid #334155; box-shadow:0 4px 10px rgba(0,0,0,.25);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- ESCRITORIO --}}
        
        <div class="hidden sm:flex items-center" style="min-height:112px;">

            {{-- IZQUIERDA: LOGO + TEXTOS --}}
            <div class="flex items-center gap-5">
                {{-- LOGO --}}
                <div class="flex items-center justify-start">
                    <a href="{{ route('dashboard') }}">
                        <img
                            src="{{ asset('images/institucional/logo-nayarit.png') }}"
                            alt="Gobierno del Estado de Nayarit"
                            style="height:90px; width:auto; object-fit:contain;"
                        >
                    </a>
                </div>

                <div class="text-center">
                    <a href="{{ route('dashboard') }}" class="block leading-tight">
                        <div style="color:#ffffff; font-weight:800; font-size:18px;">
                            Gobierno del Estado de Nayarit
                        </div>

                        <div style="color:#f1f5f9; font-size:14px; font-weight:600; margin-top:4px;">
                            Secretaría de Finanzas
                        </div>

                        <div style="color:#e2e8f0; font-size:13px; margin-top:2px;">
                            Departamento de Asistencia al Contribuyente
                        </div>
                    </a>

                    {{-- MENÚ PRINCIPAL --}}
                    <div class="flex items-center justify-center gap-4 mt-4">
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
                            <x-dropdown align="left" width="48">
                                <x-slot name="trigger">
                                    <button
                                        type="button"
                                        style="color:#e2e8f0; padding:8px 14px; border-bottom:2px solid transparent; font-size:14px; font-weight:600; border-radius:6px;">
                                        ⚙️ Catálogos
                                        <span style="margin-left:4px;">⌄</span>
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

            {{-- DERECHA: USUARIO --}}
            <div class="flex items-start ml-auto self-start pt-5">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            type="button"
                            style="background:#ffffff; color:#0f172a; padding:10px 16px; border-radius:8px; font-size:14px; font-weight:600;">
                            {{ mb_strtoupper(Auth::user()->nombre_completo, 'UTF-8') }}
                            <span style="margin-left:6px;">⌄</span>
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

        {{-- MÓVIL --}}
        <div class="sm:hidden flex justify-between items-center min-h-[80px]">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                <img
                    src="{{ asset('images/institucional/logo-nayarit.png') }}"
                    alt="Gobierno del Estado de Nayarit"
                    style="height:58px; width:auto; object-fit:contain;"
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

            <button @click="open = ! open"
                class="inline-flex items-center justify-center p-2 rounded-md text-slate-300 hover:text-white hover:bg-slate-800 focus:outline-none transition duration-150 ease-in-out">
                ☰
            </button>
        </div>
    </div>

    {{-- RESPONSIVE NAVIGATION MENU --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-slate-900 border-t border-slate-700">

        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('recepcion.index')" :active="request()->routeIs('recepcion.*')">
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