@props(['query' => ''])

<th class="sortable_th px-6 py-4 cursor-pointer" x-on:click=" asc = !asc;" data-sort="{{ $query }}" x-bind:data-order="asc">
    <div class="flex gap-1 items-center">
        {{ $slot }}
        <x-lucide-chevrons-up-down x-cloak class="w-4 h-4   block" id="{{ $query }}" />
        <x-lucide-chevron-down id="{{ $query }}_asc" class="w-4 h-4 hidden" />
        <x-lucide-chevron-up id="{{ $query }}_desc" class="w-4 h-4 hidden" />
    </div>
</th>