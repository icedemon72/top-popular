@section('title', __('Edit a tag'))
@section('head')
	<link href="{{ asset('vendor/bladewind/css/animate.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />
	<script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>
@endsection


<x-admin-layout>
	<x-slot name="header">
		<div class="flex w-full justify-center">
			<h2 class="w-full flex gap-2 items-center md:w-4/5 lg:w-3/5 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight bg-white dark:bg-gray-800 p-4 rounded-lg">
				<x-lucide-tag />
				{{ __('Edit a tag') }}
			</h2>
		</div>
	</x-slot>

	<div class="w-full flex justify-center">
		<form class="w-full md:w-4/5 lg:w-3/5 bg-card rounded-lg p-4 mt-5" method="POST" action="{{ route('tag.update', $tag->id) }}">
			@method('PATCH')
			@csrf
			
			@if(session('edited'))
				<x-form.success>
					{{ __('Tag edited successfully!') }}
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

			<x-form.label text="{{ __('Tag name') }}" for="name"/>
			<x-form.input class="w-full mt-1" field="name" type="text" placeholder="Shoes, buckets, Team Fortress 2..." required :value="$tag->name" :error="$errors->has('name')" /> 

			<x-form.label class="mt-5 mb-1" :text="__('Categories')" for="categories" />
			
			<x-bladewind::select
				id="categories"
				name="categories"
				searchable="true"
				label_key="name"
				value_key="id"
				:selected_value="$selected"
				multiple="true"
				:placeholder="__('Select categories')"
				modular="true"
				:data="$categories"
				/> 
			<div class="flex justify-end gap-2">
				<x-form.cancel>
					<a href="{{ route('tag.index') }}">
						{{ __('Go back') }}
					</a>
				</x-form.cancel>
				<x-form.submit>{{ __('Edit tag') }}</x-form.submit>
			</div>
		</form>
	</div>
</x-admin-layout>
