@section('title', 'Tags')

@php
	$latestCategory = __('There are no tags...');

	if(sizeof($tags)) {
		$latestCategory = $tags[0]->name;
	}
@endphp

<x-admin-layout>
	<x-slot name="header">
		<div class="flex w-full justify-center">
			<h2 class="w-full flex gap-2 items-center md:w-4/5 lg:w-3/5 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight bg-white dark:bg-gray-800 p-4 rounded-lg">
				<x-lucide-tag />
				{{ __('Tags') }}
			</h2>
		</div>
	</x-slot>

	<div class="w-full flex flex-col items-center justify-center mt-5">
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

		<div class="w-full md:w-4/5 lg:w-4/5 mt-7">
			<x-admin.table 
				:cols="[__('ID'), __('Name'), __('Created By'), __('Created At'), __('Updated At'), __('Actions')]" 
				:types="['id' => 'string', 'name' => 'string', 'created_at' => 'date', 'updated_at' => 'date', 'created_by' => 'link']"
				:actions="['edit', 'delete']"
				route="tag"
				:data="$tags"
			/>
		</div>
	</div>
</x-admin-layout>
