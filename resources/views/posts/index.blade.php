<script>
	const changePopularity = () => {
			let queryString = window.location.search;  // get url parameters
			let params = new URLSearchParams(queryString);  // create url search params object
			params.delete('t');  // delete city parameter if it exists, in case you change the dropdown more then once
			params.append('t', document.getElementById("select1").value); // add selected city
			document.location.href = "?" + params.toString(); // refresh the page with new url
	}

	const getParamValue = (param, fallback) => {
		let queryString = window.location.search;  // get url parameters
		let params = new URLSearchParams(queryString);  
		return params.get(param) || fallback;
	}

	document.getElementById('select1').value = getParamValue('t', 'popular');

</script>


<x-master-layout>
	<x-slot name="header">
		<div class="flex w-full justify-center">
			<h2 class="w-full md:w-4/5 lg:w-3/5 flex items-center gap-1 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight bg-gray-400 dark:bg-gray-800 p-4 rounded-lg">
				<img class="w-5 h-5" src="{{ asset("/storage/{$category->icon}") }}" />
				{{ $category->name }}
			</h2>
		</div>
	</x-slot>
	<div class="w-full flex justify-center mt-2">
		<div class="w-full md:w-4/5 lg:w-3/5 flex justify-end gap-3">
			<a href="{{ route('post.create', $category->id) }}" class="flex items-center cursor-pointer p-2">
				<x-lucide-plus class="w-5 h-5 gap-1" />
				<p class="font-bold text-main text-xs">{{ __('Create a post') }}</p>
			</a>
			<div class="flex items-center p-2 gap-1">
				<x-lucide-star class="w-5 h-5" />
				<p class="font-bold text-main text-xs">{{ __('To favs') }}</p>
			</div>
		</div>
	</div>
	<div class="w-full flex flex-col items-center justify-center mt-3">
		@if(count($posts) > 0)
			<div class="w-full md:w-4/5 lg:w-2/3 lg:grid grid-cols-1 md:grid-cols-10 gap-3">
				<section class="col-span-1 md:col-span-7">
					<div class="flex items-center border-b-2 border-b-gray-500 mb-2 p-1">
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
					@foreach ($posts as $post)
						<x-posts.post class="mb-3" 
							:post="$post"
						/>
					@endforeach
				</section>
				<div class="w-full h-[500px] relative hidden lg:flex lg:col-span-3">
					<div class="flex-grow bg-card rounded-lg">
						Hello
					</div>
				</div>
			</div>
		@else
			<div class="bg-card w-full flex md:w-4/5 lg:w-3/5 p-2 text-muted rounded-lg gap-1">
				{{ __('Huh, there seems to be no posts...') }} 
				<a class="underline hover:text-main" href="{{ route('post.create', $category->id) }}">{{ __('maybe add one?') }}</a>
			</div>
		@endif
	</div>
</x-master-layout>
