@props(['title', 'text', 'link' => false])

@php
    if(strlen($text) == 0) {
        $text = '-';
    }
@endphp

<div {{ $attributes }}>
    <p class="text-muted text-sm font-semibold">{{ $title }}</p>
    @if($link)
        <a class="text-main py-1 rounded-lg text-sm hover:bg-card hover:underline" href="{{ $text }}">{{ $text }}</a>
    @else
        <p class="text-main">{{ $text }}</p>
    @endif
</div>