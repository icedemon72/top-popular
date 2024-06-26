@section('title', __('Create a post'))

@section('head')
	<link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />
@endsection

<x-master-layout>
	<x-slot name="header">
		<div class="flex w-full justify-center">
			<h2 class="w-full md:w-4/5 lg:w-3/5 flex items-center gap-2 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight bg-white dark:bg-gray-800 p-4 rounded-lg">
				<x-lucide-plus />
				{{ __('Create a post') }}
			</h2>
		</div>
	</x-slot>

	<div class="flex w-full justify-center mt-5">
		<div class="w-full md:w-4/5 lg:w-3/5 bg-card p-4">
			<form method="POST" action={{ route('post.store') }}>
				@csrf
					<x-form.label class="mb-1" for="title" text="{{ __('Title') }}" />
					<x-form.input class="w-full md:w-3/4 lg:w-1/2" placeholder="I noticed something lately..." type="text" field="title" />
					
					<x-form.label class="mt-5 mb-1" for="body" text="{{ __('Post body') }}" />
					{{-- <x-form.quill-editor field="body"/> --}}
					<x-form.textarea class="w-full"  field="body" placeholder="Say what's on your mind..."/>
					<div class="w-full text-end text-muted underline hover:no-underline hover:text-main">
						<a target="_blank" href="https://www.markdownguide.org/cheat-sheet/">Need help with markdown?</a>
					</div>
					<x-form.label class="mt-5 mb-1" for="category" text="{{ __('Category') }}" />
					<x-bladewind::select 
						id="category"
						required="true"
						name="category"
						selected_value="{{ request('category') }}"
						searchable="true"
						label_key="name"
						value_key="id"
						:placeholder="__('Select a category')"
						:data="$categories" />

					@if(count($tags) > 0)
						<x-form.label class="mt-5 mb-1" for="tags" text="{{ __('Tags') }}" />
						<x-bladewind::select 
							id="tags"
							required="true"
							name="tags"
							searchable="true"
							multiple="true"
							modular="true"
							label_key="name"
							value_key="id"
							:placeholder="__('Select tags')"
							:data="$tags" />
					@endif
				<div class="flex justify-end">
					<x-form.submit>{{ __('Create a post') }}</x-form.submit>
				</div>
			</form>
		</div>
	</div>
</x-master-layout>