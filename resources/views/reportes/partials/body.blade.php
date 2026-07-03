{{-- @include('reportes.partials.informacion-consulta') --}}

@include('reportes.partials.totales')


@foreach($reporte->secciones as $seccion)
    @include('reportes.partials.seccion-tramites', [
        'titulo' => $seccion['titulo'],
        'seccion' => $seccion['contenido'],
    ])
@endforeach

@include('reportes.partials.pie')