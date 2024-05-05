@section('title', 'Categories')

@php
	$latestCategory = __('There are no categories...');

	if(sizeof($categories)) {
		$latestCategory = $categories[0]->name;
	}
@endphp
<script type="text/javascript">
	document.addEventListener('DOMContentLoaded', function() {
		handleModal("{{ route('category.destroy', ':id') }}");
		sortTable();
		showChevron();
	});
</script>
<x-admin-layout>
	<x-modals.delete text="{{ __('Are you sure you want to delete this category?') }}"  />
	<x-slot name="header">
		<div class="flex w-full justify-center">
			<div class="w-full flex gap-2 items-center justify-between md:w-4/5 lg:w-3/5 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight bg-white dark:bg-gray-800 p-4 rounded-lg">
				<h2 class="flex items-center gap-2">
					<x-lucide-box />
					{{ __('Categories') }}
				</h2>
				<div>
					<a href="{{ route('category.create') }}" class="flex items-center gap-2 bg-green-200 hover:bg-green-300 dark:bg-green-700 hover:dark:bg-green-600 p-2 text-xs uppercase font-bold rounded-lg border dark:border-gray-700 cursor-pointer transition-all">
						<x-lucide-circle-plus />
						{{ __('Add a category') }}
					</a>
				</div>
			</div>
		</div>
	</x-slot>

	<div class="w-full flex flex-col items-center justify-center mt-5">
		<div class="w-full md:w-4/5 lg:w-3/5">
			<div class="grid grid-cols-1 lg:grid-cols-3 flex-grow gap-2">
				<x-admin.card title="{{ __('Latest category') }}" :data="$latestCategory" />
				<x-admin.card title="{{ __('Top Popular category') }}" :data="$latestCategory" />
				<x-admin.card title="{{ __('Add a category goes here') }}"></x-admin.card>
			</div>
		</div>

		<div class="flex w-full md:w-4/5 lg:w-4/5 justify-end items-center">
			{{-- <div x-on:click="open = !open" x-bind:class="open ? 'bg-card shadow-sm' : ''" class="flex gap-2 rounded-lg shadow-sm text-main	hover:bg-card p-2 cursor-pointer">
				<x-lucide-filter />
				{{ __('Filters') }}
			</div> --}}
			<form class="flex" method="GET">
				<x-form.search-input class="bg-card" field="search" placeholder="{{ __('Search categories...') }}" value="{{ request()->input('search') }}" />
			</form>
		</div>

		<div class="relative w-full md:w-4/5 lg:w-4/5 overflow-x-auto shadow-md sm:rounded-lg">
			<table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
				<thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
					<tr x-data="{ sort: false, field: '', asc: false }">
            <x-admin.th query="id">{{ __('ID') }}</x-admin.th>
            <x-admin.th query="name">{{ __('Name') }}</x-admin.th>
            <th class="px-6 py-4">{{ __('Icon') }}</th>
           	<x-admin.th query="posts">{{ __('Posts') }}</x-admin.th>
            <th class="px-6 py-4">{{ __('Actions') }}</th>
          </tr>
				</thead>
				<tbody>
					@foreach($categories as $category)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
              <td class="px-6 py-4">{{ $category->id }}</td>
              <td class="px-6 py-4" title="{{ $category->name }}">
								@if (strlen($category->name) > 16)
									{{ substr($category->name, 0, 13) }}...
								@else 
									{{ $category->name }}
								@endif
							</td>
              <td class="px-6 py-4">
								<img class="dark:bg-slate-200 dark:rounded-full w-7 h-7" alt="{{ $category->name }} icon" src="{{ asset("storage/".$category->icon) }}" />
							</td>
              <td class="px-6 py-4">
								{{ $category->posts_count }}
							</td>
							<td class="px-6 py-4 flex items-center gap-2" x-data="{ open: false }">
								<a class="cursor-pointer rounded-full p-1 transition-all hover:bg-main group" href="{{ route('category.edit', ['category' => $category->id]) }}" title="{{ __('Edit') }}">
                  <x-lucide-pencil class="group-hover:scale-75 group-hover:-rotate-45 transition-all" />
                </a>
								<div class="modalTrigger cursor-pointer rounded-full p-1 transition-all hover:bg-red-500 group" title="{{ __('Delete the post') }}" data-trigger="{{$category->id}}">
                  <x-lucide-trash-2 class="group-hover:scale-75 transition-all" />
                </div>
							</td>
            </tr>
          @endforeach
				</tbody>
			</table>
		</div>
		
		<div class="mt-2">
			{{ $categories->withQueryString()->links() }}
		</div>

	</div>
</x-admin-layout>
