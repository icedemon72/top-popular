<x-master-layout>
	<x-slot name="header">
		<div class="flex w-full justify-center">
			<h2 class="w-full md:w-4/5 lg:w-3/5 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight bg-gray-400 dark:bg-gray-800 p-4 rounded-lg">
					{{ $category->name }}
			</h2>
		</div>
	</x-slot>
	<div class="w-full flex justify-center mt-2">
		<div class="w-full md:w-4/5 lg:w-3/5 flex justify-end gap-3">
			<a href="{{ route('post.create', $category->id) }}" class="flex items-center cursor-pointer p-2">
				<x-lucide-plus class="w-5 h-5" />
				<p class="font-bold text-main text-xs">{{ __('Create a post') }}</p>
			</a>
			<div class="flex items-center p-2">
				<x-lucide-star class="w-5 h-5" />
				<p class="font-bold text-main text-xs">{{ __('To favs') }}</p>
			</div>
		</div>
	</div>
	<div class="w-full flex flex-col items-center justify-center mt-3">
		@if(count($posts) > 0)
			@foreach ($posts as $post)
				<div class="w-full md:w-4/5 lg:w-3/5">
					<x-posts.post class="mb-3"
						:post="$post"
					/>
				</div>
			@endforeach
		@else
			<div class="bg-card w-full flex md:w-4/5 lg:w-3/5 p-2 text-muted rounded-lg gap-1">
				{{ __('Huh, there seems to be no posts...') }} 
				<a class="underline hover:text-main" href="{{ route('post.create', $category->id) }}">{{ __('maybe add one?') }}</a>
			</div>
		@endif
	</div>
</x-master-layout>
