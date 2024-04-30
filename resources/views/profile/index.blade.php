@php
	$myProfile = false;
	$isAdmin = false; 
	if(Auth::check()) {
		$myProfile = Auth::user()->username == $user->username;
		$isAdmin = Auth::user()->role == 'admin';
	}
@endphp

@section('title', $myProfile ? 'My profile' : "{$user->username}")

<x-master-layout>
	<x-slot name="header">
		<div class="flex w-full justify-center">
			<h2 class="w-full md:w-4/5 lg:w-3/5 font-semibold text-gray-800 dark:text-gray-200 leading-tight bg-white dark:bg-gray-800 p-4 rounded-lg flex gap-2 items-center">
				<div class="text-xl">
					@if($myProfile)
						{{ __('My profile') }}
					@else
						{{$user->username }}{{ __('\'s profile') }}
					@endif
				</div>

				<x-profile.badge :role="$user->role"/>
				@if ($myProfile || $isAdmin)
					<div class="flex-grow-0">
						<a href="{{ route('user.edit', $user->username) }}">Edit</a>
					</div>
				@endif
			</h2>
		</div>
	</x-slot>

	<div class="w-full flex flex-col items-center justify-center">
		<div class="flex w-full md:w-4/5 lg:w-3/5 justify-center">
			<div class="flex flex-1 gap-6 mt-5 md:mx-2">
				@if($myProfile)
					<div class="w-64 h-64 relative group cursor-pointer bg-main">
						<img class="rounded-lg hover:opacity-70" src="{{ asset("storage/$user->image") }}" alt="{{ __('Profile picture') }}" />
						<div class="p-2 opacity-0 group-hover:opacity-100 duration-300 absolute inset-x-0 bottom-24 flex flex-col justify-center items-center text-xl bg-main text-main font-semibold">
							{{ __('Edit profile picture') }}
							<span class="text-xs text-center">{{ __('Only .jpg, .png and .svg are allowed. Max file size 2MB') }}</span>
						</div>
					</div>
				@else 
					<div class="w-64 h-64">
						<img class="rounded-lg" src="{{ asset("storage/$user->image") }}" alt="{{ __('Profile picture') }}" />
					</div>
				@endif
				<div class="flex flex-col flex-">
					<div class="mb-2">
						<p class="text-sm text-muted">{{ __('Name') }}</p>
						<h2 class="text-xl text-main">{{ $user->name }}</h2>
					</div>
					<div class="mb-2">
						<p class="text-sm text-muted">{{ __('E-mail') }}</p>
						<h2 class="text-xl text-main">{{ $user->email }}</h2>
					</div>
					<div class="mb-2">
						<p class="text-sm text-muted">{{ __('Joined') }}</p>
						<h2 class="text-xl text-main">{{ date_format(date_create($user->created_at), 'd.m.Y. H:i') }}, {{ \Carbon\Carbon::parse($user->created_at)->diffForHumans() }}</h2>
					</div>
				</div>
			</div>

		</div>

		<section id="information" x-data="{ open: true }" class="w-full md:w-4/5 lg:w-3/5 flex flex-col items-center">
			<div x-on:click="open = !open" class="w-full flex justify-between items-center gap-2 mt-3 mb-1 p-2 bg-card rounded-lg">
				<div class="flex items-center gap-2">
					<x-lucide-info/>
					<h1 class="text-xl text-main">{{ __('Information') }}</h1>
				</div>
	
				<x-lucide-chevron-up class="cursor-pointer" x-cloak  x-show="open"/>
				<x-lucide-chevron-down class="cursor-pointer" x-cloak x-show="!open"/>
			</div>

			<div x-cloak x-collapse x-show="open" class="w-full text-main">
				<x-profile.info-container :user="$user" />
			</div>
		</section>

		<section id="activity" x-data="{ open: false }"  class="w-full md:w-4/5 lg:w-3/5 flex flex-col items-center">
			<div x-on:click="open = !open" class="w-full flex items-center justify-between gap-2 mt-3 mb-1 p-2 bg-card rounded-lg">
				<div class="flex gap-2 items-center">
					<x-lucide-bar-chart-3 />
					<h1 class="text-xl text-main">{{ __('Activity') }}</h1>
				</div>
	
				<x-lucide-chevron-up class="cursor-pointer" x-cloak x-show="open"/>
				<x-lucide-chevron-down class="cursor-pointer" x-cloak x-show="!open"/>
	
			</div>
	
			<div x-collapse x-show="open" class="w-full">
				<x-profile.activity 
					:comments="count($user->comments)" 
					:posts="count($user->posts)"
					:stats="$stats"
				/>
			</div>
		</section>

		<section id="posts" x-data="{ open: false }"  class="w-full md:w-4/5 lg:w-3/5 flex flex-col items-center">
			<div x-on:click="open = !open" class="w-full flex items-center justify-between gap-2 mt-3 mb-1 p-2 bg-card rounded-lg">
				<div class="flex gap-2 items-center">
					<x-lucide-rotate-ccw />
					<h1 class="text-xl text-main">{{ __('Last 10 posts') }}</h1>
				</div>
	
				<x-lucide-chevron-up class="cursor-pointer" x-cloak x-show="open"/>
				<x-lucide-chevron-down class="cursor-pointer" x-cloak x-show="!open"/>
	
			</div>

			<div x-collapse x-show="open" class="w-full">
				@foreach($user->posts as $post)
					<x-posts.post :post="$post" profile="true" class="mb-3" />
				@endforeach
			</div>
		</section>

		<section id="comments" x-data="{ open: false }"  class="w-full md:w-4/5 lg:w-3/5 flex flex-col items-center">
			<div x-on:click="open = !open" class="w-full flex items-center justify-between gap-2 mt-3 mb-1 p-2 bg-card rounded-lg">
				<div class="flex gap-2 items-center">
					<x-lucide-rotate-ccw />
					<h1 class="text-xl text-main">{{ __('Last 10 comments') }}</h1>
				</div>
	
				<x-lucide-chevron-up class="cursor-pointer" x-cloak x-show="open"/>
				<x-lucide-chevron-down class="cursor-pointer" x-cloak x-show="!open"/>
	
			</div>

			<div x-collapse x-show="open" class="w-full">
				@foreach($user->comments as $comment)
					<x-posts.comment :profile="true" :op="null" :comment="$comment" :archived="false" class="mb-3" />
				@endforeach
			</div>
		</section>

	</div>


</x-master-layout>