@props(['field', 'class'])

<div id="editor" {{ $attributes->merge([
    'class' => "text-main h-auto bg-main border-0"
])}}></div>

<textarea id="output-html" class="hidden" {{ $attributes->merge(['name' => $field, 'id' => $field])}}></textarea>
