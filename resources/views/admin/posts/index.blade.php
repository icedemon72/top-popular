@section('title', 'Posts')

<script type="text/javascript">
	document.addEventListener('DOMContentLoaded', function() {
		handleModal("{{ route('post.destroy', ':id') }}");
		sortTable();
		showChevron();
	});
</script>

<x-admin-layout>
	<x-modals.delete text="{{ __('Are you sure you want to delete this post?') }}" />
	<x-slot name="header">
		<div class="flex w-full justify-center">
			<h2 class="w-full flex gap-2 items-center md:w-4/5 lg:w-3/5 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight bg-white dark:bg-gray-800 p-4 rounded-lg">
				<x-lucide-dock />
				{{ __('Posts') }}
			</h2>
		</div>
	</x-slot>

	<div x-data="{ open: false }" class="w-full flex flex-col items-center justify-center mt-7">
		<div class="flex w-full md:w-4/5 lg:w-4/5 justify-between items-center">
			<div x-on:click="open = !open" x-bind:class="open ? 'bg-card shadow-sm' : ''" class="flex gap-2 rounded-lg shadow-sm text-main	hover:bg-card p-2 cursor-pointer">
				<x-lucide-filter />
				{{ __('Filters') }}
			</div>
			<form class="flex items-center" method="GET">
				<x-form.search-input class="bg-card" field="search" placeholder="{{ __('Search posts...') }}" value="{{ request()->input('search') }}" />
			</form>
		</div>

		<div x-collapse x-cloak x-show="open" class="w-full flex md:w-4/5 lg:w-4/5 mt-2">
			<form id="filters" class="w-full">
				<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-2">
					<div class="col-span-1">
						<p class="text-muted">{{ __('Category') }}</p>
						@foreach($categories as $category)
							<x-form.checkbox  field="category[]" value="{{ $category->id }}" text="{{ $category->name }} ({{ $category->posts_count }})" />
						@endforeach
					</div>
					<div class="col-span-1">
						<p class="text-muted">{{ __('Status') }}</p>
							<x-form.checkbox type="radio" value="1" field="archived" text="{{ __('Archived')}}" />
							<x-form.checkbox type="radio" value="false" field="archived" text="{{ __('Not archived')}}" />
					</div>
					<div class="col-span-1">
						<p class="text-muted">{{ __('Date') }}</p>
						<x-form.checkbox type="radio" value="today" field="time" text="{{ __('Last 24h')}}" />
						<x-form.checkbox type="radio" value="week" field="time" text="{{ __('Last week')}}" />
						<x-form.checkbox type="radio" value="month" field="time" text="{{ __('Last month')}}" />
						<x-form.checkbox type="radio" value="year" field="time" text="{{ __('Last year')}}" />
					</div>
				</div>
				
				<x-form.submit class="mt-1">{{ __('Apply filters') }}</x-form.submit>
			</form>
		</div>

		<div class="relative w-full md:w-4/5 lg:w-4/5 mt-2 overflow-x-auto shadow-md sm:rounded-lg">
			<table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
				<thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
					<tr x-data="{ sort: false, field: '', asc: false }">
            {{-- <th class="px-6 py-4 flex items-center gap-1" x-on:click="sort = true; field = 'ID'; asc = !asc;">
							{{ __('ID') }}
							<div x-show="sort && field === 'ID'">
								<x-lucide-chevron-down x-show="asc" class="w-3 h-3" />
								<x-lucide-chevron-up x-show="!asc" class="w-3 h-3" />
							</div>
						</th> --}}
						<x-admin.th query="id">{{ __('ID') }}</x-admin.th>
						<x-admin.th query="title">{{ __('Title') }}</x-admin.th>
            {{-- <th class="px-6 py-4">{{ __('Title') }}</th> --}}
            <x-admin.th query="poster">{{ __('Poster') }}</x-admin.th>
            <x-admin.th query="category">{{ __('Category') }}</x-admin.th>
            <x-admin.th query="comments">{{ __('Comments') }}</x-admin.th>
            <th class="px-6 py-4">{{ __('Actions') }}</th>
          </tr>
				</thead>
				<tbody>
					@foreach($posts as $post)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
              <td class="px-6 py-4">{{ $post->id }}</td>
              <td class="px-6 py-4" title="{{ $post->title }}">
								@if (strlen($post->title) > 16)
									{{ substr($post->title, 0, 13) }}...
								@else 
									{{ $post->title }}
								@endif
							</td>
              <td class="px-6 py-4 underline">
								<a class="flex items-center gap-2 hover:text-main"href="{{ route('user.show', $post->poster->username) }}">
									<img class="w-4 h-4 rounded-full" src="{{ asset("storage/".$post->poster->image) }}" alt="{{ $post->poster->username }}'s profile picture"/>
									{{ $post->poster->username }}
								</a>
							</td>
              <td class="px-6 py-4">{{ $post->category->name }}</td>
              <td class="px-6 py-4">{{ $post->comments_count }}</td>
							<td class="px-6 py-4 flex items-center gap-2">
								<a class="cursor-pointer rounded-full p-1 transition-all hover:bg-main group" href="{{ route('post.edit', ['category' => $post->category_id, 'post' => $post->id]) }}" title="{{ __('Edit') }}">
                  <x-lucide-pencil class="group-hover:scale-75 group-hover:-rotate-45 transition-all" />
                </a>
								<div class="modalTrigger cursor-pointer rounded-full p-1 transition-all hover:bg-red-500 group" title="{{ __('Delete the post') }}" data-trigger="{{ $post->id }}">
                  <x-lucide-trash-2 class="group-hover:scale-75 transition-all" />
                </div>
								<a class="cursor-pointer rounded-full p-1 transition-all hover:bg-main group" href="{{ route('post.show', ['category' => $post->category_id, 'post' => $post->id]) }}" title="{{ __('See the post') }}">
									<x-lucide-circle-arrow-right class="group-hover:scale-75 transition-all group-hover:translate-x-1" />
								</a>
							</td>
              {{-- <td class="px-6 py-4 flex items-center gap-2">
                <a href="{{ route('user.edit', $user->username) }}" title="{{ __('Edit') }}">
                  <x-lucide-pencil />
                </a>
                <a href="{{ route('user.show', $user->username) }}" title="{{ __('Profile') }}">
                  <x-lucide-user />
                </a>
                <a href="#" title="{{ __('Profile') }}">
                  <x-lucide-trash-2 />
                </a>
              </td> --}}
            </tr>
          @endforeach
				</tbody>
			</table>
		</div>
		<div class="mt-2">
			{{ $posts->withQueryString()->links() }}
		</div>
	</div>

	{{-- <script>
		document.getElementById("filters").addEventListener("submit", function (e) {
			e.preventDefault();
			getData(e.target);
		});
	
		function getData(form) {
			let formData = new FormData(form);
			let filters = {};

			for (let pair of formData.entries()) {
				[ key, op ] = pair[0].split(' ');

				if(filters[key]) {
					filters[key] = [ ...filters[key], { [op]: pair[1] } ]; 
				} else {
					filters[key] = [{ [op]: pair[1] }];
				}
			}

			let joined = Object.keys(filters).map((key) => {
				return {
					$or: [
						filters[key].map((elem) => ({
							[key]: elem
						}))
					]	
				}
			});

			const query = qs.stringify({
				filters: { 
					'$and': [ ...joined ]
				}
			}, {
				encodeValuesOnly: true, // prettify URL
			});

			let queryString = window.location.search;  
			const searchParams = new URLSearchParams(queryString);
			let page = 1;
			if(searchParams.has('page')) {
				page = searchParams.get('page');
			}

			window.location.search = query;

		}
	
	</script> --}}

</x-admin-layout>