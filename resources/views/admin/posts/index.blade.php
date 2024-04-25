@section('title', 'Posts')

<x-admin-layout>
	<x-slot name="header">
		<div class="flex w-full justify-center">
			<h2 class="w-full flex gap-2 items-center md:w-4/5 lg:w-3/5 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight bg-white dark:bg-gray-800 p-4 rounded-lg">
				<x-lucide-dock />
				{{ __('Posts') }}
			</h2>
		</div>
	</x-slot>

	<div class="w-full flex flex-col items-center justify-center mt-7">
		<div class="flex w-full md:w-4/5 lg:w-4/5 justify-between items-center">
			<div class="flex gap-2 rounded-lg shadow-sm text-main	hover:bg-card p-2 cursor-pointer">
				<x-lucide-filter />
				{{ __('Filters') }}
			</div>
			<form class="flex" method="GET">
				<x-form.search-input class="bg-card" field="search" placeholder="{{ __('Search posts...') }}" />
			</form>
		</div>

		<div class="relative w-full md:w-4/5 lg:w-4/5 mt-2 overflow-x-auto shadow-md sm:rounded-lg">
			<table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
				<thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
					<tr>
            <th class="px-6 py-4">{{ __('ID') }}</th>
            <th class="px-6 py-4">{{ __('Title') }}</th>
            <th class="px-6 py-4">{{ __('Poster') }}</th>
            <th class="px-6 py-4">{{ __('Category') }}</th>
            <th class="px-6 py-4">{{ __('Comments') }}</th>
            <th class="px-6 py-4">{{ __('Actions') }}</th>
          </tr>
				</thead>
				<tbody>
					@foreach($posts as $post)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
              <td class="px-6 py-4">{{ $post->id }}</td>
              <td class="px-6 py-4" title="{{ $post->title }}">
								@if (strlen($post->title) > 16)
									{{ substr($post->title, 0, 13) }}...
								@else 
									{{ $post->title }}
								@endif
							</td>
              <td class="px-6 py-4 underline">
								<a href="{{ route('user.show', $post->username) }}">{{ $post->username }}</a>
							</td>
              <td class="px-6 py-4">{{ $post->category }}</td>
              <td class="px-6 py-4">{{ $post->comments }}</td>
							<td class="px-6 py-4 flex items-center gap-2">
								<a href="{{ route('post.edit', ['category' => $post->category_id, 'post' => $post->id]) }}" title="{{ __('Edit') }}">
                  <x-lucide-pencil />
                </a>
								<a href="#" title="{{ __('Delete the post') }}">
                  <x-lucide-trash-2 />
                </a>
								<a href="{{ route('post.show', ['category' => $post->category_id, 'post' => $post->id]) }}" title="{{ __('See the post') }}">
									<x-lucide-circle-arrow-right />
								</a>
							</td>
              {{-- <td class="px-6 py-4 flex items-center gap-2">
                <a href="{{ route('user.edit', $user->username) }}" title="{{ __('Edit') }}">
                  <x-lucide-pencil />
                </a>
                <a href="{{ route('user.show', $user->username) }}" title="{{ __('Profile') }}">
                  <x-lucide-user />
                </a>
                <a href="#" title="{{ __('Profile') }}">
                  <x-lucide-trash-2 />
                </a>
              </td> --}}
            </tr>
          @endforeach
				</tbody>
			</table>
		</div>
	</div>

</x-admin-layout>