<div class="py-6">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white shadow-sm rounded-lg">

            <div class="p-6 border-b">
                <h2 class="text-xl font-semibold">
                    Editar Contribuyente
                </h2>
            </div>

            <div class="p-6 space-y-6">


                @if ($errors->any())
                    <div class="mb-4 rounded-md bg-red-50 border border-red-200 p-4 text-sm text-red-700">
                        Revisa los campos marcados. Hay información incompleta o incorrecta.
                    </div>
                @endif

                {{-- Tipo Persona --}}
                <div>
                    <label class="block text-sm font-medium mb-2">
                        Tipo de Persona
                    </label>

                    <select
                        wire:model.live="tipo_persona"
                        class="w-full rounded-md border-gray-300"
                    >
                        <option value="FISICA">PERSONA FÍSICA</option>
                        <option value="MORAL">PERSONA MORAL</option>
                    </select>
                </div>

                {{-- RFC --}}
                <div>
                    <label class="block text-sm font-medium mb-2">
                        RFC
                    </label>

                    <input
                        type="text"
                        wire:model.blur="rfc"
                        class="w-full rounded-md border-gray-300 uppercase"
                    >
                    @error('rfc')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- PERSONA FÍSICA --}}
                @if($tipo_persona === 'FISICA')
                    {{-- CURP, NOMBRE, APELLIDOS --}}
                    <div>
                        <label class="block text-sm font-medium mb-2">
                            CURP
                        </label>

                        <input
                            type="text"
                            wire:model.blur="curp"
                            class="w-full rounded-md border-gray-300 uppercase"
                        >
                        @error('curp')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Nombre
                            </label>

                            <input
                                type="text"
                                wire:model.live.debounce.300ms="nombre"
                                class="w-full rounded-md border-gray-300 uppercase"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Apellido Paterno
                            </label>

                            <input
                                type="text"
                                wire:model.live.debounce.300ms="apellido_paterno"
                                class="w-full rounded-md border-gray-300 uppercase"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Apellido Materno
                            </label>

                            <input
                                type="text"
                                wire:model.live.debounce.300ms="apellido_materno"
                                class="w-full rounded-md border-gray-300 uppercase"
                            >
                        </div>

                    </div>

                @endif

                {{-- Razón Social --}}
                <div>
                    <label class="block text-sm font-medium mb-2">
                        Razón Social
                    </label>

                    @if($tipo_persona === 'FISICA')

                        <input
                            type="text"
                            value="{{ $razon_social }}"
                            disabled
                            class="w-full rounded-md border-gray-300 uppercase bg-gray-100 text-gray-700"
                        >

                    @else

                        <input
                            type="text"
                            wire:model.blur="razon_social"
                            class="w-full rounded-md border-gray-300 uppercase"
                        >

                    @endif
                </div>

                {{-- Representante Legal --}}
                @if($tipo_persona === 'FISICA')

                    <div>
                        <label class="inline-flex items-center gap-2">
                            <input
                                type="checkbox"
                                wire:model.live="requiere_representante_legal"
                            >

                            <span>
                                Requiere Representante Legal
                            </span>
                        </label>
                    </div>

                @endif

                @if($requiere_representante_legal)

                    <div class="border rounded-lg p-4 bg-gray-50">

                        <h3 class="font-semibold mb-4">
                            Datos del Representante Legal
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                            <div>
                                <label class="block text-sm font-medium mb-2">
                                    Nombre
                                </label>

                                <input
                                    type="text"
                                    wire:model.blur="nombre_representante_legal"
                                    class="w-full rounded-md border-gray-300 uppercase"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-2">
                                    CURP
                                </label>

                                <input
                                    type="text"
                                    wire:model.blur="curp_representante_legal"
                                    class="w-full rounded-md border-gray-300 uppercase"
                                >
                                @error('curp_representante_legal')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-2">
                                    Teléfono
                                </label>

                                <input
                                    type="text"
                                    wire:model.blur="telefono_representante_legal"
                                    maxlength="10"
                                    class="w-full rounded-md border-gray-300"
                                >
                                
                                @error('telefono_representante_legal')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                    </div>

                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Correo Electrónico
                        </label>

                        <input
                            type="email"
                            wire:model.blur="correo_electronico"
                            class="w-full rounded-md border-gray-300"
                        >
                        @error('correo_electronico')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Teléfono Móvil
                        </label>
                        @error('telefono_movil')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        <input
                            type="text"
                            wire:model.blur="telefono_movil"
                            maxlength="10"
                            class="w-full rounded-md border-gray-300"
                        >
                    </div>

                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">
                        Cuenta Estatal
                    </label>

                    <input
                        type="text"
                        wire:model.blur="cuenta_estatal"
                        class="w-full rounded-md border-gray-300 uppercase"
                    >
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Tipo de Identificación
                        </label>

                        <select
                            wire:model.blur="tipo_identificacion"
                            class="w-full rounded-md border-gray-300"
                        >
                            <option value="">Seleccione...</option>
                            <option value="INE">INE</option>
                            <option value="PASAPORTE">PASAPORTE</option>
                        </select>
                    </div>
                    @error('tipo_identificacion')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Clave de Identificación
                        </label>

                        <input
                            type="text"
                            wire:model.blur="clave_identificacion"
                            class="w-full rounded-md border-gray-300 uppercase"
                        >
                        @error('clave_identificacion')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>



            </div>

            <div class="p-6 border-t flex justify-end gap-3">
                <a href="{{ route('contribuyentes.index') }}"
                class="px-4 py-2 bg-gray-200 rounded-md text-sm font-semibold">
                    Cancelar
                </a>

                <button
                    type="button"
                    wire:click="actualizar"
                    class="px-4 py-2 bg-gray-800 text-white rounded-md text-sm font-semibold uppercase">
                    Actualizar contribuyente
                </button>
            </div>

    </div>

</div>

</div>