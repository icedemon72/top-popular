@props(['title', 'required' => true, 'field', 'disabled' => false, 'error' => false])

@php
    $baseClass = 'block w-full my-auto ps-10 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm p-2';

    $baseClass .=  $error ? ' border-red-300 dark:border-red-700 border-2' : ' border-gray-300 dark:border-gray-700';
@endphp


<div class="relative">
    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
        <x-lucide-search class="w-4 h-4 text-gray-500 dark:text-gray-400" title="Search" alt="Search icon" />
    </div>
    <input type="submit" hidden />
    <input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
        'class' => $baseClass,
        'name' => $field,
        'id' => $field
    ]) !!} />
</div>