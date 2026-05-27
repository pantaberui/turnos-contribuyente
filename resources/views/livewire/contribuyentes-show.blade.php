<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white shadow-sm rounded-lg">

            <div class="p-6 border-b flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">
                        {{ $contribuyente->razon_social }}
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        RFC: {{ $contribuyente->rfc }}
                    </p>
                </div>

                <div>
                    @if($contribuyente->activo)
                        <span class="px-3 py-1 text-sm rounded-full bg-green-100 text-green-700 font-semibold">
                            ACTIVO
                        </span>
                    @else
                        <span class="px-3 py-1 text-sm rounded-full bg-red-100 text-red-700 font-semibold">
                            INACTIVO
                        </span>
                    @endif
                </div>
            </div>

            <div class="p-6 space-y-8">

                {{-- Datos generales --}}
                <section class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">
                        Datos generales
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                        <div>
                            <p class="text-sm text-gray-500">
                                Tipo de Persona
                            </p>

                            <p class="font-semibold text-gray-800">
                                {{ $contribuyente->tipo_persona }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">
                                RFC
                            </p>

                            <p class="font-semibold text-gray-800">
                                {{ $contribuyente->rfc }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">
                                CURP
                            </p>

                            <p class="font-semibold text-gray-800">
                                {{ $contribuyente->curp ?? '—' }}
                            </p>
                        </div>

                    </div>

                    <div>
                        <p class="text-sm text-gray-500">
                            Razón Social
                        </p>

                        <p class="font-semibold text-gray-800">
                            {{ $contribuyente->razon_social }}
                        </p>
                    </div>
                </section>

                {{-- Contacto --}}
                <section class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">
                        Contacto
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <p class="text-sm text-gray-500">
                                Correo Electrónico
                            </p>

                            <p class="font-semibold text-gray-800">
                                {{ $contribuyente->correo_electronico ?? '—' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">
                                Teléfono Móvil
                            </p>

                            <p class="font-semibold text-gray-800">
                                {{ $contribuyente->telefono_movil ?? '—' }}
                            </p>
                        </div>

                    </div>
                </section>

                {{-- Identificación --}}
                <section class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">
                        Identificación
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <p class="text-sm text-gray-500">
                                Tipo de Identificación
                            </p>

                            <p class="font-semibold text-gray-800">
                                {{ $contribuyente->tipo_identificacion ?? '—' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">
                                Clave de Identificación
                            </p>

                            <p class="font-semibold text-gray-800">
                                {{ $contribuyente->clave_identificacion ?? '—' }}
                            </p>
                        </div>

                    </div>
                </section>

                {{-- Datos estatales --}}
                <section class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">
                        Datos estatales
                    </h3>

                    <div>
                        <p class="text-sm text-gray-500">
                            Cuenta Estatal
                        </p>

                        <p class="font-semibold text-gray-800">
                            {{ $contribuyente->cuenta_estatal ?? '—' }}
                        </p>
                    </div>
                </section>

                {{-- Representante legal --}}
                @if($contribuyente->requiere_representante_legal)
                    <section class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">
                            Representante legal
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                            <div>
                                <p class="text-sm text-gray-500">
                                    Nombre
                                </p>

                                <p class="font-semibold text-gray-800">
                                    {{ $contribuyente->nombre_representante_legal ?? '—' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500">
                                    CURP
                                </p>

                                <p class="font-semibold text-gray-800">
                                    {{ $contribuyente->curp_representante_legal ?? '—' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500">
                                    Teléfono
                                </p>

                                <p class="font-semibold text-gray-800">
                                    {{ $contribuyente->telefono_representante_legal ?? '—' }}
                                </p>
                            </div>

                        </div>
                    </section>
                @endif

            </div>

            <div class="p-6 border-t flex justify-end gap-3">

                <a href="{{ route('contribuyentes.index') }}"
                   class="px-4 py-2 bg-gray-200 rounded-md text-sm font-semibold">
                    Volver
                </a>

                <a href="{{ route('contribuyentes.edit', $contribuyente) }}"
                   class="px-4 py-2 bg-gray-800 text-white rounded-md text-sm font-semibold">
                    Editar
                </a>

            </div>

        </div>

    </div>
</div>