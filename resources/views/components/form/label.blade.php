{{-- If there is no text, provide $slot instead for customization --}}
@props(['text'])

<label {{ $attributes->merge(['class' => 'block text-sm text-label font-bold'])}}>
    {{ $text ?? $slot }}
</label>