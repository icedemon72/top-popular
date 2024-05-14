<script>
	const changeSort = (query, select) => {
			let queryString = window.location.search;  
			let params = new URLSearchParams(queryString);  
			params.delete(query);  
			params.append(query, document.getElementById(select).value); 
			document.location.href = "?" + params.toString(); 
	}
</script>

@section('title', "Posts in $category->name")
@section('search', route('post.index', $category->id))

<x-master-layout>
	<x-slot name="header">
		<div class="flex w-full justify-center">
			<h2 class="w-full md:w-4/5 lg:w-3/5 flex items-center gap-2 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight bg-white dark:bg-gray-800 p-4 rounded-lg">
				<img class="w-5 h-5 dark:bg-slate-200 rounded-full" src="{{ asset("/storage/{$category->icon}") }}" alt="Selected category icon" />
				{{ $category->name }}
			</h2>
		</div>
	</x-slot>
	<div class="w-full flex justify-center mt-2">
		<div class="w-full md:w-4/5 lg:w-3/5 flex justify-end gap-3">
			<a class="p-1 px-3 border rounded-xl dark:border-slate-200 border-slate-800 bg-green-200 hover:bg-green-300 dark:bg-green-700 hover:dark:bg-green-600 flex items-center justify-center hover:shadow-md transition-all group" href="{{ route('post.create', $category->id) }}" class="flex items-center cursor-pointer p-2">
				<x-lucide-plus class="w-5 h-5 group-hover:animate-pulse transition-all" />
				<p class="font-bold text-main text-xs group-hover:animate-pulse">{{ __('Create a post') }}</p>
			</a>
			<div class="flex items-center p-2 gap-1 cursor-pointer rounded-xl border-2 border-transparent hover:dark:border-slate-200 hover:border-slate-800 transition-all group" onClick="document.getElementById('join').submit()">
				@if($fav)
					<x-lucide-star-off class="w-5 h-5 fill-red-500" />
					<p class="font-bold text-main text-xs">{{ __('Remove') }}</p>
				@else
					<x-lucide-star class="w-5 h-5 fill-yellow-500" />
					<p class="font-bold text-main text-xs">{{ __('To favs') }}</p>
				@endif
				<form class="hidden" id="join" action="{{ route('category.join', $category->id) }}" method="POST">
					@csrf
				</form>
			</div>
		</div>
	</div>
	<div class="w-full flex flex-col items-center justify-center mt-3">
		<div class="w-full md:w-4/5 lg:w-2/3 lg:grid grid-cols-1 md:grid-cols-10 gap-3">
			<section class="col-span-1 md:col-span-7">
				<form method="GET" class="flex items-center justify-between border-b-2 border-b-gray-500 mb-2 p-1 gap-2 ">
					<x-lucide-arrow-down-narrow-wide class="w-5 h-5 text-muted" />
					<div class="flex gap-2 items-center">
						<div class="flex items-center cursor-pointer bg-main rounded-xl">
							{{-- <select aria-label="{{ __('Sort posts') }}" id="select1" onChange="changeSort('sort', 'select1')" class="appearance-none bg-main text-xs text-muted p-2 cursor-pointer hover:bg-card rounded-xl">
								<option value="popular">{{ __('Popular') }}</option>
								<option value="new">{{ __('New') }}</option>
								<option value="top">{{ __('Top') }}</option>
							</select> --}}
							<x-bladewind.select  
								aria-label="Time select"
								id="sort"
								name="sort"
								placeholder="{{ __('Sort by...') }}"
								multiple="false"
								searchable="false" 
								data="manual" 
								selected_value="{{ request()->input('sort') ?? 'popular' }}"
							>
								<x-bladewind::select-item label="{{ __('Popular') }}" value="popular"  />
								<x-bladewind::select-item label="{{ __('New') }}" value="new"  />
								<x-bladewind::select-item label="{{ __('Top') }}" value="top"  />
							</x-bladewind.select>
						</div>	
						<div class="flex items-center cursor-pointer bg-main rounded-xl">
							<x-bladewind.select  
							aria-label="Time select"
							id="time"
							name="time"
							placeholder="{{ __('Select time...') }}"
							multiple="false"
							searchable="false" 
							data="manual" 
							selected_value="{{ request()->input('time') ?? 'month' }}"
							>
								<x-bladewind::select-item label="{{ __('Last week') }}" value="week"  />
								<x-bladewind::select-item label="{{ __('Last month') }}" value="month"  />
								<x-bladewind::select-item label="{{ __('Last year') }}" value="year"  />
								<x-bladewind::select-item label="{{ __('All time') }}" value="all"  />
							</x-bladewind.select>
							{{-- <select aria-label="{{ __('Filter posts based on date') }}" id="select2" onChange="changeSort('time', 'select2')" class="appearance-none bg-main text-xs text-muted p-2 cursor-pointer hover:bg-card rounded-xl">
								<option value="today">{{ __('Today') }}</option>
								<option value="week">{{ __('This week') }}</option>
								<option value="month">{{ __('This month') }}</option>
								<option value="year">{{ __('This year') }}</option>
								<option value="all">{{ __('All') }}</option>
							</select> --}}
						</div>
						<button type="submit flex items-center" aria-label="{{ __('Apply filters') }}" title="{{ __('Apply') }}">
							<x-lucide-send-horizontal class="w-9 h-9 mb-3 rounded-full bg-card p-2 transition-all hover:bg-main" />
						</button>
					</div>
				</form>
				@foreach ($posts as $post)
					<x-posts.post class="mb-3" 
						:post="$post"
					/>
				@endforeach
				<div class="mt-2">
					{{ $posts->withQueryString()->links() }}
				</div>
			</section>
			@if(count($posts) == 0)
				<div class="col-span-1 md:col-span-7 w-full flex p-2 text-muted">
					<span class="bg-card flex items-center w-full h-12 p-2 rounded-lg text-muted gap-1">
						{{ __('Huh, there seems to be no posts...') }} 
						<a class="underline hover:text-main" href="{{ route('post.create', $category->id) }}">{{ __('maybe add one?') }}</a>
					</span>
				</div>
			@endif
			<div class="w-full h-[600px] overflow-y-auto relative hidden lg:flex lg:col-span-3 bg-card rounded-lg shadow-sm">
				<div class="flex-grow">
					<div class="flex flex-col mx-6 pb-2 items-center flex-grow justify-center mt-4 border-b-2 border-b-gray-800 dark:border-b-gray-400">
						<div class="dark:bg-slate-300 p-6 rounded-full">
							<img class="w-8 h-8" src="{{ asset("/storage/{$category->icon}") }}" alt="Selected category icon" />
						</div>
						<h2 class="text-2xl text-muted">{{ $category->name }}</h2>
					</div>
					<div class="mx-6 mt-2">
						<h3 class="text-muted text-sm font-semibold uppercase">{{ __('Rules') }}</h3>
						<x-posts.rules />
					</div>
				</div>
			</div>
		</div>
	</div>
</x-master-layout>
