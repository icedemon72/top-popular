@php
	$myProfile = Auth::user()->username == $user->username;
@endphp

@section('title', $myProfile ? 'Profile edit' : "Edit {$user->username}'s profile")

<x-master-layout>
	<x-slot name="header">
		<div class="w-full">
			<h2 class="w-full lg:w-1/2 font-semibold text-gray-800 dark:text-gray-200 leading-tight bg-gray-400 dark:bg-gray-800 p-4 rounded-lg flex justify-between gap-2 items-center">
				<div class="text-xl">
					@if($myProfile)
						{{ __('Edit my profile') }}
					@else
						Edit {{$user->username }}{{ __('\'s profile') }}
					@endif
				</div>
				<x-profile.badge :role="$user->role"/>
			</h2>
		</div>
	</x-slot>

	
	<form class="mt-5" action="{{ route('user.update', $user->id) }}" method="POST">
		@method('PATCH')
		@csrf
		
		@if (session('edited'))
			<div class="w-full lg:w-1/2">
				<x-form.success>
					{{ __('Profile successfully updated') }}
				</x-form.success>
			</div>
		@endif

		@if ($errors->any())
			<div class="w-full lg:w-1/2">
				<x-form.error>
					<ul>
							@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
							@endforeach
					</ul>
				</x-form.error>
			</div>
		@endif

		<x-profile.card title="Basic info">
			<x-form.label class="mt-2" :text="__('Username')"  for="username"/>
			<x-form.input class="w-full lg:w-2/3 block mt-1" :disabled="true" field="username" :value="$user->username" />
			<x-form.label class="mt-2" :text="__('Email')" for="email" :error="$errors->has('email')" />
			<x-form.input class="w-full lg:w-2/3 block mt-1" type="email" field="email" :value="$user->email" />
			<x-form.label class="mt-2">Name</x-form.label>
			<x-form.input class="w-full lg:w-2/3 block mt-1" type="text" field="name" :value="$user->name" />
		</x-profile.card>

		<x-profile.card title="Forum info">
			<x-form.label class="mt-2" for="desc">Description</x-form.label>
			<x-form.text-area class="w-full lg:w-2/3 mt-1" field="desc">{{ $user->desc }}</x-form.text-area>
			<x-form.label class="mt-2">Signature</x-form.label>
			<x-form.input class="w-full lg:w-2/3 block mt-1" type="text" field="name" :value="$user->signature" />
		</x-profile.card>

		<x-profile.card title="Socials">
			<x-form.label class="mt-2">Github</x-form.label>
			<x-form.input class="w-full lg:w-2/3 block mt-1" type="url" field="github" :value="$user->github" />
			<x-form.label class="mt-2">Instagram</x-form.label>
			<x-form.input class="w-full lg:w-2/3 block mt-1" type="url" field="instagram" :value="$user->instagram" />
			<x-form.label class="mt-2">Facebook</x-form.label>
			<x-form.input class="w-full lg:w-2/3 block mt-1" type="url" field="facebook" :value="$user->facebook" />
			<x-form.label class="mt-2">Twitter/X</x-form.label>
			<x-form.input class="w-full lg:w-2/3 block mt-1" type="url" field="x" :value="$user->x" />
		</x-profile.card>

		<x-profile.card title="Danger Area">
			<x-form.label class="mt-2">New password</x-form.label>
			<x-form.input class="w-full lg:w-2/3 block mt-1" type="password" field="password" :error="$errors->has('password')"/>
			<x-form.label class="mt-2">Confirm new password</x-form.label>
			<x-form.input class="w-full lg:w-2/3 block mt-1" type="password" field="new_password" :error="$errors->has('new_password')"/>
			
			<div class="w-full flex justify-end mt-5 gap-2">
				<x-form.cancel>{{ __('Cancel') }}</x-form.cancel>		
				<x-form.submit>{{ __('Update Profile') }}</x-form.submit>		
			</div>
		</x-profile.card>
	</form>
</x-master-layout>