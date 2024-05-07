@props(['disabled' => false, 'field', 'error' => false, 'text', 'preview' =>  __('Icon preview'), 'icon' ])

@php
    $baseClass = 'dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm';

    $baseClass .=  $error ? ' border-red-300 dark:border-red-700 border-2' : ' border-gray-300 dark:border-gray-700';
@endphp

<div class="{{ $baseClass }}">
    <label :for="$field" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
        <div class="flex flex-col items-center justify-center pt-5 pb-6">
            <x-lucide-upload class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" />
            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">{{ __('Click to upload or drag and drop') }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $text ?? '' }}</p>
        </div>
        <input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
            'class' => 'hidden',
            'name' => $field,
            'id' => $field,
            'type' => 'file'
        ]) !!} />
        @if(isset($icon))
            <img class="w-12 h-12" id="img" src="{{ $icon }}" />
            <p class="text-center text-sm " id="img_text">{{ $preview }}</p>
        @else
            <img class="hidden w-12 h-12" id="img" src="#" />
            <p class="hidden text-center text-sm " id="img_text">{{ $preview }}</p>
        @endif
    </label>
</div> 

<script>
    let imgInp = document.getElementById('{{ $field }}');
    imgInp.onchange = event => {
    const [file] = imgInp.files
    console.log(file);
    if (file) {
        let img = document.getElementById('img');
        let text = document.getElementById('img_text');
        img.src = URL.createObjectURL(file);
        img.alt = 'Uploaded image';
        img.className = img.className.replace( /(?:^|\s)hidden(?!\S)/g , 'flex' );
        text.className = text.className.replace( /(?:^|\s)hidden(?!\S)/g , 'flex' );
    }
}
</script>