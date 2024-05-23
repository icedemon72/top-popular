@section('title', __('Log in'))

<x-guest-layout>
	@if(session('destroyed'))
		{{-- [open, setOpen] = false --}}
		<x-form.info>
			{{ __('You have been logged out!') }}
		</x-form.info>
	@endif

	@if(session('success'))
		{{-- [open, setOpen] = false --}}
		<x-form.success>
			{{ __('Successfully registered! Now log in with your credentials!') }}
		</x-form.success>
	@endif

	{{-- 
		.wrapper {
  position: relative;
  display: inline-block;
}
.close:before {
  content: '✕';
}
.close {
  position: absolute;
  top: 0;
  right: 0;
  cursor: pointer;
}
		--}}

	<form method="POST" class="p-1">
		@csrf
		{{-- Info --}}
		<div class="text-main mb-7">
			<p class="text-2xl font-bold uppercase">{{ __('Top Popular') }}</p>
			<p class="text-lg font-bold uppercase mt-2">{{ __('Log In') }}</p>
			<p class="">{{ __('To see what\'s going on.') }}</p>
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

		{{-- Email --}}
		<div>
			<x-form.label for="login" :text="__('Username or email')" />
			<x-form.input tabindex="1" type="text" class="w-full block mt-1" :field="('login')" placeholder="john.doe@example.com" :value="old('login')" required />
		</div>

		{{-- Password --}}
		<div class="mt-5">
			<div class="flex justify-between">
				<x-form.label for="login" :text="__('Password')" />
				<a tabindex="4" class="underline text-sm text-link rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
					{{ __('Forgot your password?') }}
				</a>
			</div>
			<x-form.input tabindex="2" type="password" class="w-full block mt-1" :field="('password')" placeholder="Enter your password" required :value="old('password')" />
			<div class="mt-3">
				<x-form.checkbox  field="remember_me" text="{{ __('Remember me?') }}" />
			</div>
		</div>

		<div class="mt-3">
			<x-form.submit tabindex="3" class="w-full flex justify-center">
				{{ __('Log in') }}
			</x-form.submit>
		</div>

		<div class="flex justify-center gap-1 mt-5">
			<span class="text-muted text-sm">
				{{ __('Don\'t have a Top Popular account?') }}
			</span>
			<a tabindex="5" class="underline text-sm text-link rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('auth.register') }}">
				{{ __('Register now') }}
			</a>
		</div>

		
	</form>
</x-guest-layout>
