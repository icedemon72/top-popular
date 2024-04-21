<div x-data="{ open: true }" :class="{ 'block': open, 'hidden': !open }" class="bg-green-800 dark:bg-green-500 relative p-2 mb-7 rounded-lg">
    <div class="absolute group top-0 right-0 cursor-pointer p-1 " @click="open = false"><x-lucide-circle-x /></div>
    {{ $slot }}
</div>