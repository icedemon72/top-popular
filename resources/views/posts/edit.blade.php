@section('title', 'Edit a post')

@section('head')
  <link href="{{ asset('vendor/bladewind/css/animate.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />
  <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>
@endsection

<x-master-layout>
  <x-slot name="header">
		<div class="flex w-full justify-center">
			<h2 class="w-full md:w-4/5 lg:w-3/5 flex items-center gap-2 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight bg-white dark:bg-gray-800 p-4 rounded-lg border border-main">
				<x-lucide-pen />
				{{ __('Edit a post') }}
			</h2>
		</div>
	</x-slot>

	<div class="flex w-full justify-center mt-5">
		<div class="w-full md:w-4/5 lg:w-3/5 bg-card p-4 rounded-lg border border-main">
			<form action="{{ route('post.update', $post->id) }}" method="POST">
        @method('PATCH')
				@csrf
        <x-form.label class="mb-1" for="title" text="{{ __('Title') }}" />
        <x-form.input class="w-full md:w-3/4 lg:w-1/2" value="{{ $post->title }}" placeholder="I noticed something lately..." type="text" field="title" />
        
        <x-form.label class="mt-5 mb-1" for="body" text="{{ __('Post body') }}" />

				
        {{-- <x-form.quill-editor field="body"/> --}}
        <x-form.textarea class="w-full"  field="body" placeholder="Say what's on your mind...">{{ $post->body }}</x-form.textarea>
				<div class="w-full text-end text-muted underline hover:no-underline hover:text-main">
					<a target="_blank" href="https://www.markdownguide.org/cheat-sheet/">Need help with markdown?</a>
				</div>
        <x-form.label class="mt-5 mb-1" for="category" text="{{ __('Category') }}" />
        <x-bladewind::select 
          id="category"
          :required="(Auth::user()->role == 'admin' || Auth::user()->role == 'moderator') "
          name="category"
          selected_value="{{ request('category') }}"
          searchable="true"
          readonly="{{ !(Auth::user()->role == 'admin' || Auth::user()->role == 'moderator') }}"
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
            selected_value="{{ $selected }}"
            modular="true"
            label_key="name"
            value_key="id"
            :placeholder="__('Select tags')"
            :data="$tags" />
        @endif
        <div class="flex flex-grow justify-end items-center gap-3">
          <x-form.cancel>
            <a href="{{ route('post.show', ['post' => $post->id, 'category' => $post->category_id]) }}">Cancel</a>
          </x-form.cancel>
          <x-form.submit>{{ __('Edit post') }}</x-form.submit>
        </div>
			</form>
		</div>
	</div>
</x-master-layout>