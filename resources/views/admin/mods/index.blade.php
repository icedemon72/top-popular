@section('title', __('Moderators'))
<x-admin-layout>
	<x-slot name="header">
		<div class="flex w-full justify-center">
			<h2 class="w-full flex gap-2 items-center md:w-4/5 lg:w-3/5 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight bg-white dark:bg-gray-800 p-4 rounded-lg">
				<x-lucide-shield-plus />
				{{ __('Moderators') }}
			</h2>
		</div>
	</x-slot>

	<div class="w-full flex justify-center mt-7">
		<div class="relative w-full md:w-4/5 lg:w-4/5 mt-7 overflow-x-auto shadow-md sm:rounded-lg">
			<table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th class="px-6 py-4">{{ __('ID') }}</th>
            <th class="px-6 py-4">{{ __('Username') }}</th>
            <th class="px-6 py-4">{{ __('E-mail') }}</th>
            <th class="px-6 py-4">{{ __('Name') }}</th>
            <th class="px-6 py-4">{{ __('Role') }}</th>
            <th class="px-6 py-4">{{ __('Actions') }}</th>
          </tr>
        </thead>

      @foreach($users as $user)
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
          <td class="px-6 py-4">{{ $user->id }}</td>
          <td class="px-6 py-4">{{ $user->username }}</td>
          <td class="px-6 py-4">{{ $user->email }}</td>
          <td class="px-6 py-4">{{ $user->name }}</td>
          <td class="px-6 py-4">
            <x-profile.badge role="{{ $user->role }}" />
          </td>
          <td class="px-6 py-4 flex items-center gap-2">
            <a href="{{ route('user.edit', $user->username) }}" title="{{ __('Edit') }}">
              <x-lucide-pencil />
            </a>
            <a href="{{ route('user.show', $user->username) }}" title="{{ __('Profile') }}">
              <x-lucide-user />
            </a>
            <a href="#" title="{{ __('Profile') }}">
              <x-lucide-trash-2 />
            </a>
          </td>
        </tr>
      @endforeach
    </table>
		</div>
	</div>
</x-admin-layout>