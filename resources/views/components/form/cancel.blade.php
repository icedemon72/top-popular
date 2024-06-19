<button type="button" {{ $attributes->merge(['class' => 'inline-flex items-center px-4 py-2 border-2 border-gray-800 dark:border-white rounded-md font-semibold text-xs text-gray-800 dark:text-white dark:text-gray-800 uppercase tracking-widest hover:ring-2 focus:bg-card active:bg-main focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150']) }} aria-label="{{ __('Cancel button') }}">
	{{ $slot }}
</button>
