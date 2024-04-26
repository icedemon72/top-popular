{{-- php
	function timeago($date) {
	   $timestamp = strtotime($date);	
	   
	   $strTime = array("second", "minute", "hour", "day", "month", "year");
	   $length = array("60", "60", "24", "30" ,"12" ,"10");

	   $currentTime = time();
	   if($currentTime >= $timestamp) {
			$diff = time() - $timestamp;
			for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
			$diff = $diff / $length[$i];
			}

			$diff = round($diff);
			return $diff . " " . $strTime[$i] . "(s) ago";
	   }
	}
?> --}}


{{-- User, posted before x + timestamp, edit status, tags, 50char desc, likes, comments, share, (options if author) --}}
@props(['post'])

{{--  'edited' => false, 'tags' => array(), 'comments' => 0, 'author' => false --}}

@php
	$edited = $post->created_at != $post->updated_at;
	if(strlen($post->body) > 256) {
		$post->body = substr($post->body, 0, 253).'...';
	}
@endphp

 {{-- onClick="window.location.href='{{ route('post.show', ['category' => $post->category_id, 'post' => $post->id]) }}'" --}}

<div {{ $attributes->merge(["class" => "w-full bg-card pt-2 pb-1 px-4 text-main rounded-lg cursor-pointer"]) }} >
	<div>
		<div class="flex items-center gap-1">
			{{-- Image goes here... --}}
			<a href="{{ route('user.show', $post->username) }}" class="text-xs text-main font-bold hover:underline">{{ $post->username }}</a> 
			<p class="text-xs text-muted">•</p>
			<p class="text-xs text-muted cursor-default" title="{{ $post->created_at }}">5 days ago</p>
			@if($edited)	
				<p class="text-xs text-muted cursor-default" title="{{ $post->updated_at }}">(Edited)</p>
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
		<div class="flex gap-5 md:gap-3 lg:gap-1 items-center">
			<div class="p-1 hover:bg-main rounded-lg">
				<x-lucide-arrow-big-up-dash class="w-8 h-8 md:w-6 md:h-6 lg:w-5 lg:h-5 text-green-500" />
			</div>
			<p class="lg:text-xs font-bold mr-1">0</p>

			<div class="p-1 hover:bg-main rounded-lg">
				<x-lucide-arrow-big-down-dash class="w-8 h-8 md:w-6 md:h-6 lg:w-5 lg:h-5 text-red-500 " />
			</div>
			
			<p class="lg:text-xs font-bold">0</p>
		</div>

		<a href="{{ route('post.show', ['category' => $post->category_id, 'post' => $post->id]) }}" class="flex items-center gap-1 hover:bg-main rounded-lg p-2">
			<x-lucide-message-square-text class="w-8 h-8 md:w-6 md:h-6 lg:w-5 lg:h-5" />
			<p class="text-xs font-bold">{{ $post->comments }}</p>
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
				<x-lucide-square-arrow-out-up-right class="w-8 h-8 md:w-6 md:h-6 lg:w-5 lg:h-5" />
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
							<x-lucide-copy x-show="!copied" class="w-4 h-4 cursor-pointer" />
							<x-lucide-circle-check-big x-show="copied" class="w-4 h-4 cursor-pointer text-green-500" />
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
