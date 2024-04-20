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

<div {{ $attributes->merge(["class" => "w-full bg-card p-4 text-main rounded-lg cursor-pointer"]) }}>
	<div class="flex items-center gap-1">
		{{-- Image goes here... --}}
		<p class="text-xs text-main font-bold">Autor Autoric</p> 
		<p class="text-xs text-muted">•</p>
		<p class="text-xs text-muted cursor-default" title="{{ $post->created_at }}">5 days ago</p>
		@if($edited)
			<p class="text-xs text-muted cursor-default" title="{{ $post->updated_at }}">(Edited)</p>
		@endif
	</div>

	<div class="mt-2">
		<p class="font-bold">{{ $post->title }}</p>
		<p class="text-muted text-sm">{{ $post->body ?? '' }}</p>
	</div>

	<div class="mt-2 flex justify-start items-center gap-8">
		<div class="flex items-center">
			<x-lucide-arrow-big-up-dash class="w-5 h-5 text-green-500" />
			<p class="text-xs font-bold">0</p>
			<x-lucide-arrow-big-down-dash class="w-5 h-5 text-red-500" />
			<p class="text-xs font-bold">0</p>
		</div>

		<div class="flex items-center gap-1">
			<x-lucide-messages-square class="w-5 h-5" />
			<p class="text-xs font-bold">120</p>
		</div>

		<div class="flex items-center gap-1">
			<x-lucide-square-arrow-out-up-right class="w-5 h-5" />
			<p class="text-xs">{{ __('Share') }}</p>
		</div>
	</div>
</div>