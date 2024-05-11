@section('title', __('Admin'))
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
<x-admin-layout>
	<x-slot name="header">
		<div class="flex w-full justify-center">
			<h2 class="w-full flex gap-2 items-center md:w-4/5 lg:w-3/5 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight bg-white dark:bg-gray-800 p-4 rounded-lg">
				<x-lucide-layout-dashboard />
				{{ __('Dashboard') }}
			</h2>
		</div>
	</x-slot>

	<div class="w-full flex flex-col items-center justify-center mt-7">
		<div class="flex w-full lg:w-3/4 justify-end items-center mt-5">
			<form class="w-full inline-flex gap-2 max-w-[250px]" method="GET">
				<div class="flex-grow self-center">
					<x-bladewind::select  
						aria-label="Time select"
						id="time"
						name="time"
						placeholder="{{ __('Select time...') }}"
						multiple="false"
						searchable="false" 
						data="manual" 
						selected_value="{{ request()->input('time') ?? 'month' }}"
					>
						<x-bladewind::select-item label="{{ __('Last week') }}" value="week"  />
						<x-bladewind::select-item label="{{ __('Last month') }}" value="month"  />
						<x-bladewind::select-item label="{{ __('Last year') }}" value="year"  />
					</x-bladewind::select>
				</div>
				<button type="submit flex items-center" aria-label="{{ __('Apply filters') }}" title="{{ __('Apply') }}">
					<x-lucide-send-horizontal class="w-9 h-9 mb-3 rounded-full bg-card p-2 transition-all hover:bg-main" />
				</button>


			</form>
		</div>
		<div class="w-full lg:w-3/4 grid grid-cols-1 xl:grid-cols-3 gap-4 mb-4 ">
			<div class="col-span-2 bg-card rounded-lg p-4 text-main">
				<div class="w-full flex items-center justify-between px-5 pt-2">
					<h1 class="text-xl flex items-center gap-2 uppercase font-bold">
						<x-lucide-box />
						{{ __('Posts by Category') }}
					</h1>
					<a class="p-1 rounded-lg transition-all cursor-pointer bg-main hover:bg-card border-2 border-main-gray-dark text-center" href="{{ route('category.index') }}">
						{{ __('All categories') }}
					</a>
				</div>
				<div class="w-full mt-2 px-4 py-2">
					{!! $charts->categoryPosts->render() !!}
				</div>
			</div>
			@if(Auth::user()->role == 'admin')
				<div class="col-span-1 bg-card rounded-lg p-4 text-main w-full">
					<p class="text-xl font-bold mb-1 pt-2">{{ __('Website status') }}</p>
					<ul>
						<li class="flex items-center justify-between mb-2">
							<div class="flex items-center gap-2">
								<x-lucide-copyright class="w-5 h-5" />
								<p class="font-bold">{{ __('Created') }}</p>	
							</div>
							<p class="text-muted">15.04.2024 ({{ \Carbon\Carbon::parse('2024-04-15')->diffForHumans() }})</p>
						</li>
						<li class="flex items-center justify-between mb-2">
							<div class="flex items-center gap-2">
								<x-lucide-database class="w-5 h-5" />
								<p class="font-bold">{{ __('Database') }}</p>	
							</div>
							<p class="text-muted">{{ $data->db }}</p>
						</li>
						<li class="flex items-center justify-between mb-2">
							<div class="flex items-center gap-2">
								<x-lucide-server class="w-5 h-5" />
								<p class="font-bold">{{ __('Data usage') }}</p>	
							</div>
							<p class="text-muted">{{ $data->storage }}MB</p>
						</li>
						<li class="flex items-center justify-between mb-2">
							<div class="flex items-center gap-2">
								<x-lucide-link-2 class="w-5 h-5" />
								<p class="font-bold">{{ __('Host URL') }}</p>	
							</div>
							<p class="text-muted text-xs">{{ $data->host }}</p>
						</li>
					</ul>

					<p class="text-xl font-bold mb-1 pt-2">{{ __('Important data') }}</p>
					<ul>
						<li class="flex items-center justify-between mb-2">
							<div class="flex items-center gap-2">
								<x-lucide-users class="w-5 h-5" />
								<p class="font-bold">{{ __('Total Users') }}</p>	
							</div>
							<p class="text-muted">{{ $stats->users }}</p>
						</li>
						<li class="flex items-center justify-between mb-2">
							<div class="flex items-center gap-2">
								<x-lucide-shield-plus class="w-5 h-5" />
								<p class="font-bold">{{ __('Moderators') }}</p>	
							</div>
							<p class="text-muted">{{ $stats->mods }}</p>
						</li>
						<li class="flex items-center justify-between mb-2">
							<div class="flex items-center gap-2">
								<x-lucide-ban class="w-5 h-5" />
								<p class="font-bold">{{ __('Banned') }}</p>	
							</div>
							<p class="text-muted">{{ $stats->banned }}</p>
						</li>
						<li class="flex items-center justify-between mb-2">
							<div class="flex items-center gap-2">
								<x-lucide-box class="w-5 h-5" />
								<p class="font-bold">{{ __('Total Categories') }}</p>	
							</div>
							<p class="text-muted">{{ $stats->categories }}</p>
						</li>
						<li class="flex items-center justify-between mb-2">
							<div class="flex items-center gap-2">
								<x-lucide-dock class="w-5 h-5" />
								<p class="font-bold">{{ __('Total Posts') }}</p>	
							</div>
							<p class="text-muted">{{ $stats->posts }}</p>
						</li>
						<li class="flex items-center justify-between mb-2">
							<div class="flex items-center gap-2">
								<x-lucide-message-square-text class="w-5 h-5" />
								<p class="font-bold">{{ __('Total Comments') }}</p>	
							</div>
							<p class="text-muted">{{ $stats->comments }}</p>
						</li>
					</ul>
				</div>
			@endif
		</div>

		<div class="w-full lg:w-3/4 text-main bg-card rounded-lg p-2 transition-all shadow-md hover:shadow-lg mb-4">
			<div class="w-full flex items-center justify-between px-5 pt-2">
				<h1 class="text-xl flex items-center gap-2 uppercase font-bold">
					<x-lucide-users />
					{{ __('Users') }}
				</h1>
				<a class="p-1 rounded-lg transition-all cursor-pointer bg-main hover:bg-card border-2 border-main-gray-dark" href="{{ route('user.index') }}">
					{{ __('All users') }}
				</a>
			</div>
			<div class="w-full mt-2 px-4 py-2">
				{!! $charts->users->render() !!}
			</div>
		</div>

		<div class="w-full lg:w-3/4 text-main bg-card rounded-lg p-2 transition-all shadow-md hover:shadow-lg mb-4">
			<div class="w-full flex items-center justify-between px-5 pt-2">
				<h1 class="text-xl flex items-center gap-2 uppercase font-bold">
					<x-lucide-dock />
					{{ __('Posts') }}
				</h1>
				<a class="p-1 rounded-lg transition-all cursor-pointer bg-main hover:bg-card border-2 border-main-gray-dark" href="{{ route('admin.post.index') }}">
					{{ __('All posts') }}
				</a>
			</div>
			<div class="w-full mt-2 px-4 py-2">
				{!! $charts->posts->render() !!}
			</div>
		</div>

		<div class="w-full lg:w-3/4 text-main bg-card rounded-lg p-2 transition-all shadow-md hover:shadow-lg mb-4">
			<div class="w-full flex items-center justify-between px-5 pt-2">
				<h1 class="text-xl flex items-center gap-2 uppercase font-bold">
					<x-lucide-message-square-text />
					{{ __('Comments') }}
				</h1>
			</div>
			<div class="w-full mt-2 px-4 py-2">
				{!! $charts->comments->render() !!}
			</div>
		</div>
	</div>
</x-admin-layout>