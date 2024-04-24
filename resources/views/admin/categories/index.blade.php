@section('title', 'Categories')

@php
	$latestCategory = __('There are no categories...');

	if(sizeof($categories)) {
		$latestCategory = $categories[0]->name;
	}
@endphp

<x-admin-layout>
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

		<div class="w-full md:w-4/5 lg:w-4/5 mt-7">
			<x-admin.table 
				:cols="[__('ID'), __('Name'), __('Icon'), __('Created At'), __('Updated At'), __('Actions')]" 
				:types="['id' => 'string', 'name' => 'string', 'created_at' => 'date', 'updated_at' => 'date', 'icon' => 'icon']"
				:actions="['edit']"
				route="category"
				:data="$categories"
			/>
		</div>
	</div>
</x-admin-layout>
