{{-- Add pill xD --}}
@props(['profile' => false])

@php
    $bannable = false;
    $type = $comment->likeType ?? null;
    if($comment->deleted) {
        $comment->user->username = 'DELETED';
        $comment->user->id = 'DELETED';
        $comment->body = '[DELETED]';
        $comment->user_id = 0;
    }

    if(Auth::check()) {
		$bannable = $comment->user->role != 'admin' && (Auth::user()->role === 'admin' || ($comment->user->role != 'moderator' && Auth::user()->role == 'moderator'));
	}
@endphp

@if($bannable)
	<script type="text/javascript">
		document.addEventListener('DOMContentLoaded', function() {
			handleModal("{{ route('user.ban', ':id') }}", '.banTrigger', 'banModal', 'banForm');
		});
	</script>
@endif


<script type="text/javascript">
	document.addEventListener('DOMContentLoaded', function() {
		handleModal("{{ route('comment.destroy', ':id') }}", '.commentModalTrigger')
	});
</script>

<x-modals.delete text="{{ __('Are you sure you want to ban the user?') }}" id="banModal" form="banForm" method="POST">
    <x-lucide-ban class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" />
</x-modals.delete>

<div {{ $attributes->merge(["class" => "w-full bg-card pt-2 pb-1 px-4 text-main rounded-lg", 'id' => $comment->id]) }}>
    <div x-data="{ open: false, expanded: true, commentOpen: false }">
        <div x-cloak x-show="!expanded" class="flex text-muted text-xs gap-2 items-center">
            <button x-on:click="expanded = !expanded" aria-label="Expand comment">
                <x-lucide-chevron-right class="w-4 h-4" />
            </button>
            <p class="font-bold"><a>{{ $comment->user->username }}</a></p>
            <p class="text-xs text-muted">•</p>
            <p x-on:click="expanded = !expanded">{{ substr($comment->body, 0, 20) }}</p>
        </div>
        <div x-cloak x-show="expanded" x-collapse>
            <div class="flex items-center gap-1">
                <button x-show="expanded" x-on:click="expanded = !expanded" aria-label="Collapse comment">
                    <x-lucide-chevron-down class="w-4 h-4" />
                </button>
                @if(!$profile && !$comment->deleted)
                    <img class="w-4 h-4 rounded-full" src="{{ asset("storage/".$comment->user->image) }}" alt="{{ $comment->user->username }}'s profile picture" />
                @endif
                @if(!$comment->deleted)
                    <a href="{{ route('user.show', $comment->user->username) }}" class="text-xs text-main font-bold hover:underline">{{ $comment->user->username }}</a> 
                @else
                    <p class="text-xs text-main font-bold">{{ $comment->user->username }}</p> 
                @endif
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
        
            @if(!$comment->deleted)
                <div class="flex justify-between items-center">
                    <div id="comment_{{ $comment->id }}" class="flex justify-between flex-grow  lg:justify-start gap-5 md:gap-3 lg:gap-1 items-center">
                        <div id="comment_likes" class="flex items-center p-1 hover:bg-main rounded-lg cursor-pointer {{ $type == 'like' ? 'bg-main' : '' }}" onClick="giveLike('like', '{{ $comment->id }}', '{{ route('comment.like', ['comment' => $comment->id]) }}', '{{ csrf_token() }}', {{ $archived }}, 'comment')">
                            <x-lucide-arrow-big-up-dash class="w-8 h-8 md:w-6 md:h-6 lg:w-5 lg:h-5 text-green-500" />
                        </div>
                        <p id="comment_likes_count" class="lg:text-xs font-bold mr-1">{{ $comment->likeCount ?? 0 }}</p>
                
                        <div  id="comment_dislikes" class="flex items-center p-1 hover:bg-main rounded-lg cursor-pointer {{ $type == 'dislike' ? 'bg-main' : '' }}" onClick="giveLike('dislike', '{{ $comment->id }}', '{{ route('comment.like', ['comment' => $comment->id]) }}', '{{ csrf_token() }}', {{ $archived }}, 'comment')">
                            <x-lucide-arrow-big-down-dash class="w-8 h-8 md:w-6 md:h-6 lg:w-5 lg:h-5 text-red-500 " />
                        </div>        
                        <p id="comment_dislikes_count" class="lg:text-xs font-bold">{{ $comment->dislikeCount ?? 0 }}</p>
                
                        @if(!$archived && $profile === false)
                            <div x-on:click="open = !open" class="flex items-center p-2 hover:bg-main rounded-lg cursor-pointer ml-2 gap-2">
                                <x-lucide-message-square-reply class="w-8 h-8 md:w-6 md:h-6 lg:w-5 lg:h-5 text-muted" />
                                <p class="text-sm select-none">Reply</p>
                            </div>
                        @endif
                        
                        <div class="select-none">

                            <div x-on:click="commentOpen = !commentOpen" x-on:click.outside="commentOpen = false" class="flex items-center hover:bg-main p-2 rounded-xl text-main cursor-pointer">
                                <svg x-cloak x-show="!commentOpen" class="w-4 h-4" rpl="" fill="currentColor" height="12" icon-name="overflow-horizontal-fill" viewBox="0 0 20 20" width="12" xmlns="http://www.w3.org/2000/svg"> <!--?lit$164882748$--><!--?lit$164882748$--><path d="M6 10a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm6 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z"></path><!--?--> </svg>
                                <x-lucide-circle-x x-cloak x-show="commentOpen" class="w-4 h-4" />
                            </div>
                            
                            <x-animation.pop-in class="relative" open="commentOpen">
                                <x-posts.dropdown>
                                    @if(Auth::check())
                                        @if(in_array(Auth::user()->role, ['admin', 'moderator']) || Auth::user()->id == $comment->user_id)
                                            <x-nav.dropdown-link class="flex items-center gap-2" href="{{ route('comment.edit', ['comment' => $comment->id, 'post' => $comment->post_id]) }}">
                                                <x-lucide-pencil />
                                                {{ __('Edit') }}
                                            </x-nav.dropdown-link>
                                            <x-nav.dropdown-link class="commentModalTrigger flex items-center gap-2 text-red-500" data-trigger="{{ $comment->id }}">
                                                <x-lucide-trash-2 />
                                                {{ __('Delete') }}
                                            </x-nav.dropdown-link>
                                        @endif
                                        @if($bannable)
                                            <x-nav.dropdown-link class="banTrigger  flex items-center gap-2" href="#" data-trigger="{{ $comment->user->id }}">
                                                <x-lucide-ban />
                                                {{ __('Ban user') }}
                                            </x-nav.dropdown-link>
									    @endif
                                    @endif
                                </x-posts.dropdown>		
                            </x-animation.pop-in>

                        </div>
                    </div>    
                </div>
            @endif
        
            <div :class="{ 'block': open, 'hidden': !open }" class="hidden">
                <form method="POST" action="{{ route('comment.store', ['post' => $comment->post_id]) }}">
                    @csrf
                    <input type="text" name="parent" class="hidden" value="{{ $comment->id }}" />
                    <x-form.label class="mb-1" for="body" text="{{ __('Reply to '.$comment->user->username) }}" />
                    <x-form.textarea required class="w-full shadow-sm" placeholder="I agree!" field="body"></x-form.textarea>
                    <div class="flex justify-end items-center gap-2 mt-2">
                        <x-form.cancel x-on:click="open = false" class="cursor-pointer p-2">{{ __('Cancel') }}</x-form.cancel>
                        <x-form.submit>{{ __('Post a reply') }}</x-form.submit>
                    </div>
                </form>
            </div>
        
            @if ($comment->replies->count() > 0 && $profile === false)
                @foreach ($comment->replies as $reply)
                    <div x-data="{open: false}" class="ml-[2px] lg:ml-1 border-l-gray-400 border-l-2 p-2" >
                        <x-posts.comment :comment="$reply" :op="$op" :archived="$archived"/>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
