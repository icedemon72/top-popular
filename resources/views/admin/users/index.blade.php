@section('title', __('Users'))

<script type="text/javascript">
	document.addEventListener('DOMContentLoaded', function() {
		handleModal("{{ route('user.ban', ':id') }}");
    sortTable();
		showChevron();
	});
</script>

<x-admin-layout>
  <x-modals.delete text="Are you sure you want to ban this user?" method="POST">
    <x-lucide-ban class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" />
  </x-modals.delete>
  <x-slot name="header">
		<div class="flex w-full justify-center">
			<h2 class="w-full flex gap-2 items-center md:w-4/5 lg:w-3/5 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight bg-white dark:bg-gray-800 p-4 rounded-lg">
				<x-lucide-users />
				{{ __('Users') }}
			</h2>
		</div>
	</x-slot>

  <div x-data="{ open: false }" class="w-full flex flex-col items-center justify-center mt-7">
    <div class="flex w-full md:w-4/5 lg:w-4/5 justify-between items-center">
			<div x-on:click="open = !open" x-bind:class="open ? 'bg-card shadow-sm' : ''" class="flex gap-2 rounded-lg shadow-sm text-main	hover:bg-card p-2 cursor-pointer">
				<x-lucide-filter />
				{{ __('Filters') }}
			</div>
			<form class="flex" method="GET">
				<x-form.search-input class="bg-card" field="search" placeholder="{{ __('Search users...') }}" value="{{ request()->input('search') }}" />
			</form>
    </div>
    <div x-collapse x-cloak x-show="open" class="w-full flex md:w-4/5 lg:w-4/5 mt-2">
      <form id="filters" class="w-full">
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-2">
          <div class="col-span-1">
            <p class="text-muted">{{ __('Role') }}</p>
            <x-form.checkbox  field="role[]" value="admin" text="{{ __('Admin') }}" />
            <x-form.checkbox  field="role[]" value="moderator" text="{{ __('Moderator') }}" />
            <x-form.checkbox  field="role[]" value="user" text="{{ __('User') }}" />
          </div>
        </div>
        
        <x-form.submit class="mt-1">{{ __('Apply filters') }}</x-form.submit>
      </form>
    </div>
  </div>

  <div class="w-full flex justify-center">
    <div class="relative w-full md:w-4/5 lg:w-4/5 overflow-x-auto shadow-md sm:rounded-lg">
      <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
          <tr x-data="{ sort: false, field: '', asc: false }">
            <x-admin.th query="id">{{ __('ID') }}</x-admin.th>
            <x-admin.th query="username">{{ __('Username') }}</x-admin.th>
            <x-admin.th query="email">{{ __('E-mail') }}</x-admin.th>
            <x-admin.th query="name">{{ __('Name') }}</x-admin.th>
            <x-admin.th query="role">{{ __('Role') }}</x-admin.th>
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
                @if($user->role != 'admin')
                  <div class="modalTrigger cursor-pointer rounded-full p-1 transition-all hover:bg-red-500 group" title="{{ __('Ban user') }}" data-trigger="{{ $user->id }}">
                    <x-lucide-gavel class="group-hover:scale-75 transition-all group-hover:rotate-45" />
                  </div>
								@endif
              </td>
            </tr>
          @endforeach
        </tbody>
    </table>
  </div>

  <div class="mt-2">
    {{ $users->withQueryString()->links() }}
  </div>
  

</x-admin-layout>