<x-master-layout>
	<div>
		{{ $user->name }}
		{{-- User is on his profile --}}
		@if (Auth::user()->username == $user->username || Auth::user()->role == 'admin')
			Hello
		@endif
	</div>
</x-master-layout>