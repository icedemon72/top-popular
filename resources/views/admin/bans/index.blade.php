@section('title', 'Banned users')

<script type="text/javascript">
	document.addEventListener('DOMContentLoaded', function() {
		handleModal("{{ route('user.unban', ':id') }}");
    sortTable();
		showChevron();
	});
</script>

<x-admin-layout>
  <x-modals.delete text="{{ __('Are you sure you want to unban this user?') }}" method="POST">
    <x-lucide-circle-off class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" />
  </x-modals.delete>
	<x-slot name="header">
		<div class="flex w-full justify-center">
			<h2 class="w-full flex gap-2 items-center md:w-4/5 lg:w-3/5 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight bg-white dark:bg-gray-800 p-4 rounded-lg">
				<x-lucide-ban />
				{{ __('Banned Users') }}
			</h2>
		</div>
	</x-slot>
  

	<div class="w-full flex flex-col items-center justify-center mt-7">
    <div class="flex w-full md:w-4/5 lg:w-4/5 justify-end items-center">
      <form class="flex items-center" method="GET">
        <x-form.search-input class="bg-card" field="search" placeholder="{{ __('Search users...') }}" value="{{ request()->input('search') }}" />
      </form>
    </div>
    <div class="relative w-full md:w-4/5 lg:w-4/5 overflow-x-auto shadow-md sm:rounded-lg">
      <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
          <tr x-data="{ sort: false, field: '', asc: false }">
            <x-admin.th query="id">{{ __('ID') }}</x-admin.th>
            <x-admin.th query="username">{{ __('Username') }}</x-admin.th>
            <x-admin.th query="email">{{ __('E-mail') }}</x-admin.th>
            <x-admin.th query="name">{{ __('Name') }}</x-admin.th>
            <th class="px-6 py-4">{{ __('Status') }}</th>
            <th class="px-6 py-4">{{ __('Actions') }}</th>
          </tr>
        </thead>
        
        <tbody>
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
                <a class="cursor-pointer rounded-full p-1 transition-all hover:bg-main group" href="{{ route('user.edit', $user->username) }}" title="{{ __('Edit') }}">
                  <x-lucide-pencil class="group-hover:scale-75 group-hover:-rotate-45 transition-all" />
                </a>
                <a class="cursor-pointer rounded-full p-1 transition-all hover:bg-main group" href="{{ route('user.show', $user->username) }}" title="{{ __('Profile') }}">
                  <x-lucide-user class="group-hover:scale-75 transition-all" />
                </a>
                <div class="modalTrigger cursor-pointer rounded-full p-1 transition-all hover:bg-green-500 group" title="{{ __('Unban user') }}" data-trigger="{{ $user->id }}">
                  <x-lucide-circle-off class="group-hover:scale-75 transition-all" />
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
    </table>
  </div>
  @if(count($users) == 0)
    <p class="text-muted p-2">
      {{ __('There are no banned users, that\'s good... right?') }}
    </p>
  @endif
  <div class="mt-2">
    {{ $users->withQueryString()->links() }}
  </div>

</x-admin-layout>