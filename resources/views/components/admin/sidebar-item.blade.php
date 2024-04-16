@props(['active'])

@php
	$baseClass = 'hover:bg-blue-500 w-full cursor-pointer ';
	$classes = ($active ?? false)
		? 'border-l-4 border-blue-700 underline decoration-blue-500 underline-offset-4'
		: '';
@endphp

<a {{ $attributes->merge([ 'class' => $baseClass.$classes ]) }}>
	<div class="relative flex justify-between p-2 rounded-md dark:text-gray-300">
		{{ $slot }}
	</div>
</a>