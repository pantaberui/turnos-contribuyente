<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg">

            <div class="p-6 border-b">
                <h2 class="text-xl font-semibold">
                    Nuevo Contribuyente
                </h2>
            </div>

            <div class="p-6 space-y-8">

                @if ($errors->any())
                    <div class="rounded-md bg-red-50 border border-red-200 p-4 text-sm text-red-700">
                        Revisa los campos marcados. Hay información incompleta o incorrecta.
                    </div>
                @endif

                {{-- Datos generales --}}
                <section class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">
                        Datos generales
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Tipo de Persona
                            </label>
                            <select wire:model.live="tipo_persona" class="w-full rounded-md border-gray-300">
                                <option value="FISICA">PERSONA FÍSICA</option>
                                <option value="MORAL">PERSONA MORAL</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">
                                RFC <span class="text-red-600">*</span>
                            </label>
                            <input type="text" wire:model.blur="rfc" class="w-full rounded-md border-gray-300 uppercase">
                            @error('rfc')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        @if($tipo_persona === 'FISICA')
                            <div>
                                <label class="block text-sm font-medium mb-2">
                                    CURP <span class="text-red-600">*</span>
                                </label>
                                <input type="text" wire:model.blur="curp" class="w-full rounded-md border-gray-300 uppercase">
                                @error('curp')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Razón Social <span class="text-red-600">*</span>
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

                        @error('razon_social')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </section>

                {{-- Datos persona física --}}
                @if($tipo_persona === 'FISICA')
                    <section class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">
                            Datos de persona física
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-2">
                                    Nombre <span class="text-red-600">*</span>
                                </label>
                                <input type="text" wire:model.live.debounce.300ms="nombre" class="w-full rounded-md border-gray-300 uppercase">
                                @error('nombre')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-2">
                                    Apellido Paterno <span class="text-red-600">*</span>
                                </label>
                                <input type="text" wire:model.live.debounce.300ms="apellido_paterno" class="w-full rounded-md border-gray-300 uppercase">
                                @error('apellido_paterno')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-2">
                                    Apellido Materno
                                </label>
                                <input type="text" wire:model.live.debounce.300ms="apellido_materno" class="w-full rounded-md border-gray-300 uppercase">
                                @error('apellido_materno')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </section>
                @endif

                {{-- Contacto --}}
                <section class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">
                        Contacto
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Correo Electrónico
                            </label>
                            <input type="email" wire:model.blur="correo_electronico" class="w-full rounded-md border-gray-300">
                            @error('correo_electronico')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Teléfono Móvil
                            </label>
                            <input type="text" wire:model.blur="telefono_movil" maxlength="10" class="w-full rounded-md border-gray-300">
                            @error('telefono_movil')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </section>

                {{-- Identificación --}}
                <section class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">
                        Identificación
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Tipo de Identificación
                                @if($tipo_persona === 'FISICA')
                                    <span class="text-red-600">*</span>
                                @endif
                            </label>
                            <select wire:model.blur="tipo_identificacion" class="w-full rounded-md border-gray-300">
                                <option value="">Seleccione...</option>
                                <option value="INE">INE</option>
                                <option value="PASAPORTE">PASAPORTE</option>
                            </select>
                            @error('tipo_identificacion')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Clave de Identificación
                                @if($tipo_persona === 'FISICA')
                                    <span class="text-red-600">*</span>
                                @endif
                            </label>
                            <input type="text" wire:model.blur="clave_identificacion" class="w-full rounded-md border-gray-300 uppercase">
                            @error('clave_identificacion')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </section>

                {{-- Datos estatales --}}
                <section class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">
                        Datos estatales
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Cuenta Estatal
                            </label>
                            <input type="text" wire:model.blur="cuenta_estatal" class="w-full rounded-md border-gray-300 uppercase">
                            @error('cuenta_estatal')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </section>

                {{-- Representante legal --}}
                <section class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">
                        Representante legal
                    </h3>

                    @if($tipo_persona === 'FISICA')
                        <div>
                            <label class="inline-flex items-center gap-2">
                                <input type="checkbox" wire:model.live="requiere_representante_legal">
                                <span>Requiere Representante Legal</span>
                            </label>
                        </div>
                    @else
                        <div class="rounded-md bg-blue-50 border border-blue-200 p-3 text-sm text-blue-700">
                            La persona moral requiere representante legal obligatoriamente.
                        </div>
                    @endif

                    @if($requiere_representante_legal)
                        <div class="border rounded-lg p-4 bg-gray-50">
                            <h4 class="font-semibold mb-4">
                                Datos del Representante Legal
                            </h4>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium mb-2">
                                        Nombre <span class="text-red-600">*</span>
                                    </label>
                                    <input type="text" wire:model.blur="nombre_representante_legal" class="w-full rounded-md border-gray-300 uppercase">
                                    @error('nombre_representante_legal')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium mb-2">
                                        CURP <span class="text-red-600">*</span>
                                    </label>
                                    <input type="text" wire:model.blur="curp_representante_legal" class="w-full rounded-md border-gray-300 uppercase">
                                    @error('curp_representante_legal')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium mb-2">
                                        Teléfono <span class="text-red-600">*</span>
                                    </label>
                                    <input type="text" wire:model.blur="telefono_representante_legal" maxlength="10" class="w-full rounded-md border-gray-300">
                                    @error('telefono_representante_legal')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endif
                </section>
            </div>

            <div class="p-6 border-t flex justify-end gap-3">
                <a href="{{ route('contribuyentes.index') }}"
                   class="px-4 py-2 bg-gray-200 rounded-md text-sm font-semibold">
                    Cancelar
                </a>

                <button
                    type="button"
                    wire:click="guardar"
                    class="px-4 py-2 bg-gray-800 text-white rounded-md text-sm font-semibold uppercase">
                    Guardar contribuyente
                </button>
            </div>
        </div>
    </div>
</div>