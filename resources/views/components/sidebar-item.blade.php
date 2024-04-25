@props(['active', 'href'])

@php
	$baseClass = 'hover:bg-blue-500 w-full cursor-pointer ';
	$classes = ($active ?? false)
		? 'border-l-4 border-blue-700 underline decoration-blue-500 underline-offset-4'
		: 'hover:pl-1 transition-all';
@endphp

<li {{ $attributes->merge([ 'class' => $baseClass.$classes ]) }}>
    <a {{ $attributes->merge([
        'class' => 'relative flex items-center justify-start gap-2 p-2 rounded-md dark:text-gray-300',
        'href' => $href ?? '#'
    ]) }}>
        {{ $slot }}
    </a>
</li>