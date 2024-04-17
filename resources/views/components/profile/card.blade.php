@props(['title'])

<div class="bg-card mt-5 p-4 rounded-lg w-full lg:w-1/2">
    <p class="text-main font-bold text-sm">{{ $title }}</p>
    {{ $slot }}
</div>