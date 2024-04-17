@props(['field', 'disabled' => false, 'field', 'error' => false])
@php
    $baseClass = 'dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm p-2';

    $baseClass .=  $error ? ' border-red-300 dark:border-red-700 border-2' : ' border-gray-300 dark:border-gray-700';
@endphp

<textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'name' => $field, 
    'id' => $field,
    'class' => $baseClass,
    ]) 
!!}>{{ $slot }}</textarea>