<x-guest-layout>

    <div
        class="rounded-3xl border border-white/70 bg-white/95 p-6 shadow-2xl shadow-slate-950/25 backdrop-blur-sm sm:p-8"
    >
        {{-- Encabezado del formulario --}}
        <div class="mb-7 text-center">

            <div
                class="mx-auto flex h-16 w-16 items-center justify-center rounded-full border-2 border-[#0b3767] bg-blue-50 text-[#0b3767]"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-8 w-8"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    aria-hidden="true"
                >
                    <path d="M20 21a8 8 0 0 0-16 0" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
            </div>

            <h2 class="mt-4 text-2xl font-extrabold tracking-tight text-[#082b56]">
                Sistema de Turnos
            </h2>

            <p class="mt-1 text-sm font-medium text-slate-600">
                para Asistencia al Contribuyente
            </p>

            <div class="mx-auto mt-5 flex max-w-xs items-center gap-3">
                <span class="h-px flex-1 bg-amber-400/80"></span>
                <span class="h-2.5 w-2.5 rounded-full bg-[#c8a15a]"></span>
                <span class="h-px flex-1 bg-amber-400/80"></span>
            </div>
        </div>

        {{-- Estado de sesión --}}
        <x-auth-session-status
            class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700"
            :status="session('status')"
        />

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            {{-- Correo electrónico --}}
            <div>
                <label
                    for="email"
                    class="mb-2 block text-sm font-semibold text-slate-700"
                >
                    Correo electrónico
                </label>

                <div class="relative">
                    <div
                        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            aria-hidden="true"
                        >
                            <path d="M4 4h16v16H4z" />
                            <path d="m22 6-10 7L2 6" />
                        </svg>
                    </div>

                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="Ingrese su correo electrónico"
                        class="block w-full rounded-xl border-slate-300 bg-white py-3 pl-12 pr-4 text-sm text-slate-800 shadow-sm transition placeholder:text-slate-400 focus:border-[#0f4f89] focus:ring-[#0f4f89]"
                    >
                </div>

                @error('email')
                    <p class="mt-2 flex items-start gap-2 text-sm font-medium text-red-600">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="mt-0.5 h-4 w-4 shrink-0"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            aria-hidden="true"
                        >
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 8v4" />
                            <path d="M12 16h.01" />
                        </svg>

                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            {{-- Contraseña --}}
            <div x-data="{ mostrarPassword: false }">
                <label
                    for="password"
                    class="mb-2 block text-sm font-semibold text-slate-700"
                >
                    Contraseña
                </label>

                <div class="relative">
                    <div
                        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            aria-hidden="true"
                        >
                            <rect width="18" height="11" x="3" y="11" rx="2" />
                            <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                        </svg>
                    </div>

                    <input
                        id="password"
                        :type="mostrarPassword ? 'text' : 'password'"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="Ingrese su contraseña"
                        class="block w-full rounded-xl border-slate-300 bg-white py-3 pl-12 pr-12 text-sm text-slate-800 shadow-sm transition placeholder:text-slate-400 focus:border-[#0f4f89] focus:ring-[#0f4f89]"
                    >

                    <button
                        type="button"
                        @click="mostrarPassword = ! mostrarPassword"
                        class="absolute inset-y-0 right-0 flex items-center rounded-r-xl px-4 text-slate-400 transition hover:text-[#0b3767] focus:outline-none focus:ring-2 focus:ring-inset focus:ring-[#0f4f89]"
                        :aria-label="mostrarPassword ? 'Ocultar contraseña' : 'Mostrar contraseña'"
                    >
                        <svg
                            x-show="! mostrarPassword"
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            aria-hidden="true"
                        >
                            <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>

                        <svg
                            x-show="mostrarPassword"
                            x-cloak
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            aria-hidden="true"
                        >
                            <path d="m15 18-.722-3.25" />
                            <path d="M2 8a10.645 10.645 0 0 0 20 0" />
                            <path d="m20 15-1.726-2.05" />
                            <path d="m4 15 1.726-2.05" />
                            <path d="m9 18 .722-3.25" />
                        </svg>
                    </button>
                </div>

                @error('password')
                    <p class="mt-2 flex items-start gap-2 text-sm font-medium text-red-600">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="mt-0.5 h-4 w-4 shrink-0"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            aria-hidden="true"
                        >
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 8v4" />
                            <path d="M12 16h.01" />
                        </svg>

                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            {{-- Recordarme y recuperar contraseña --}}
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <label
                    for="remember_me"
                    class="inline-flex cursor-pointer items-center"
                >
                    <input
                        id="remember_me"
                        type="checkbox"
                        name="remember"
                        class="rounded border-slate-300 text-[#0b3767] shadow-sm focus:ring-[#0f4f89]"
                    >

                    <span class="ms-2 text-sm text-slate-600">
                        Recordarme
                    </span>
                </label>

                @if (Route::has('password.request'))
                    <a
                        href="{{ route('password.request') }}"
                        class="text-sm font-semibold text-[#0b5796] transition hover:text-[#082b56] hover:underline focus:outline-none focus:ring-2 focus:ring-[#0f4f89] focus:ring-offset-2"
                    >
                        ¿Olvidó su contraseña?
                    </a>
                @endif
            </div>

            {{-- Botón --}}
            <button
                type="submit"
                class="group flex w-full items-center justify-center gap-3 rounded-xl bg-gradient-to-r from-[#0b3767] to-[#082b56] px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-blue-950/20 transition duration-200 hover:-translate-y-0.5 hover:from-[#0d477f] hover:to-[#0b3767] hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-[#0f4f89] focus:ring-offset-2 active:translate-y-0"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 transition-transform group-hover:translate-x-0.5"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    aria-hidden="true"
                >
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                    <polyline points="10 17 15 12 10 7" />
                    <line x1="15" x2="3" y1="12" y2="12" />
                </svg>

                <span>Iniciar sesión</span>
            </button>
        </form>

        <div class="mt-7 border-t border-slate-200 pt-5 text-center">
            <p class="text-xs font-medium text-slate-500">
                Acceso exclusivo para personal autorizado
            </p>
        </div>
    </div>

</x-guest-layout>
