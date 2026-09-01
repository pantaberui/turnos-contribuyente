<x-app-layout>
    <x-slot name="header">
        <div class="no-print">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Documento Reporte Asesor Fiscal
            </h2>
        </div>
    </x-slot>

    <div class="reportes-fondo space-y-8">

        {{-- Herramientas de consulta --}}
        <div class="bg-white border rounded-lg shadow-sm p-4 no-print">
            <h3 class="font-bold space-y-8">
                Parámetros de consulta
            </h3>

            @include('reportes.partials.filtros')


        </div>

        {{-- Documento --}}
        <div class="flex justify-center">
            <div class="documento-hoja space-y-5">
                @include('reportes.partials.encabezado')
                @include('reportes.partials.body')
            </div>
        </div>

    </div>


    {{-- ============================================================
         MODAL DATOS COMPLEMENTARIOS
         ============================================================ --}}

    @if($asesorId && ($complementario['aplica'] ?? false))

        <div
            id="modal-complementario"
            class="hidden fixed inset-0 z-50 overflow-y-auto"
            style="background:rgba(0,0,0,.55);">

            <div class="min-h-screen flex items-center justify-center p-4">

                <div
                    class="bg-white rounded-xl shadow-2xl w-full max-w-xl"
                    onclick="event.stopPropagation()">

                    {{-- Encabezado --}}
                    <div
                        style="
                            background:#0f172a;
                            color:white;
                            padding:16px 20px;
                            border-radius:12px 12px 0 0;
                        ">

                        <div class="flex items-center justify-between">

                            <div>
                                <h3 class="text-lg font-bold">
                                    Información complementaria
                                </h3>

                                <p class="text-sm text-slate-300 mt-1">
                                    Reporte del
                                    {{ \Carbon\Carbon::parse($fechaInicio)->format('d/m/Y') }}
                                    al
                                    {{ \Carbon\Carbon::parse($fechaFin)->format('d/m/Y') }}
                                </p>
                            </div>

                            <button
                                type="button"
                                onclick="cerrarModalComplementario()"
                                style="
                                    color:white;
                                    background:transparent;
                                    border:none;
                                    font-size:24px;
                                    cursor:pointer;
                                ">
                                ×
                            </button>

                        </div>

                    </div>


                    {{-- Formulario --}}
                    <form
                        method="POST"
                        action="{{ route('reportes.complementario.guardar') }}">

                        @csrf

                        <input
                            type="hidden"
                            name="asesor_id"
                            value="{{ $asesorId }}">

                        <input
                            type="hidden"
                            name="fecha_inicio"
                            value="{{ $fechaInicio }}">

                        <input
                            type="hidden"
                            name="fecha_fin"
                            value="{{ $fechaFin }}">

                        <input
                            type="hidden"
                            name="tipo_periodo"
                            value="{{ $tipoPeriodo }}">


                        <div class="p-6 space-y-5">

                            {{-- Talleres RIF --}}
                            <div>
                                <label
                                    for="talleres_rif"
                                    class="block text-sm font-semibold text-gray-700 mb-1">
                                    Talleres fiscales RIF
                                </label>

                                <input
                                    id="talleres_rif"
                                    type="number"
                                    name="talleres_rif"
                                    min="0"
                                    value="{{ old('talleres_rif', $complementario['talleres_rif'] ?? 0) }}"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500">
                            </div>


                            {{-- Talleres Estatales --}}
                            <div>
                                <label
                                    for="talleres_estatales"
                                    class="block text-sm font-semibold text-gray-700 mb-1">
                                    Talleres fiscales estatales
                                </label>

                                <input
                                    id="talleres_estatales"
                                    type="number"
                                    name="talleres_estatales"
                                    min="0"
                                    value="{{ old('talleres_estatales', $complementario['talleres_estatales'] ?? 0) }}"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500">
                            </div>


                            {{-- Proyectos --}}
                            <div>
                                <label
                                    for="proyectos_realizados"
                                    class="block text-sm font-semibold text-gray-700 mb-1">
                                    Proyectos realizados
                                </label>

                                <input
                                    id="proyectos_realizados"
                                    type="number"
                                    name="proyectos_realizados"
                                    min="0"
                                    value="{{ old('proyectos_realizados', $complementario['proyectos_realizados'] ?? 0) }}"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500">
                            </div>


                            {{-- Actividades adicionales --}}
                            <div>
                                <label
                                    for="actividades_adicionales"
                                    class="block text-sm font-semibold text-gray-700 mb-1">
                                    Actividades realizadas en el mes
                                    <span class="font-normal text-gray-500">
                                        (funciones adicionales)
                                    </span>
                                </label>

                                <textarea
                                    id="actividades_adicionales"
                                    name="actividades_adicionales"
                                    rows="5"
                                    maxlength="3000"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500"
                                    placeholder="Describa las actividades adicionales realizadas durante el periodo...">{{ old('actividades_adicionales', $complementario['actividades_adicionales'] ?? '') }}</textarea>
                            </div>

                        </div>


                        {{-- Botones --}}
                        <div
                            class="flex justify-end gap-3 px-6 py-4 border-t border-gray-200 bg-gray-50 rounded-b-xl">

                            <button
                                type="button"
                                onclick="cerrarModalComplementario()"
                                style="
                                    background:#e5e7eb;
                                    color:#374151;
                                    padding:9px 18px;
                                    border-radius:6px;
                                    font-weight:600;
                                    cursor:pointer;
                                ">
                                Cancelar
                            </button>

                            <button
                                type="submit"
                                style="
                                    background:#0369a1;
                                    color:white;
                                    padding:9px 18px;
                                    border-radius:6px;
                                    font-weight:700;
                                    cursor:pointer;
                                ">
                                Guardar información
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    @endif


    {{-- JavaScript del modal --}}
    <script>
        function cerrarModalComplementario() {
            const modal = document.getElementById('modal-complementario');

            if (modal) {
                modal.classList.add('hidden');
            }
        }

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                cerrarModalComplementario();
            }
        });

        document.addEventListener('click', function (event) {
            const modal = document.getElementById('modal-complementario');

            if (modal && event.target === modal) {
                cerrarModalComplementario();
            }
        });
    </script>

</x-app-layout>