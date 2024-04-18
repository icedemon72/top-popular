@section('title', __('Login'))

<x-guest-layout>
	@if(session('destroyed'))
		{{-- [open, setOpen] = false --}}
		<div x-data="{ open: true }" :class="{ 'block': open, 'hidden': !open }" class="p-4 text-center w-full text-muted relative inline-block rounded-lg bg-gray-300 dark:bg-gray-700">
			<div class="absolute group top-0 right-0 cursor-pointer p-1 " @click="open = false">X</div>
			{{ __('You have been logged out!') }}
		</div>
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
				{{ __('Invalid credentials!') }}
			</x-form.error>
		@endif

		{{-- Email --}}
		<div>
			<x-form.label for="login" :text="__('Username or email')" />
			<x-form.input tabindex="1" type="text" class="w-full block mt-1" :field="('login')" placeholder="john.doe@example.com" :value="old('login')" required />
		</div>

		{{-- Password --}}
		{{-- TODO: add remember me --}}
		<div class="mt-5">
			<div class="flex justify-between">
				<x-form.label for="login" :text="__('Password')" />
				<a tabindex="4" class="underline text-sm text-link rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
					{{ __('Forgot your password?') }}
				</a>
			</div>
			<x-form.input tabindex="2" type="password" class="w-full block mt-1" :field="('password')" placeholder="Enter your password" required :value="old('password')" />
		</div>

		<div class="mt-7">
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
