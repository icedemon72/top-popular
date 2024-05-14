@props(['search' => true])
<script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>
<nav x-data="{ open: false, filterOpen: false }"
	class="fixed h-16 top-0 left-0 w-full z-50 bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
	<!-- Primary Navigation Menu -->
	<div class="px-4 sm:px-6 lg:px-8">
		<div class="flex justify-between h-16">
			{{-- Left side --}}
			<div class="flex">
				<div class="hidden shrink-0 lg:flex items-center">
					<a href="{{ route('home') }}">
						<p class="flex h-9 w-auto fill-current text-gray-800 dark:text-gray-200 items-center">Top Popular
						</p>
					</a>
				</div>
				<div class="hidden space-x-8 sm:-my-px pr-5 lg:pr-0 lg:ms-10 sm:flex">
					<x-nav.link :href="route('home')" :active="request()->routeIs('home')">
						{{ __('Home') }}
					</x-nav.link>
					<x-nav.link :href="route('contact')" :active="request()->routeIs('contact')">
						{{ __('Contact') }}
					</x-nav.link>
					<x-nav.link :href="route('about')" :active="request()->routeIs('about')">
						{{ __('About') }}
					</x-nav.link>
				</div>
			</div>
			@if($search)
				<div class="flex items-center gap-2 align-middle h-full w-full lg:w-1/3">
					<form id="searchForm" class="w-full rounded-xl my-3" method="GET">
						<x-form.search-input class="w-auto" field="search" placeholder="Search Top Popular" 
							value="{{ request()->input('search') }}" />
					</form>
					<x-lucide-settings title="{{ __('Advanced search') }}" x-on:click="filterOpen = !filterOpen"
						class="cursor-pointer text-muted hover:bg-main rounded-full hover:rotate-90 transition-all" />

					<x-nav.dropdown-search :categories="$categories" />
				</div>
			@endif
			{{-- Right side --}}
			@if (Auth::check())
			<div class="hidden sm:flex sm:items-center sm:ms-6">
				<x-nav.dropdown align="right" width="48">
					<x-slot name="trigger">
						<button aria-label="Dropdown button"
							class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
							<img src="{{ asset("storage/".Auth::user()->image) }}" class="w-8 h-8 rounded-full me-1" alt="Profile picture" />
							{{-- 
							<div>{{ Auth::user()->username }}</div>
							--}}
							<div class="ms-1">
								<svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
									viewBox="0 0 20 20">
									<path fill-rule="evenodd"
										d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
										clip-rule="evenodd" />
								</svg>
							</div>
						</button>
					</x-slot>
					<x-slot name="content">
						<x-nav.dropdown-link class="flex items-center gap-2" :href="route('user.show', Auth::user()->username)">
							<x-lucide-user />
							{{ __('Profile') }}
						</x-nav.dropdown-link>
						<!-- Authentication -->
						@if (in_array(Auth::user()->role, ['admin', 'moderator']))
						<x-nav.dropdown-link class="flex items-center gap-2 text-green-500" :href="route('admin.index')">
							<x-lucide-layout-dashboard />
							{{ __('Admin Dashboard') }}
						</x-nav.dropdown-link>
						@endif
						<form method="POST" action="{{ route('logout') }}">
							@csrf
							<x-nav.dropdown-link class="flex items-center gap-2" :href="route('logout')"
								onclick="event.preventDefault(); this.closest('form').submit();">
								<x-lucide-log-out />
								{{ __('Log Out') }}
							</x-nav.dropdown-link>
						</form>
					</x-slot>
				</x-nav.dropdown>
			</div>
			@else
			<div class="hidden sm:flex align-middle gap-3">
				<x-nav.link :href="route('login')" :active="request()->routeIs('auth.login')">
					{{ __('Login') }}
				</x-nav.link>
				<x-nav.link :href="route('register')" :active="request()->routeIs('auth.register')">
					{{ __('Register') }}
				</x-nav.link>
			</div>
			@endif
			<!-- Hamburger -->
			<div class="-me-2 flex items-center sm:hidden">
				<button x-on:click="open = !open" aria-label="Hamburger button"
					class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
					<svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
						<path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
							stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
							d="M4 6h16M4 12h16M4 18h16" />
						<path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
							stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
					</svg>
				</button>
			</div>
		</div>
	</div>
	<!-- Responsive Navigation Menu -->
	<div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden h-screen bg-main">
		<div class="pt-2 pb-3 space-y-1">
			<x-nav.ham-link :href="route('home')" :active="request()->routeIs('home')">
				{{ __('Home') }}
			</x-nav.ham-link>
			<x-nav.ham-link :href="route('contact')" :active="request()->routeIs('contact')">
				{{ __('Contact') }}
			</x-nav.ham-link>
			<x-nav.ham-link :href="route('about')" :active="request()->routeIs('about')">
				{{ __('About') }}
			</x-nav.ham-link>
			@if(Auth::check())
				<x-nav.ham-link :href="route('user.show', Auth::user()->username)">
					{{ __('Profile') }}
				</x-nav.ham-link>
				@if (in_array(Auth::user()->role, ['admin', 'moderator']))
					<x-nav.ham-link :href="route('admin.index')">
						{{ __('Admin Dashboard') }}
					</x-nav.ham-link>
				@endif
					<form class="flex gap-2 cursor-pointer w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-red-600 dark:text-red-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 focus:outline-none focus:text-gray-800 dark:focus:text-gray-200 focus:bg-gray-50 dark:focus:bg-gray-700 focus:border-gray-300 dark:focus:border-gray-600 transition duration-150 ease-in-out" method="POST" action="{{ route('logout') }}">
						@csrf
						<x-lucide-log-out class="text-red-600 dark:text-red-400" />
						<button type="submit" aria-label="{{ __('Logout button') }}">{{ __('Logout') }}</button>
					</form>
				@else 
					<x-nav.ham-link :href="route('login')">
						{{ __('Login') }}
					</x-nav.ham-link>
					<x-nav.ham-link :href="route('register')">
						{{ __('Register') }}
					</x-nav.ham-link>
				@endif
		
			<div class="border-t border-main">
				@foreach($categories as $category)
				<x-nav.ham-link :href="route('post.index', $category->id)">
					{{ __($category->name) }}
				</x-nav.ham-link>
				@endforeach
			</div>
		</div>
		<!-- Responsive Settings Options -->
		@if (Auth::check())
		<div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
			<div class="px-4">
				<div class="flex items-center gap-2">
					<img src="{{ asset("storage/".Auth::user()->image) }}" class="w-8 h-8 rounded-full" alt="Profile picture"  />
					<div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->username }}</div>
				</div>
				<div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
			</div>
		</div>
		@endif
	</div>
</nav>

<script type="text/javascript">
	const searchForm = document.getElementById('searchForm');
	const filterForm = document.getElementById('searchFilters');
	const allowed = ['archived', 'category', 'time'];
	searchForm.addEventListener("submit", function (e) {
		e.preventDefault();
		let formData = new FormData(filterForm);
		if ('URLSearchParams' in window) {
			let searchParams = new URLSearchParams(window.location.search);
			let searchVal =  document.getElementById('search').value;
			(searchVal) 
				? searchParams.set('search', searchVal) 
				: searchParams.delete('search');
			for (let pair of formData.entries()) {
				if(allowed.indexOf(pair[0]) !== -1 && pair[1]) {
					searchParams.set(pair[0], pair[1]);
				}
			}
			window.location.search = searchParams.toString()
		}
	});
</script>
