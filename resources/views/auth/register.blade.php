@section('title', __('Register'))

<x-guest-layout>
    <form method="POST" class="p-1" action="{{ route('register') }}">
		@csrf
		{{-- Info --}}
		<div class="text-main mb-7">
			<p class="text-2xl font-bold uppercase">{{ __('Top Popular') }}</p>
			<p class="text-lg font-bold uppercase mt-2">{{ __('Register') }}</p>
			<p class="">{{ __('To become part of the story.') }}</p>
		</div>

		@if ($errors->any())
    	<x-form.error>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
			</x-form.error>
		@endif

		<div>
			<x-form.label for="name" :text="__('Name')" />
			<x-form.input type="text" class="w-full block mt-1" :field="('name')" placeholder="John Doe" required :value="old('name')" :error="$errors->has('name')" />
	</div>

		{{-- Email --}}
		<div class="mt-5">
			<x-form.label for="username" :text="__('Username*')" />
			<x-form.input type="text" class="w-full block mt-1" :field="('username')" placeholder="john.doe" :value="old('username')" required :error="$errors->has('username')" />
			<span class="text-muted text-xs">* Must be unique and at least 3 characters in length</span>
		</div>

		{{-- Email --}}
		<div class="mt-5">
			<x-form.label for="email" :text="__('Email')" />
			<x-form.input type="email" class="w-full block mt-1" :field="('email')" placeholder="john.doe@example.com" :value="old('email')" required :error="$errors->has('email')" />
		</div>

		{{-- Password --}}
		<div class="mt-5">
				<x-form.label for="password" :text="__('Password*')" />
				<x-form.input type="password" class="w-full block mt-1" :field="('password')" placeholder="Enter your password" :value="old('password')" required :error="$errors->has('password')" />
				<span class="text-muted text-xs">* Must be at least 4 characters in length</span>
			</div>

		<div class="mt-7">
			<x-form.submit class="w-full flex justify-center">
				{{ __('Register') }}
			</x-form.submit>
		</div>

		<div class="flex justify-center gap-1 mt-5">
			<span class="text-muted text-sm">
				{{ __('Already registered?') }}
			</span>
			<a class="underline text-sm text-link rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('auth.login') }}">
				{{ __('Log in') }}
			</a>
		</div>		
	</form>
</x-guest-layout>
