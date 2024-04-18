@props(['title', 'data'])

<div class="col-span-1 flex flex-col rounded-lg p-2 bg-card text-main">
    <span {{ $attributes->merge(['class' => isset($title) ? "p-1 text-muted uppercase text-xs" : '']) }}>{{ $title ?? '' }}</span>
    <span {{ $attributes->merge(['class' => isset($data) ? "py-5 text-center text-xl" : '']) }}>{{ $data ?? '' }}</span>
    {{ $slot }}
</div>