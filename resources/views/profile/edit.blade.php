@php
	$myProfile = Auth::user()->username == $user->username;
@endphp

@section('title', $myProfile ? 'Profile edit' : "Edit {$user->username}'s profile")

<x-master-layout>
	<x-slot name="header">
		<div class="w-full flex justify-center">
			<h2 class="w-full lg:w-1/2 font-semibold text-gray-800 dark:text-gray-200 leading-tight bg-white dark:bg-gray-800 p-4 rounded-lg flex justify-between gap-2 items-center">
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

	<form class="mt-5 flex flex-col justify-center items-center" action="{{ route('user.update', $user->id) }}" method="POST">
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
			<x-form.label class="mt-2" for="name">Name</x-form.label>
			<x-form.input class="w-full lg:w-2/3 block mt-1" type="text" field="name" :value="$user->name" />
			</x-profile.card>
			
			<x-profile.card title="Forum info">
				<x-form.label class="mt-2" for="desc">Description</x-form.label>
				<x-form.text-area class="w-full lg:w-2/3 mt-1" field="desc" placeholder="I like posting interesting things!">{{ $user->desc }}</x-form.text-area>
				<x-form.label class="mt-2" for="signature">Signature</x-form.label>
				<x-form.input class="w-full lg:w-2/3 block mt-1" type="text" field="signature" :value="$user->signature" placeholder="This has been signed by me!" />
				<x-form.label class="mt-2" for="location">Location</x-form.label>
				<x-form.input class="w-full lg:w-2/3 block mt-1" type="text" field="location" :value="$user->location" placeholder="Elysium" />
				<x-form.label class="mt-2" for="timezone">Timezone</x-form.label>
				<x-form.input class="w-full lg:w-2/3 block mt-1" type="text" field="timezone" :value="$user->timezone" placeholder="CET" />
		</x-profile.card>

		<x-profile.card title="Socials">
			<x-form.label class="mt-2" for="github">Github</x-form.label>
			<x-form.input class="w-full lg:w-2/3 block mt-1" type="url" field="github" :value="$user->github" placeholder="https://www.github.com/your-account" />
			<x-form.label class="mt-2" for="instagram">Instagram</x-form.label>
			<x-form.input class="w-full lg:w-2/3 block mt-1" type="url" field="instagram" :value="$user->instagram" placeholder="https://www.instagram.com/your.account" />
			<x-form.label class="mt-2" for="facebook">Facebook</x-form.label>
			<x-form.input class="w-full lg:w-2/3 block mt-1" type="url" field="facebook" :value="$user->facebook" placeholder="https://www.facebook.com/your.account" />
			<x-form.label class="mt-2" for="x">Twitter/X</x-form.label>
			<x-form.input class="w-full lg:w-2/3 block mt-1" type="url" field="x" :value="$user->x" placeholder="https://www.twitter.com/your.handle" />
		
			@if(Auth::user()->id != $user->id)
				<div class="w-full flex justify-end mt-5 gap-2">
					<x-form.cancel>{{ __('Cancel') }}</x-form.cancel>		
					<x-form.submit>{{ __('Update Profile') }}</x-form.submit>		
				</div>
			@endif
		</x-profile.card>

		@if(Auth::user()->id == $user->id)
			<x-profile.card color="text-red-500" title="Danger Area">
				<x-form.label class="mt-2" for="password">New password</x-form.label>
				<x-form.input class="w-full lg:w-2/3 block mt-1" type="password" field="password" :error="$errors->has('password')"/>
				<x-form.label class="mt-2" for="new_password">Confirm new password</x-form.label>
				<x-form.input class="w-full lg:w-2/3 block mt-1" type="password" field="new_password" :error="$errors->has('new_password')"/>
				
				<div class="w-full flex justify-end mt-5 gap-2">
					<x-form.cancel>{{ __('Cancel') }}</x-form.cancel>		
					<x-form.submit>{{ __('Update Profile') }}</x-form.submit>		
				</div>
			</x-profile.card>
		@else
			
		@endif
	</form>
</x-master-layout>