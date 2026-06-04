<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>

                    @role('Orientador Fiscal|Administrador')
                        <x-nav-link :href="route('recepcion.index')" :active="request()->routeIs('recepcion.index')">
                            Recepción
                        </x-nav-link>

                        <x-nav-link :href="route('turnos.index')" :active="request()->routeIs('turnos.index')">
                            Turnos
                        </x-nav-link>
                    @endrole

                    @role('Asesor Fiscal|Administrador')
                        <x-nav-link :href="route('asesoria.index')" :active="request()->routeIs('asesoria.index')">
                            Asesoría
                        </x-nav-link>
                    @endrole

                    @role('Administrador')
                        <x-nav-link :href="route('display.turnos')" :active="request()->routeIs('display.turnos')">
                            Display
                        </x-nav-link>
                    @endrole

                    @role('Administrador')
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none transition duration-150 ease-in-out">
                                    Catálogos

                                    <svg class="ms-1 h-4 w-4 fill-current" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
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
                    @endrole



                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div class="text-left">
                                <div class="font-semibold">
                                    {{ Auth::user()->nombre_completo }}
                                </div>

                                <div class="text-xs text-gray-500">
                                    {{ Auth::user()->roles->first()?->name }}
                                </div>
                            </div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">


        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                Dashboard
            </x-responsive-nav-link>

            @role('Orientador Fiscal|Administrador')
                <x-responsive-nav-link :href="route('recepcion.index')" :active="request()->routeIs('recepcion.index')">
                    Recepción
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('turnos.index')" :active="request()->routeIs('turnos.index')">
                    Turnos
                </x-responsive-nav-link>
            @endrole

            @role('Asesor Fiscal|Administrador')
                <x-responsive-nav-link :href="route('asesoria.index')" :active="request()->routeIs('asesoria.index')">
                    Asesoría
                </x-responsive-nav-link>
            @endrole

            @role('Administrador')
                <x-responsive-nav-link :href="route('catalogos.usuarios.index')" :active="request()->routeIs('catalogos.usuarios.index')">
                    Usuarios
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('catalogos.modulos-asesoria.index')" :active="request()->routeIs('catalogos.modulos-asesoria.index')">
                    Módulos
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('catalogos.tipo-tramites.index')" :active="request()->routeIs('catalogos.tipo-tramites.index')">
                    Tipos
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('catalogos.clasificacion-tramites.index')" :active="request()->routeIs('catalogos.clasificacion-tramites.index')">
                    Clasificaciones
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('catalogos.tramites.index')" :active="request()->routeIs('catalogos.tramites.index')">
                    Trámites
                </x-responsive-nav-link>
            @endrole
        </div>


        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
