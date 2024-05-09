@php
	use Carbon\Carbon;
	$edited = $comment->post->created_at != $comment->post->updated_at;
@endphp

@section('title', 'Edit comment')

<x-master-layout>
	<x-slot name="header">
		<div class="flex w-full justify-center">
			<h2 class="w-full md:w-4/5 lg:w-3/5 flex items-center gap-2 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight bg-white dark:bg-gray-800 p-4 rounded-lg">
				<x-lucide-pencil />
				{{ __('Edit your comment') }}				
			</h2>
		</div>
	</x-slot>

	<div class="w-full flex flex-col justify-center items-center mt-5">
		<div class="w-full md:w-4/5 lg:w-3/5 bg-card rounded-lg p-4">
			@if(session('edited'))
				<x-form.success>
					{{ __('Post edited successfully') }}
				</x-form.success>
			@endif
			<div x-data="{open: false}" class="flex items-center justify-between">
				<div class="flex items-center gap-1">
					<a class="hover:bg-main rounded-xl" href="{{ route('post.index', $comment->post->category_id) }}">
						<x-lucide-arrow-left />
					</a>
					<div class="flex items-center gap-2">
						@if($comment->post->deleted)
							<p class="text-xs text-main font-bold  underline-offset-1 cursor-pointer">
								{{ $comment->post->poster->username }}
							</p> 
						@else
							<img class="w-4 h-4 rounded-full" src="{{ asset("storage/".$comment->post->poster->image) }}" alt="{{ $comment->post->poster->username }}'s profile picture" />
							<a href="{{ route('user.show', $comment->post->poster->username) }}" class="text-xs text-main font-bold hover:underline underline-offset-1 cursor-pointer">
								{{ $comment->post->poster->username }}
							</a> 
							<x-profile.badge role="{{ $comment->post->poster->role }}" />
						@endif
					</div>
					<p class="text-xs text-muted">•</p>
					<p class="text-xs text-muted cursor-default" title="{{ $comment->post->created_at }}">{{ Carbon::parse($comment->post->created_at)->diffForHumans() }}</p>
					@if($edited)
						<p class="text-xs text-muted cursor-default" title="{{ $comment->post->updated_at }}">(Edited)</p>
					@endif
				</div>
			</div>
	
			<div class="mt-2">
				<h1 class="text-xl text-main font-bold">{{ $comment->post->title }}</h1>
				<div class="flex mt-1 items-center">
					@foreach($comment->post->tags as $tag)
						<a href="#" class="flex items-center gap-1 p-2 rounded-full text-xs text-main bg-main hover:bg-card hover:underline">
							<x-lucide-tag class="w-3 h-3"/>
							{{ $tag->name }}
						</a>
					@endforeach
				</div>
				<div class="text-main">{{ $comment->post->body }}</div>
			</div>
	
			<div class="mt-2 flex justify-between lg:justify-start items-center gap-8 text-main">
				{{-- <div id="post_{{ $comment->post->id }}" class="flex gap-5 md:gap-3 lg:gap-1 items-center">
					<div id="post_likes" class="p-1 hover:bg-main rounded-lg cursor-pointer {{ $type == 'like' ? 'bg-main' : '' }}" onClick="giveLike('like', '{{ $comment->post->id }}', '{{ route('post.like', ['post' => $comment->post->id]) }}', '{{ csrf_token() }}')">
						<x-lucide-arrow-big-up-dash class="w-8 h-8 md:w-6 md:h-6 lg:w-5 lg:h-5 text-green-500" />
					</div>
					<p id="post_likes_count" class="lg:text-xs font-bold mr-1">{{ $comment->post->likeCount}}</p>
		
					<div id="post_dislikes" class="p-1 hover:bg-main rounded-lg cursor-pointer {{ $type == 'dislike' ? 'bg-main' : '' }}" onClick="giveLike('dislike', '{{ $comment->post->id }}', '{{ route('post.like', ['post' => $comment->post->id]) }}', '{{ csrf_token() }}')">
						<x-lucide-arrow-big-down-dash class="w-8 h-8 md:w-6 md:h-6 lg:w-5 lg:h-5 text-red-500 " />
					</div>
					
					<p id="post_dislikes_count" class="lg:text-xs font-bold">{{ $comment->post->dislikeCount }}</p>
				</div> --}}
		
				<a class="flex items-center gap-1 hover:bg-main rounded-lg p-2" href="#comments">
					<x-lucide-message-square-text class="w-8 h-8 md:w-6 md:h-6 lg:w-5 lg:h-5" />
					{{-- <p class="text-xs font-bold">{{ count($comments) }}</p> --}}
				</a>
		
				<div x-data="{
					link: '{{ route('post.show', ['post' => $comment->post->id, 'category' => $comment->post->category_id]) }}',
					timeout: null,
					copied: false,
					open: false,    
					copy () {
						$clipboard(this.link);
						this.copied = true;
						clearTimeout(this.timeout);
		
						this.timeout = setTimeout(() => {
							this.copied = false;
						}, 2000)
					}
				}" x-on:click.outside="open = false" >
					<div x-on:click="open = !open" class="flex items-center gap-1 hover:bg-main rounded-lg p-2 cursor-pointer">
						<x-lucide-square-arrow-out-up-right class="w-8 h-8 md:w-6 md:h-6 lg:w-5 lg:h-5" />
						<p class="lg:text-xs">{{ __('Share') }}</p>
					</div>
					<div x-on:click="copy">
						<x-animation.pop-in class="relative" open="open">
							<x-posts.dropdown open="open" class="absolute w-72">
								<div>
									<h2 class="text-md text-main text-center font-semibold mb-2">{{ __('Share the post') }}</h2>
									<div class="flex items-center justify-between relative w-full border-b-2 text-main dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm p-2 ">
										<div class="flex gap-1 items-center">
											<x-lucide-link-2 class="w-3 h-3" />
											<p class="text-xs flex items-center overflow-x-auto select-none">
													{{ route('post.show', ['category' => $comment->post->category_id, 'post' => $comment->post->id]) }}
											</p>
										</div>
										<x-lucide-copy x-cloak x-show="!copied" class="w-4 h-4 cursor-pointer" />
										<x-lucide-circle-check-big x-cloak x-show="copied" class="w-4 h-4 cursor-pointer text-green-500" />									
									</div>
	
									<div class="mt-2 p-2">
										<p class="text-xs text-muted">{{ __('You can copy the link by clicking the button above or by doing it manually.') }}</p>
									</div>
								</div>
							</x-posts.dropdown>
						</x-animation.pop-in>
					</div>
				</div>
			</div>
			
		</div>
	</div>

	

</x-master-layout>