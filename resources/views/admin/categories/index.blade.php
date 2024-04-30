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
	});
</script>
<x-admin-layout>
	<x-modals.delete text="{{ __('Are you sure you want to delete this category?') }}"  />
	<x-slot name="header">
		<div class="flex w-full justify-center">
			<h2 class="w-full flex gap-2 items-center md:w-4/5 lg:w-3/5 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight bg-white dark:bg-gray-800 p-4 rounded-lg">
				<x-lucide-box />
				{{ __('Categories') }}
			</h2>
		</div>
	</x-slot>

	<div class="w-full flex flex-col items-center justify-center mt-5">
		<div class="w-full md:w-4/5 lg:w-3/5">
			<div class="grid grid-cols-1 lg:grid-cols-3 flex-grow gap-2">
				<x-admin.card title="{{ __('Latest category') }}" :data="$latestCategory" />
				<x-admin.card title="{{ __('Top Popular category') }}" :data="$latestCategory" />
				<x-admin.card title="{{ __('Tags') }}"></x-admin.card>
			</div>
		</div>
		<div class="w-full md:w-4/5 lg:w-3/5 mt-5 p-8 cursor-pointer bg-green-200 rounded-lg">
			<a href="{{ route('category.create') }}" class="w-full h-full flex flex-col gap-1 justify-center items-center">
				<x-lucide-circle-plus />
				<p>{{ __('Add category') }}</p>
			</a>
		</div>

		<div class="relative w-full md:w-4/5 lg:w-4/5 mt-2 overflow-x-auto shadow-md sm:rounded-lg">
			<table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
				<thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
					<tr>
            <th class="px-6 py-4">{{ __('ID') }}</th>
            <th class="px-6 py-4">{{ __('Name') }}</th>
            <th class="px-6 py-4">{{ __('Icon') }}</th>
            <th class="px-6 py-4">{{ __('Posts') }}</th>
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
