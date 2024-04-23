@section('title', )

@php
	$edited = $data->created_at !== $data->updated_at;
@endphp

<x-master-layout>
	<div x-data="{commentOpen: false}" class="w-full flex flex-col justify-cente items-center">
		{{-- POST --}}
		<div class="w-full md:w-4/5 lg:w-3/5 bg-card rounded-lg p-4">
			<div class="flex items-center justify-between">
				<div class="flex items-center gap-1">
					<a href="{{ route('post.index', $data->category_id) }}">
						<x-lucide-arrow-left />
					</a>
					<a href="{{ route('user.show', $data->username) }}" class="text-xs text-main font-bold hover:underline underline-offset-1 cursor-pointer">
						{{ $data->username }}
						<span class="uppercase">{{ $data->role }}</span>
					</a> 
					<p class="text-xs text-muted">•</p>
					<p class="text-xs text-muted cursor-default" title="{{ $data->created_at }}">5 days ago</p>
					@if($edited)
						<p class="text-xs text-muted cursor-default" title="{{ $data->updated_at }}">(Edited)</p>
					@endif
				</div>
				<div class="flex items-center hover:bg-main p-2 rounded-xl text-main">
					<svg rpl="" fill="currentColor" height="12" icon-name="overflow-horizontal-fill" viewBox="0 0 20 20" width="12" xmlns="http://www.w3.org/2000/svg"> <!--?lit$164882748$--><!--?lit$164882748$--><path d="M6 10a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm6 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z"></path><!--?--> </svg>
				</div>
				
			</div>

			<div class="mt-2">
				<h1 class="text-xl text-main font-bold">{{ $data->title }}</h1>
				<div class="flex mt-1 items-center">
					@foreach($tags as $tag)
					<a href="#" class="flex items-center gap-1 p-2 rounded-full text-xs text-main bg-main hover:bg-card hover:underline">
							<x-lucide-tag class="w-3 h-3"/>
							{{ $tag->name }}
						</a>
					@endforeach
				</div>
				<div class="text-main">{{ $data->body }}</div>
			</div>

			<div class="mt-2 flex justify-between lg:justify-start items-center gap-8 text-main">
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
		
				<div class="flex items-center gap-1 hover:bg-main rounded-lg p-2">
					<x-lucide-message-square-text class="w-8 h-8 md:w-6 md:h-6 lg:w-5 lg:h-5" />
					<p class="text-xs font-bold">{{ count($comments) }}</p>
				</div>
		
				<div class="flex items-center gap-1 hover:bg-main rounded-lg p-2">
					<x-lucide-square-arrow-out-up-right class="w-8 h-8 md:w-6 md:h-6 lg:w-5 lg:h-5" />
					<p class="lg:text-xs">{{ __('Share') }}</p>
				</div>
			</div>
			
		</div>

		{{-- COMMENTS --}}
		<div class="w-full md:w-4/5 lg:w-3/5 flex items-center gap-3 bg-card rounded-lg p-4 mt-5 font-bold text-main">
			COMMENTS ({{ count($comments) }})
			@if(Auth::check())
				@section('head')
					@vite(['resources/js/quill.js' ])
				@endsection
				<button x-on:click="commentOpen = !commentOpen" class="text-xs uppercase bg-main rounded-lg p-2 text-main hover:bg-card">
					{{ __('Add a comment') }}
				</button>
			@else
				<span class="text-muted"><a href="{{ route('login') }}" class="underline hover:text-main">Login</a> to post a comment...</span>
			@endif
		</div>

		<div :class="{'block': commentOpen, 'hidden': !commentOpen}" class="hidden w-full md:w-4/5 lg:w-3/5 bg-card rounded-lg p-4 mt-1">
			<form class="w-full" method="POST" action="{{ route('comment.store', ['post' => $data->id]) }}">
				@csrf

				<x-form.label class="my-1" for="body" text="{{ __('Comment body') }}" />
				<x-form.text-area class="w-full" placeholder="Your comment" field="body" :required="true"/>
				<div class="flex flex-1 justify-end">
					<x-form.submit class="mt-2">{{ __('Post a comment') }}</x-form.submit>
				</div>
			</form>
		</div>

		<div class="w-full md:w-4/5 lg:w-3/5 bg-card rounded-lg p-4 mt-3">
			<div class="flex items-center mb-2 p-1 gap-2">
				<x-lucide-arrow-down-narrow-wide class="w-5 h-5 text-muted" />
				<div class="flex items-center cursor-pointer bg-main rounded-xl">
					<select id="select1" onChange="changePopularity()" class="appearance-none bg-main text-xs text-muted p-2 cursor-pointer hover:bg-card rounded-xl">
						<option value="popular">{{ __('Popular') }}</option>
						<option value="new">{{ __('New') }}</option>
						<option value="top">{{ __('Top') }}</option>
					</select>
				</div>
				<div class="flex items-center cursor-pointer bg-main rounded-xl">
					<select id="select1" onChange="changePopularity()" class="appearance-none bg-main text-xs text-muted p-2 cursor-pointer hover:bg-card rounded-xl">
						<option value="today">{{ __('Today') }}</option>
						<option value="week">{{ __('This week') }}</option>
						<option value="month">{{ __('This month') }}</option>
						<option value="year">{{ __('This year') }}</option>
						<option value="all">{{ __('All') }}</option>
					</select>
				</div>
			</div>
			@foreach($comments as $comment) 
				<x-posts.comment :comment="$comment" :op="$data->user_id"/>
			@endforeach
		</div>

	</div>
</x-master-layout>