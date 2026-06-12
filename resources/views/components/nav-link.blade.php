@props(['active'])

@php
$classes = ($active ?? false)
    ? 'inline-flex items-center px-4 py-2 border-b-2 border-amber-400 text-sm font-semibold leading-5 text-white bg-blue-600 rounded-t-md focus:outline-none transition duration-150 ease-in-out'
    : 'inline-flex items-center px-4 py-2 border-b-2 border-transparent text-sm font-medium leading-5 text-slate-200 hover:text-white hover:bg-slate-800 hover:border-blue-400 rounded-t-md focus:outline-none transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
