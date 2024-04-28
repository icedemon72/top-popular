@props(['open' => ''])

<div x-cloak  {{ $attributes->merge(['x-show' => $open]) }}
x-transition:enter="transition ease-out duration-200"
x-transition:enter-start="opacity-0 scale-95"
x-transition:enter-end="opacity-100 scale-100"
x-transition:leave="transition ease-in duration-75"
x-transition:leave-start="opacity-100 scale-100"
x-transition:leave-end="opacity-0 scale-95">
    {{ $slot }}
</div>