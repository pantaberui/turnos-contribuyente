{{-- @include('reportes.partials.informacion-consulta') --}}

@include('reportes.partials.totales')

@include('reportes.partials.contribuyentes')

@foreach($reporte->secciones as $seccion)
    @include('reportes.partials.seccion-tramites', [
        'titulo' => $seccion['titulo'],
        'seccion' => $seccion['contenido'],
    ])
@endforeach

@include('reportes.partials.solventaciones')

@include('reportes.partials.complementarios')

@include('reportes.partials.pie')