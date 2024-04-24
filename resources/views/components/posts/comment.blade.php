{{-- Add pill xD --}}
<div {{ $attributes->merge(["class" => "w-full bg-card pt-2 pb-1 px-4 text-main rounded-lg", 'id' => $comment->id]) }}>
    <div x-data="{ open: false, expanded: true }">
        <div x-show="!expanded" class="flex text-muted text-xs gap-2 items-center">
            <button x-on:click="expanded = !expanded">
                <x-lucide-chevron-right class="w-4 h-4" />
            </button>
            <p class="font-bold"><a>{{ $comment->user->username }}</a></p>
            <p class="text-xs text-muted">•</p>
            <p x-on:click="expanded = !expanded">{{ substr($comment->body, 0, 20) }}</p>
        </div>
        <div x-show="expanded" x-collapse>
            <div class="flex items-center gap-1">
                {{-- Image goes here... --}}
                <button x-show="expanded" x-on:click="expanded = !expanded">
                    <x-lucide-chevron-down class="w-4 h-4" />
                </button>
                <a href="{{ route('user.show', $comment->user->username) }}" class="text-xs text-main font-bold hover:underline">{{ $comment->user->username }}</a> 
                @if ($op == $comment->user_id)
                   <x-lucide-pickaxe class="w-4 h-4" title="{{ __('Original poster') }}" />
                @endif
                <p class="text-xs text-muted">•</p>
                <p class="text-xs text-muted cursor-default" title="{{ $comment->created_at }}">{{ $timeAgo }}</p>
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
            
                    <div x-on:click="open = !open" class="flex items-center p-2 hover:bg-main rounded-lg cursor-pointer ml-2 gap-2">
                        <x-lucide-message-square-reply class="w-8 h-8 md:w-6 md:h-6 lg:w-5 lg:h-5 text-muted" />
                        <p class="text-sm select-none">Reply</p>
                    </div>
        
                    <div class="flex items-center p-2 hover:bg-main rounded-lg cursor-pointer">
                        <svg rpl="" fill="currentColor" height="12" icon-name="overflow-horizontal-fill" viewBox="0 0 20 20" width="12" xmlns="http://www.w3.org/2000/svg"> <!--?lit$164882748$--><!--?lit$164882748$--><path d="M6 10a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm6 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z"></path><!--?--> </svg>
                    </div>
                    
                    {{-- Implement comments dropdown here... --}}
                    <div class="absolute hidden">
        
                    </div>
                </div>    
            </div>
        
            <div :class="{ 'block': open, 'hidden': !open }" class="hidden">
                <form method="POST" action="{{ route('comment.store', ['post' => $comment->post_id]) }}">
                    @csrf
                    <input type="text" name="parent" class="hidden" value="{{ $comment->id }}" />
                    <x-form.label class="mb-1" for="body" text="{{ __('Reply to '.$comment->user->username) }}" />
                    <x-form.textarea required class="w-full shadow-sm" placeholder="I agree!" field="body"></x-form.textarea>
                    <div class="flex justify-end items-center gap-2 mt-2">
                        <div x-on:click="open = false" class="cursor-pointer p-2">{{ __('Cancel') }}</div>
                        <x-form.submit>{{ __('Post a reply') }}</x-form.submit>
                    </div>
                </form>
            </div>
        
            @if ($comment->replies->count() > 0)
                @foreach ($comment->replies as $reply)
                    <div x-data="{open: false}" class="ml-1 lg:ml-5 border-l-gray-200 border-l-2 p-2" >
                        <x-posts.comment :comment="$reply" :op="$op"/>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
