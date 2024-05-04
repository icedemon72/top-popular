@props([
    'disabled' => false, 
    'field', 
    'error' => false, 
    'text' => '',
    'type' => 'checkbox',
    'value' => true,
    'selected' => false
])

@php
    $baseClass = 'accent-gray-200 dark:accent-gray-800 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm p-2';
    $baseClass .=  $error ? ' border-red-300 dark:border-red-700 border-2' : ' border-gray-300 dark:border-gray-700';
@endphp

<div class="flex items-center gap-2">
    <input {{ $selected ? 'checked' : '' }} type="{{ $type }}" {{ $disabled ? 'disabled' : '' }} class="{!! $baseClass !!}" name="{{ $field }}" id="{{ $field }}" value="{{ $value }}" />
    @if($text)
        <label class="text-sm text-muted" for="{{ $field }}">{{ $text }}</label>
    @endif
</div>