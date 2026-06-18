<nav x-data="{ open: false }" style="background:#0f172a; border-bottom:1px solid #334155; box-shadow:0 4px 10px rgba(0,0,0,.25);">

    {{-- ESCRITORIO --}}
    <div style="position:relative; min-height:112px; padding:10px 24px;">

        {{-- LOGO IZQUIERDA --}}
        <div style="position:absolute; left:24px; top:10px;">
            <a href="{{ route('dashboard') }}">
                <img
                    src="{{ asset('images/institucional/logo-nayarit.png') }}"
                    alt="Gobierno del Estado de Nayarit"
                    style="height:92px; width:auto; object-fit:contain;">
            </a>
        </div>

        {{-- USUARIO DERECHA --}}
        <div style="position:absolute; right:24px; top:24px;">
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button
                        type="button"
                        style="background:#ffffff; color:#0f172a; padding:10px 16px; border-radius:8px; font-size:14px; font-weight:700;">
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

        {{-- CENTRO: TÍTULOS + MENÚ --}}
        <div style="text-align:center; max-width:900px; margin:0 auto;">

            <a href="{{ route('dashboard') }}" style="text-decoration:none; display:inline-block;">
                <div style="color:#ffffff; font-weight:800; font-size:18px; line-height:1.2;">
                    Gobierno del Estado de Nayarit
                </div>

                <div style="color:#f1f5f9; font-size:14px; font-weight:600; margin-top:4px;">
                    Secretaría de Finanzas
                </div>

                <div style="color:#e2e8f0; font-size:13px; margin-top:2px;">
                    Departamento de Asistencia al Contribuyente
                </div>
            </a>

            {{-- MENÚ --}}
            <div style="display:flex; justify-content:center; align-items:center; gap:20px; margin-top:18px; flex-wrap:wrap;">

                <a href="{{ route('recepcion.index') }}"
                   style="color:#e2e8f0; font-size:14px; font-weight:700; text-decoration:none;">
                    🏠 Recepción
                </a>

                <a href="{{ route('turnos.index') }}"
                   style="color:#e2e8f0; font-size:14px; font-weight:700; text-decoration:none;">
                    🎟️ Turnos
                </a>

                <a href="{{ route('contribuyentes.index') }}"
                   style="color:#e2e8f0; font-size:14px; font-weight:700; text-decoration:none;">
                    👥 Contribuyentes
                </a>

                @role('Asesor Fiscal|Administrador')
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button
                                type="button"
                                style="color:#e2e8f0; background:transparent; border:none; font-size:14px; font-weight:700; cursor:pointer;">
                                🧑‍💼 Asesoría ⌄
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('asesoria.index')">
                                Atención de turnos
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('asesorias.consulta')">
                                Consulta / Edición
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                @endrole

                @role('Administrador')
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button
                                type="button"
                                style="color:#e2e8f0; background:transparent; border:none; font-size:14px; font-weight:700; cursor:pointer;">
                                ⚙️ Catálogos ⌄
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

                    <a href="{{ route('display.turnos') }}"
                       style="color:#e2e8f0; font-size:14px; font-weight:700; text-decoration:none;">
                        📺 Display
                    </a>
                @endrole

            </div>
        </div>
    </div>

    {{-- MÓVIL --}}
    <div style="display:none;">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
            <img
                src="{{ asset('images/institucional/logo-nayarit.png') }}"
                alt="Gobierno del Estado de Nayarit"
                style="height:58px; width:auto; object-fit:contain;">

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
            class="inline-flex items-center justify-center p-2 rounded-md text-slate-300 hover:text-white hover:bg-slate-800 focus:outline-none">
            ☰
        </button>
    </div>

    {{-- MENÚ MÓVIL --}}
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
                    🧑‍💼 Atención de turnos
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('asesorias.consulta')" :active="request()->routeIs('asesorias.consulta')">
                    Consulta / Edición
                </x-responsive-nav-link>
            @endrole

            @role('Administrador')
                <div class="px-4 py-2 text-xs uppercase tracking-wide text-slate-400">
                    Catálogos
                </div>

                <x-responsive-nav-link :href="route('catalogos.usuarios.index')">
                    Usuarios
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('catalogos.modulos-asesoria.index')">
                    Módulos de asesoría
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('catalogos.tipo-tramites.index')">
                    Tipos de trámite
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('catalogos.clasificacion-tramites.index')">
                    Clasificaciones
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('catalogos.tramites.index')">
                    Trámites
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('display.turnos')">
                    📺 Display
                </x-responsive-nav-link>
            @endrole
        </div>

        <div class="pt-4 pb-1 border-t border-slate-700">
            <div class="px-4">
                <div class="font-medium text-base text-white">
                    {{ Auth::user()->nombre_completo ?? Auth::user()->name }}
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