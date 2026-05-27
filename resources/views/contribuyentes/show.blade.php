<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalle del contribuyente
        </h2>
    </x-slot>

    <livewire:contribuyentes-show :contribuyente="$contribuyente" />
</x-app-layout>