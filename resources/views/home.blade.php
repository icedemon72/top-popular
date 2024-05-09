@section('title', 'Home')

<x-master-layout>
    <x-slot name="header">
		<div class="flex w-full justify-center">
			<h2 class="w-full md:w-4/5 lg:w-3/5 flex items-center gap-2 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight bg-white dark:bg-gray-800 p-4 rounded-lg">
				<x-lucide-home />
				{{ __('Welcome to Top Popular Forum :)') }}
			</h2>
		</div>
	</x-slot>

	<div class="w-full flex flex-col items-center justify-center mt-2">
		<div class="w-full md:w-4/5 lg:w-3/5 flex flex-col p-4 gap-3">
			@if(count($favCategories) !== 0 && (!request()->has('page') || request()->page == 1))
				<div class="w-full flex items-center gap-2 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight bg-white dark:bg-gray-800 p-4 rounded-lg">
					<x-lucide-star class="fill-yellow-500" />
					{{ __('Your absolute favourites') }}
				</div>
				<x-home.section :categories="$favCategories" />

				<div class="w-full flex items-center gap-2 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight bg-white dark:bg-gray-800 p-4 mt-2 rounded-lg">
					<x-lucide-sprout />
					{{ __('Carefully picked posts') }}
				</div>
				@foreach($favPosts as $post)
					<x-posts.post class="mb-3" :post="$post" />
				@endforeach
			@endif
		</div>

		<div class="w-full md:w-4/5 lg:w-3/5 flex flex-col p-4 gap-3">
			<div class="w-full flex items-center gap-2 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight bg-white dark:bg-gray-800 p-4 rounded-lg">
				<x-lucide-box />
				{{ __('These might interest you') }}
			</div>
			<x-home.section id="favourite_categories" :categories="$categories" />

			<div class="w-full flex items-center gap-2 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight bg-white dark:bg-gray-800 p-4 mt-2 rounded-lg">
				<x-lucide-sparkles />
				{{ __('Will these spark your interest?') }}
			</div>
			@foreach($posts as $post)
				<x-posts.post class="mb-3" :post="$post" />
			@endforeach
			{{ $posts->links() }}
		</div>
	</div>
</x-master-layout>
