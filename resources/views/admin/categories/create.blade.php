@section('title', __('Create category'))
@section('head')
	<link href="{{ asset('vendor/bladewind/css/animate.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />
	<script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>
@endsection


<x-admin-layout>
	<x-slot name="header">
		<div class="flex w-full justify-center">
			<h2 class="w-full flex gap-2 items-center md:w-4/5 lg:w-3/5 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight bg-gray-400 dark:bg-gray-800 p-4 rounded-lg">
				<x-lucide-package-open />
				{{ __('Create category') }}
			</h2>
		</div>
	</x-slot>

	<div class="w-full flex justify-center">
		<form class="w-full md:w-4/5 lg:w-3/5 bg-card rounded-lg p-4 mt-5" method="POST" action="{{ route('category.store') }}">
			@csrf

			<x-form.label text="{{ __('Category name') }}" for="name"/>
			<x-form.input class="w-full mt-1" field="name" type="text" placeholder="Gaming"  /> 

			<x-form.label class="mt-5 mb-1" :text="__('Tags')" for="tags" />
			<x-bladewind::select
				id="tags"
				name="tags"
				searchable="true"
				label_key="name"
				value_key="id"
				multiple="true"
				:data="$tags" /> 
			<x-form.submit>{{ __('Create new category') }}</x-form.submit>
		</form>
	</div>
</x-admin-layout>
