@section('title', 'Home')

<x-master-layout>
    <x-slot name="header">
		<div class="flex w-full justify-center">
			<h2 class="w-full md:w-4/5 lg:w-3/5 flex items-center gap-2 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight bg-white dark:bg-gray-800 p-4 rounded-lg">
				<x-lucide-home />
				{{ __('Welcome to Top Popular Forum :)') }}
			</h2>
		</div>
	</x-slot>
</x-master-layout>
