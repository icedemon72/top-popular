@section('title', __('Create category'))
@section('head')
	<link href="{{ asset('vendor/bladewind/css/animate.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />
	<script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>
@endsection


<x-admin-layout>
	<x-slot name="header">
		<div class="flex w-full justify-center">
			<h2 class="w-full flex gap-2 items-center md:w-4/5 lg:w-3/5 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight bg-white dark:bg-gray-800 p-4 rounded-lg">
				<x-lucide-package-open />
				{{ __('Create a category') }}
			</h2>
		</div>
	</x-slot>

	<div class="w-full flex justify-center">
		<form class="w-full md:w-4/5 lg:w-3/5 bg-card rounded-lg p-4 mt-5" method="POST" action="{{ route('category.store') }}" enctype="multipart/form-data">
			@csrf
			
			@if(session('success'))
				<x-form.success>
					{{ __('Category successfully added!') }}
				</x-form.success>
			@endif

			@if($errors->any())
				<x-form.error>
					<ul>
							@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
							@endforeach
					</ul>
				</x-form.error>
			@endif

			<x-form.label text="{{ __('Category name') }}" for="name"/>
			<x-form.input class="w-full mt-1 mb-5" field="name" type="text" placeholder="{{ __('Gaming, cooking, gardening...') }}" required :value="old('name')" :error="$errors->has('name')" /> 

			<span class="block text-sm text-label font-bold mb-1">Icon</span>
			<x-form.image-input field="icon" accept=".svg" text="Maximum file size: 1KB .svg" />

			@if(count($tags) > 0) 
				<x-form.label class="mt-5" :text="__('Tags')" for="tags" />
				<x-bladewind::select
					id="tags"
					name="tags"
					searchable="true"
					label_key="name"
					value_key="id"
					multiple="true"
					:placeholder="__('Select tags')"
					modular="true"
					:data="$tags" /> 
				@endif

				<div class="flex justify-end gap-2 mt-2">
				<x-form.cancel>
					<a href="{{ route('category.index') }}">
						{{ __('Go back') }}
					</a>
				</x-form.cancel>
				<x-form.submit>{{ __('Create new category') }}</x-form.submit>
			</div>
		</form>
	</div>
</x-admin-layout>
