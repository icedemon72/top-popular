@section('title', __('Users'))

<script type="text/javascript">
	document.addEventListener('DOMContentLoaded', function() {
		handleModal("{{ route('user.ban', ':id') }}")
	});
</script>

<x-admin-layout>
  <x-modals.delete text="Are you sure you want to ban this user?">
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

  <div class="w-full flex justify-center mt-7">
    {{-- <x-admin.table 
      :cols="[__('ID'), __('Email'), __('Username'), __('Actions')]" 
      :types="['id' => 'string', 'name' => 'string', 'email' => 'string', 'username' => 'string', 'role' => 'string']"
      :actions="['edit']"
      route="user"
      :data="$users"
    /> --}}
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
                    <x-lucide-ban class="group-hover:scale-75 transition-all" />
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