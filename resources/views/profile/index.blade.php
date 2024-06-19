@php
	$myProfile = false;
	$isAdmin = false; 
	$bannable = false;
	if(Auth::check()) {
		$myProfile = Auth::user()->username == $user->username;
		$isAdmin = Auth::user()->role == 'admin';
		$bannable = !$myProfile && ($isAdmin || (Auth::user()->role == 'moderator' && ($user->role == 'user' || $user->role == 'banned')));
	}
@endphp

@section('title', $myProfile ? 'My profile' : "{$user->username}")

@if($bannable && $user->role != 'banned')
	<script type="text/javascript">
		document.addEventListener('DOMContentLoaded', function() {
			handleModal("{{ route('user.ban', ':id') }}");
		});
	</script>
@endif

@if($bannable && $user->role == 'banned')
	<script type="text/javascript">
		document.addEventListener('DOMContentLoaded', function() {
			handleModal("{{ route('user.unban', ':id') }}");
		});
	</script>
@endif

<x-master-layout>
	@if($user->role == 'banned')
		<x-modals.delete text="Are you sure you want to unban this user?" method="POST">
			<x-lucide-circle-off class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" />
		</x-modals.delete>
	@else
		<x-modals.delete text="Are you sure you want to ban this user?" method="POST">
			<x-lucide-ban class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" />
		</x-modals.delete>
	@endif
	<x-slot name="header">
		<div class="flex w-full justify-center">
			<h2 class="w-full md:w-4/5 lg:w-3/5 font-semibold text-gray-800 dark:text-gray-200 leading-tight bg-white dark:bg-gray-800 p-4 rounded-lg flex justify-between gap-2 items-center border border-main">
				<div class="flex items-center gap-2">
					<div class="text-xl">
						@if($myProfile)
							{{ __('My profile') }}
						@else
							{{$user->username }}{{ __('\'s profile') }}
						@endif
					</div>
	
					<x-profile.badge :role="$user->role"/>
					@if ($myProfile || $isAdmin)
						<div class="flex">
							<a class="cursor-pointer p-1 transition-all hover:scale-75" href="{{ route('user.edit', $user->username) }}"><x-lucide-pencil /></a>
						</div>
					@endif
				</div>
				@if($bannable)
					@if($user->role != 'banned')
						<div class="modalTrigger flex gap-2 cursor-pointer rounded-full p-1 transition-all text-main-gray-light dark:text-main-gray-dark bg-red-500 hover:bg-red-700 group" title="{{ __('Ban user') }}" data-trigger="{{ $user->id }}">
							<x-lucide-gavel class="group-hover:scale-75 transition-all group-hover:rotate-45 text-main-gray-light dark:text-main-gray-dark dark:hover:text-main-gray-light hover:text-main-gray-dark" />
						</div>
					@else
						<div class="modalTrigger cursor-pointer rounded-full p-1 transition-all hover:bg-green-500 group" title="{{ __('Unban user') }}" data-trigger="{{ $user->id }}">
							<x-lucide-circle-off class="group-hover:scale-75 transition-all" />
						</div>
					@endif
				@endif
			</h2>
		</div>
	</x-slot>

	<div class="w-full flex flex-col items-center justify-center">
		<div class="flex w-full md:w-4/5 lg:w-3/5 justify-center">
			<div class="flex flex-1 gap-6 mt-5 md:mx-2">
				@if($myProfile)
					<div class="w-full md:w-64 h-64 relative group cursor-pointer bg-main ">
						<label for="image" aria-label="Image upload button" class="cursor-pointer">
							<img class="rounded-lg hover:opacity-70 w-full h-full" src="{{ asset("storage/$user->image") }}" alt="{{ __('Profile picture') }}" />
							<div class="p-2 opacity-0 group-hover:opacity-100 duration-300 absolute inset-x-0 bottom-24 flex flex-col justify-center items-center text-xl bg-main text-main font-semibold">
								{{ __('Edit profile picture') }}
								<span class="text-xs text-center">{{ __('Only .jpg, .png and .svg are allowed. Max file size 2MB') }}</span>
							</div>
						</label>
						<form id="imageForm" method="POST" class="hidden" action="{{ route('user.pic') }}" enctype="multipart/form-data">
							@method('PATCH')
							@csrf
							<input type="file" id="image" name="image" onchange="form.submit();"/>
						</form>
					</div>
				@else 
					<div class="w-64 h-64">
						<img class="rounded-lg" class="w-full h-full" src="{{ asset("storage/$user->image") }}" alt="{{ __('Profile picture') }}" />
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
			<div x-on:click="open = !open" class="w-full flex justify-between items-center gap-2 mt-3 mb-1 p-2 bg-card rounded-lg border border-main">
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

		<section id="activity" x-data="{ open: true }"  class="w-full md:w-4/5 lg:w-3/5 flex flex-col items-center">
			<div x-on:click="open = !open" class="w-full flex items-center justify-between gap-2 mt-3 mb-1 p-2 bg-card rounded-lg border border-main">
				<div class="flex gap-2 items-center">
					<x-lucide-bar-chart-3 />
					<h1 class="text-xl text-main">{{ __('Activity') }}</h1>
				</div>
	
				<x-lucide-chevron-up class="cursor-pointer" x-cloak x-show="open"/>
				<x-lucide-chevron-down class="cursor-pointer" x-cloak x-show="!open"/>
	
			</div>
	
			<div x-collapse x-show="open" class="w-full">
				<x-profile.activity 
					:categories="$user->categories_count"
					:stats="$stats"
				/>
			</div>
		</section>

		<section id="posts" x-data="{ open: false }"  class="w-full md:w-4/5 lg:w-3/5 flex flex-col items-center">
			<div x-on:click="open = !open" class="w-full flex items-center justify-between gap-2 mt-3 mb-1 p-2 bg-card rounded-lg border border-main">
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
			<div x-on:click="open = !open" class="w-full flex items-center justify-between gap-2 mt-3 mb-1 p-2 bg-card rounded-lg border border-main">
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