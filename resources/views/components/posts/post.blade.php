{{-- User, posted before x + timestamp, edit status, tags, 50char desc, likes, comments, share, (options if author) --}}
{{-- @props(['post']) --}}

{{--  'edited' => false, 'tags' => array(), 'comments' => 0, 'author' => false --}}

@php
	if(strlen($post->body) > 256) {
		$post->body = substr($post->body, 0, 253).'...';
	}
	$type = $post->likeType ?? null;
@endphp

 {{-- onClick="window.location.href='{{ route('post.show', ['category' => $post->category_id, 'post' => $post->id]) }}'" --}}

<div {{ $attributes->merge(["class" => "w-full bg-card pt-2 pb-1 px-4 text-main rounded-lg cursor-pointer shadow-sm border border-main"]) }} >
	<div>
		<div class="flex items-center gap-1">
			@if($profile)
			<img class="w-4 h-4 dark:bg-slate-100 rounded-full" src="{{ asset("storage/".$post->category->icon) }}" alt="Category icon">
			<a href="{{ route('category.index', ['category' => $post->category_id]) }}"class="text-xs text-main font-bold hover:underline">{{ $post->category->name }}</a>
			<p class="text-xs text-muted">•</p>
			<p class="text-xs text-muted cursor-default" title="{{ $post->created_at }}">{{ $timeAgo }}</p>
			@else
				<img class="w-4 h-4 rounded-full" src="{{ asset("storage/".$post->poster->image) }}" alt="{{ $post->poster->username }}'s profile picture" />
				<a href="{{ route('user.show', $post->poster->username) }}" class="text-xs text-main font-bold hover:underline">{{ $post->poster->username }}</a> 
				<p class="text-xs text-muted">•</p>
				<p class="text-xs text-muted cursor-default" title="{{ $post->created_at }}">{{ $timeAgo }}</p>
			@endif
			@if($edited)	
				<p class="text-xs text-muted cursor-default" title="{{ $post->updated_at }}">(Edited)</p>
			@endif
			@if($post->archived)
				<div class="flex gap-1 items-center p-1 rounded-lg bg-main">
					<x-lucide-archive class="w-4 h-4"/>
					<span class="text-xs uppercase">{{ __('Archived') }}</span>
				</div>
			@endif
		</div>
	
		<div class="mt-2 h-auto">
			<p class="font-bold">{{ $post->title }}</p>
			<div class="text-muted text-sm">
				<p class="text-wrap break-words">{{ $post->body }}</p>
			</div>
		</div>
	</div>

	<div class="mt-2 flex justify-between lg:justify-start items-center gap-8">
		<div id="post_{{ $post->id }}" class="flex gap-5 md:gap-3 lg:gap-1 items-center">
			<div id="post_likes" class="p-1 hover:bg-main rounded-lg {{ $type == 'like' ? 'bg-main' : '' }}" onClick="giveLike('like', '{{ $post->id }}', '{{ route('post.like', ['post' => $post->id]) }}', '{{ csrf_token() }}',  {{ $post->archived }})">
				<x-lucide-arrow-big-up-dash class="w-5 h-5 text-green-500" />
			</div>
			<p id="post_likes_count" class="lg:text-xs font-bold mr-1">{{ $post->likeCount }}</p>

			<div id="post_dislikes" class="p-1 hover:bg-main rounded-lg {{ $type == 'dislike' ? 'bg-main' : '' }}" onClick="giveLike('dislike', '{{ $post->id }}', '{{ route('post.like', ['post' => $post->id]) }}', '{{ csrf_token() }}', {{ $post->archived }})">
				<x-lucide-arrow-big-down-dash class=" w-5 h-5 text-red-500 " />
			</div>
			
			<p id="post_dislikes_count" class="lg:text-xs font-bold">{{ $post->dislikeCount }}</p>
		</div>

		<a href="{{ route('post.show', ['category' => $post->category_id, 'post' => $post->id]) }}" class="flex items-center gap-1 hover:bg-main rounded-lg p-2">
			<x-lucide-message-square-text class=" w-5 h-5" />
			<p class="text-xs font-bold">{{ $post->comments_count }}</p>
		</a>

		<div x-data="{
			link: '{{ route('post.show', ['post' => $post->id, 'category' => $post->category_id]) }}',
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
			<div x-on:click="open = !open" class="flex items-center gap-1 hover:bg-main rounded-lg p-2">
				<x-lucide-square-arrow-out-up-right class=" w-5 h-5" />
				<p class="lg:text-xs">{{ __('Share') }}</p>
			</div>

			<x-animation.pop-in class="relative" open="open">
				<x-posts.dropdown open="open" class="absolute w-96">
					<div>
						<h2 class="text-md text-main text-center font-semibold mb-2">{{ __('Share the post') }}</h2>
						<div x-on:click="copy" class="flex items-center justify-between relative w-full border-b-2 text-main dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm p-2 ">
							<div class="flex gap-1 items-center select-none">
								<x-lucide-link-2 class="w-3 h-3" />
								<p class="text-xs flex items-center overflow-x-auto">
									{{ route('post.show', ['category' => $post->category_id, 'post' => $post->id]) }}
								</p>
							</div>
							<x-lucide-copy x-show="!copied" x-cloak class="w-4 h-4 cursor-pointer" />
							<x-lucide-circle-check-big x-show="copied" x-cloak class="w-4 h-4 cursor-pointer text-green-500" />
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
