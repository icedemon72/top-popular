@props(['comments' => 0, 'posts' => '0', 'replies' => 0, 'stats'])

<div class="w-full">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-2">
        <div class="col-span-1 flex flex-col items-center justify-center bg-card p-4 rounded-lg">
            <x-lucide-square-pen class="w-7 h-7" />
            <p class="text-main text-2xl font-bold">{{ $posts }}</p>
            <p class="text-main text-muted text-sm">{{ __('Posts created') }}</p>
        </div>

        <div class="col-span-1 flex flex-col items-center justify-center bg-card p-4 rounded-lg">
            <x-lucide-message-square-plus class="w-7 h-7" />
            <p class="text-main text-2xl font-bold">{{ $comments }}</p>
            <p class="text-main text-muted text-sm">{{ __('Comments created') }}</p>
        </div>

        <div class="col-span-1 flex flex-col items-center justify-center bg-card p-4 rounded-lg">
            <x-lucide-message-square-reply class="w-7 h-7" />
            <p class="text-main text-2xl font-bold">{{ $replies }}</p>
            <p class="text-main text-muted text-sm">{{ __('Replies') }}</p>
        </div>

        <div class="col-span-1 flex flex-col items-center justify-center bg-card p-4 rounded-lg">
            <x-lucide-arrow-big-up-dash class="w-7 h-7" />
            <p class="text-main text-2xl font-bold">{{ $stats->likes }}</p>
            <p class="text-main text-muted text-sm">{{ __('Received likes') }}</p>
        </div>

        <div class="col-span-1 flex flex-col items-center justify-center bg-card p-4 rounded-lg">
            <x-lucide-arrow-big-down-dash class="w-7 h-7" />
            <p class="text-main text-2xl font-bold">{{ $stats->dislikes }}</p>
            <p class="text-main text-muted text-sm">{{ __('Received dislikes') }}</p>
        </div>

        <div class="col-span-1 flex flex-col items-center justify-center bg-card p-4 rounded-lg">
            <x-lucide-hand-heart class="w-7 h-7" />
            <p class="text-main text-2xl font-bold">{{ $stats->liked }}</p>
            <p class="text-main text-muted text-sm">{{ __('Liked') }}</p>
        </div>

        <div class="col-span-1 flex flex-col items-center justify-center bg-card p-4 rounded-lg">
            <x-lucide-heart-off class="w-7 h-7" />
            <p class="text-main text-2xl font-bold">{{ $stats->disliked }}</p>
            <p class="text-main text-muted text-sm">{{ __('Disliked') }}</p>
        </div>
    </div>
</div>