@section('title', 'Contact')

@section('head')
	<link href="{{ asset('vendor/bladewind/css/animate.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />
	<script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>
@endsection

@php
	$categories = [
		['name' => 'Issue'],
		['name' => 'Suggestion'],
		['name' => 'Bug'],
		['name' => 'Request'],
		['name' => 'Other']
	];
@endphp

<x-master-layout>
	<x-slot name="header">
		<div class="flex w-full justify-center">
			<h2 class="w-full md:w-4/5 lg:w-3/5 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight bg-white dark:bg-gray-800 p-4 rounded-lg">
					{{ __('Contact') }}
			</h2>
		</div>
	</x-slot>

	<div class="w-full flex justify-center">
		<div class="w-full md:w-4/5 lg:w-3/5 bg-card mt-5 rounded-lg text-main p-4">
			<form method="POST" action="{{ route('message.store') }}">
				@csrf
				<div class="text-main mb-7">
					<p class="text-2xl font-bold uppercase">{{ __('Contact us') }}</p>
					<p class="">{{ __('We\'d appreciate your feedback.') }}</p>
				</div>

				@if ($errors->any())
					<x-form.error>
						<ul>
								@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
								@endforeach
						</ul>
					</x-form.error>
				@endif

				<x-form.label text="{{ __('Title') }}" />
				<x-form.input class="w-full block mt-1 mb-3" field="title" value="{{ old('title') }}" :error="$errors->has('title')" placeholder="{{ __('This function needs to be changed') }}" required />

				<x-form.label text="{{ __('Message') }}" />
				<x-form.textarea class="w-full block mt-1 mb-5" field="body" :error="$errors->has('body')" placeholder="{{ __('I noticed something off on your site') }}">{{ old('body') }}</x-form.textarea>

				<x-form.label class="mb-1" text="{{ __('Category') }}" />
				<x-bladewind::select 
						id="category"
						required="true"
						name="category"
						selected_value="{{ request('category') }}"
						searchable="true"
						label_key="name"
						value_key="name"
						:placeholder="__('Select a category')"
						:data="$categories" />
				<div class="flex justify-end mt-5">
					<x-form.submit>{{ __('Send us a message!') }}</x-form.submit>
				</div>
			</form>
		</div>
	</div>
</x-master-layout>