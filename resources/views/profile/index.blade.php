@php
	$myProfile = Auth::user()->username == $user->username;
@endphp

@section('title', $myProfile ? 'My profile' : "{$user->username}")

<x-master-layout>
	<x-slot name="header">
		<div class="flex w-full justify-center">
			<h2 class="w-full md:w-4/5 lg:w-3/5 font-semibold text-gray-800 dark:text-gray-200 leading-tight bg-gray-400 dark:bg-gray-800 p-4 rounded-lg flex gap-2 items-center">
				<div class="text-xl">
					@if($myProfile)
						{{ __('My profile') }}
					@else
						{{$user->username }}{{ __('\'s profile') }}
					@endif
				</div>

				<x-profile.badge :role="$user->role"/>
				@if ($myProfile || Auth::user()->role == 'admin')
					<div class="flex-grow-0">
						<a href="{{ route('user.edit', $user->username) }}">Edit</a>
					</div>
				@endif
			</h2>
		</div>

		<div class="flex w-full justify-center">

		</div>
	</x-slot>

</x-master-layout>