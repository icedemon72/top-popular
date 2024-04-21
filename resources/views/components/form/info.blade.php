<div x-data="{ open: true }" :class="{ 'block': open, 'hidden': !open }" class="p-4 text-center w-full text-muted relative inline-block rounded-lg bg-gray-300 dark:bg-gray-700">
    <div class="absolute group top-0 right-0 cursor-pointer p-1 " @click="open = false"><x-lucide-circle-x /></div>
    {{ $slot }}
</div>