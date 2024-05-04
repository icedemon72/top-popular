@section('title', 'Tags')

@php
	$latestCategory = __('There are no tags...');

	if(sizeof($tags)) {
		$latestCategory = $tags[0]->name;
	}
@endphp

<script type="text/javascript">
	document.addEventListener('DOMContentLoaded', function() {
		handleModal("{{ route('tag.destroy', ':id') }}");
		sortTable();
		showChevron();
	});
</script>

<x-admin-layout>
	<x-modals.delete text="{{ __('Are you sure you want to delete this tag?') }}"  />
	<x-slot name="header">
		<div class="flex w-full justify-center">
			<h2 class="w-full flex gap-2 items-center md:w-4/5 lg:w-3/5 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight bg-white dark:bg-gray-800 p-4 rounded-lg">
				<x-lucide-tag />
				{{ __('Tags') }}
			</h2>
		</div>
	</x-slot>

	<div class="w-full flex flex-col items-center justify-center mt-7">
		<div class="w-full md:w-4/5 lg:w-3/5">
			<div class="grid grid-cols-1 lg:grid-cols-3 flex-grow gap-2">
				<x-admin.card title="{{ __('Latest tag') }}" :data="$latestCategory" />
				<x-admin.card title="{{ __('Top Popular tag') }}" :data="$latestCategory" />
				<x-admin.card title="{{ __('Categories') }}"></x-admin.card>
			</div>
		</div>
		<div class="w-full md:w-4/5 lg:w-3/5 mt-5 p-8 cursor-pointer bg-green-200 rounded-lg">
			<a href="{{ route('tag.create') }}" class="w-full h-full flex flex-col gap-1 justify-center items-center">
				<x-lucide-circle-plus />
				<p>{{ __('Add tag') }}</p>
			</a>
		</div>

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
	
			<div x-collapse x-cloak x-show="open" class="w-full flex md:w-4/5 lg:w-4/5">
				<form id="filters" class="w-full">
					<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-2">
						
					</div>
					<x-form.submit class="mt-1">{{ __('Apply filters') }}</x-form.submit>
				</form>
			</div>
		</div>


		<div class="relative w-full md:w-4/5 lg:w-4/5 mt-1 overflow-x-auto shadow-md sm:rounded-lg">
			<table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
				<thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
					<tr x-data="{ sort: false, field: '', asc: false }">
            <x-admin.th query="id">{{ __('ID') }}</x-admin.th>
						<x-admin.th query="name">{{ __('Name') }}</x-admin.th>
            <th class="px-6 py-4">{{ __('Category') }}</th>
            <th class="px-6 py-4">{{ __('Actions') }}</th>
          </tr>
				</thead>
				<tbody>
					@foreach($tags as $tag)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
              <td class="px-6 py-4">{{ $tag->id }}</td>
              <td class="px-6 py-4" title="{{ $tag->name }}">
								@if (strlen($tag->name) > 16)
									{{ substr($tag->name, 0, 13) }}...
								@else 
									{{ $tag->name }}
								@endif
							</td>
              <td class="px-6 py-4">
								@if(count($tag->categories) <= 3)
									@foreach($tag->categories as $category)
										{{ $category->name }}
									@endforeach
								@else
									{{ $tag->categories[0]->name }}, {{ $tag->categories[1]->name }}, {{ $tag->categories[2]->name }}...
								@endif
							</td>
							<td class="px-6 py-4 flex items-center gap-2">
								<a class="cursor-pointer rounded-full p-1 transition-all hover:bg-main group" href="{{ route('tag.edit', ['tag' => $tag->id]) }}" title="{{ __('Edit') }}">
                  <x-lucide-pencil class="group-hover:scale-75 group-hover:-rotate-45 transition-all" />
                </a>
								<a class="modalTrigger cursor-pointer rounded-full p-1 transition-all hover:bg-red-500 group" href="#" title="{{ __('Delete the post') }}" data-trigger="{{ $tag->id }}">
                  <x-lucide-trash-2 class="group-hover:scale-75 transition-all" />
                </a>
							</td>
            </tr>
          @endforeach
				</tbody>
			</table>
		</div>
		<div class="mt-2">
			{{ $tags->withQueryString()->links() }}
		</div>
	</div>
</x-admin-layout>
