@props(['comment', 'op'])
{{-- Add pill xD --}}
@php
	$edited = $comment->created_at != $comment->updated_at;
@endphp

<div {{ $attributes->merge(["class" => "w-full bg-card pt-2 pb-1 px-4 text-main rounded-lg", 'id' => $comment->id]) }}>
    <div class="flex items-center gap-1">
		{{-- Image goes here... --}}
		<a href="{{ route('user.show', $comment->username) }}" class="text-xs text-main font-bold hover:underline">{{ $comment->username }}</a> 
        @if ($op == $comment->user_id)
           <x-lucide-pickaxe class="w-4 h-4" title="{{ __('Original poster') }}" />
        @endif
        <p class="text-xs text-muted">•</p>
        <p class="text-xs text-muted cursor-default" title="{{ $comment->created_at }}">5 days ago</p>
		@if($edited)
			<p class="text-xs text-muted cursor-default" title="{{ $comment->updated_at }}">(Edited)</p>
		@endif
    </div>
    
    <p class="text-main">
        {{ $comment->body }}
    </p>

    <div class="flex justify-between items-center">
        <div class="flex justify-between flex-grow  lg:justify-start gap-5 md:gap-3 lg:gap-1 items-center">
            <div class="flex items-center p-1 hover:bg-main rounded-lg cursor-pointer">
                <x-lucide-arrow-big-up-dash class="w-8 h-8 md:w-6 md:h-6 lg:w-5 lg:h-5 text-green-500" />
            </div>
            <p class="lg:text-xs font-bold mr-1">0</p>
    
            <div class="flex items-center p-1 hover:bg-main rounded-lg cursor-pointer">
                <x-lucide-arrow-big-down-dash class="w-8 h-8 md:w-6 md:h-6 lg:w-5 lg:h-5 text-red-500 " />
            </div>        
            <p class="lg:text-xs font-bold">0</p>
    
            <div class="flex items-center p-2 hover:bg-main rounded-lg cursor-pointer ml-2">
                <x-lucide-message-square-reply class="w-8 h-8 md:w-6 md:h-6 lg:w-5 lg:h-5 text-muted" />
                <p class="text-sm">Reply</p>
            </div>

            <div class="flex items-center p-2 hover:bg-main rounded-lg cursor-pointer">
                <svg rpl="" fill="currentColor" height="12" icon-name="overflow-horizontal-fill" viewBox="0 0 20 20" width="12" xmlns="http://www.w3.org/2000/svg"> <!--?lit$164882748$--><!--?lit$164882748$--><path d="M6 10a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm6 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z"></path><!--?--> </svg>
            </div>
        </div>    
    </div>

</div>