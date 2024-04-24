<x-admin-layout>
  <x-slot name="header">
		<div class="flex w-full justify-center">
			<h2 class="w-full flex gap-2 items-center md:w-4/5 lg:w-3/5 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight bg-gray-400 dark:bg-gray-800 p-4 rounded-lg">
				<x-lucide-users />
				{{ __('Users') }}
			</h2>
		</div>
	</x-slot>

  <div class="w-full md:w-4/5 lg:w-4/5 mt-7">
    {{-- <x-admin.table 
      :cols="[__('ID'), __('Email'), __('Username'), __('Actions')]" 
      :types="['id' => 'string', 'name' => 'string', 'email' => 'string', 'username' => 'string', 'role' => 'string']"
      :actions="['edit']"
      route="user"
      :data="$users"
    /> --}}
    <table class="text-main">
      @foreach($users as $user)
        <td>{{ $user->username }}</td>
        <td>
          <a href="{{ route('user.edit', $user->username) }}">Edit</a>
        </td>
      @endforeach
    </table>
  </div>
  

</x-admin-layout>