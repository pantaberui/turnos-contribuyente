<div class="py-6">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white shadow-sm rounded-lg">

            <div class="p-6 border-b">
                <h2 class="text-xl font-semibold">
                    Nuevo Contribuyente
                </h2>
            </div>

            <div class="p-6 space-y-6">

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
                        wire:model.live="rfc"
                        class="w-full rounded-md border-gray-300 uppercase"
                    >
                </div>

                {{-- PERSONA FÍSICA --}}
                @if($tipo_persona === 'FISICA')

                    <div>
                        <label class="block text-sm font-medium mb-2">
                            CURP
                        </label>

                        <input
                            type="text"
                            wire:model.live="curp"
                            class="w-full rounded-md border-gray-300 uppercase"
                        >
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Nombre
                            </label>

                            <input
                                type="text"
                                wire:model.live="nombre"
                                class="w-full rounded-md border-gray-300 uppercase"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Apellido Paterno
                            </label>

                            <input
                                type="text"
                                wire:model.live="apellido_paterno"
                                class="w-full rounded-md border-gray-300 uppercase"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Apellido Materno
                            </label>

                            <input
                                type="text"
                                wire:model.live="apellido_materno"
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

                    <input
                        type="text"
                        wire:model="razon_social"
                        @if($tipo_persona === 'FISICA') readonly @endif
                        class="w-full rounded-md border-gray-300 uppercase bg-gray-50"
                    >
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
                                    wire:model.live="nombre_representante_legal"
                                    class="w-full rounded-md border-gray-300 uppercase"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-2">
                                    CURP
                                </label>

                                <input
                                    type="text"
                                    wire:model.live="curp_representante_legal"
                                    class="w-full rounded-md border-gray-300 uppercase"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-2">
                                    Teléfono
                                </label>

                                <input
                                    type="text"
                                    wire:model.live="telefono_representante_legal"
                                    class="w-full rounded-md border-gray-300"
                                >
                            </div>

                        </div>

                    </div>

                @endif


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