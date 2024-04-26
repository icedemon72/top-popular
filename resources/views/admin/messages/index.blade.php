@section('title', 'Messages')

<x-admin-layout>
  <x-slot name="header">
		<div class="flex w-full justify-center">
			<h2 class="w-full flex gap-2 items-center md:w-4/5 lg:w-3/5 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight bg-white dark:bg-gray-800 p-4 rounded-lg">
				<x-lucide-mails />
				{{ __('Messages') }}
			</h2>
		</div>
	</x-slot>

	<div class="w-full flex flex-col items-center justify-center mt-7">
		<div class="flex w-full md:w-4/5 lg:w-4/5 justify-between items-center">
			@foreach ($messages as $message)
				{{ $message->body }}
			@endforeach
		</div>
	</div>
</x-admin-layout>