<div x-data="{ open: true }" :class="{ 'block': open, 'hidden': !open }" class="w-full bg-red-300 dark:bg-red-800 text-main p-2 mb-7 rounded-lg relative inline-block shadow-sm">
    <div class="absolute group top-0 right-0 cursor-pointer p-1" @click="open = false"><x-lucide-circle-x /></div>
    <div>
        <p class="font-bold">{{ __('Your form contains following errors:') }}</p>
        {{ $slot }}
    </div>
</div>