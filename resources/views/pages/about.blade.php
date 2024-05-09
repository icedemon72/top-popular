@section('title', 'About Us')

<x-master-layout>
	<x-slot name="header">
		<div class="flex w-full justify-center">
			<h2 class="w-full md:w-4/5 lg:w-3/5 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight bg-white dark:bg-gray-800 p-4 rounded-lg">
					{{ __('About') }}
			</h2>
		</div>
	</x-slot>

	<div class="bg-card mt-5 rounded-lg">
		<section id="section_1" class="h-screen max-h-screen mt-5 flex flex-col justify-center items-center">
			<img class="w-36 h-36" src="{{ asset('storage/images/icon/main.png') }}" alt="Top Popular logo" />
			<h1 class="text-main text-3xl font-bold">Top Popular</h1>
			<p class="text-muted text-xl">{{ __('Become part of the story') }}</p>
			<div class="w-full lg:w-96 text-justify mt-1">
				<p class="text-muted mx-12 lg:mx-0">
					{{ 
						__('Whether it\'s the latest cool trends, innovative startups, or the future of AI, We\'re always eager to dive deep and explore new ideas within our great community. 
						Feel free to reach out if you\'re interested in talking about stuff, however big or small, important or unimportant, heavy or light the topic is. 
						Let\'s connect and grow together!') 
					}}
				</p>
			</div>

			<a href="#section_2" class="w-full flex justify-center group mt-6">
				<x-lucide-chevron-down class="bg-main border border-main rounded-full w-10 h-10 group-hover:animate-bounce" />
			</a>
		
		</section>

		<section id="section_2" class="min-h-screen mt-5 flex flex-col justify-center items-center">
			<h1 class="text-main text-3xl font-bold">{{ __('So, what\'s it all about?') }}</h1>
			<div class="w-full lg:w-96 text-justify mt-1">
				<p class="text-muted mx-12 lg:mx-0">
					{{ 
						__('Top Popular is home of many communities, with endless conversation and geniune human connection! Whether you\'re into breaking news, sports, TV fan theories, or a never-ending stream of the internet\'s cutest animals, there\'s a community for you.') 
					}}
				</p>
			</div>
			
			<a href="{{ route('home') }}" class="bg-main rounded-full border-2 transition-all border-main-gray-dark mt-4 py-2 px-4 text-main hover:bg-card ">{{ __('Visit Top Popular') }}</a>
			
			<div class="w-full mx-6 md:w-4/5 xl:w-3/4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-4 text-main">
				<div class="col-span-1 p-4 bg-main md:rounded-lg md:border border-main">
					<div class="flex gap-2 items-center font-bold">
						<x-lucide-box />
						{{ __('Categories') }}
					</div>
					<div class="mt-1">
						{{ __('There exists a broad set of categories for almost everyone to dwell in and share their thoughts.') }}
					</div>
				</div>
				<div class="col-span-1 p-4 bg-main md:rounded-lg md:border border-main">
					<div class="flex gap-2 items-center font-bold">
						<x-lucide-dock />
						{{ __('Posts') }}
					</div>
					<div class="mt-1">
						{{ __('Everyone can share their thoughts on almost every topic imaginable by posting stories, links, images, videos etc.') }}
					</div>
				</div>
				<div class="col-span-1 p-4 bg-main md:rounded-lg md:border border-main">
					<div class="flex gap-2 items-center font-bold">
						<x-lucide-messages-square />
						{{ __('Comments') }}
					</div>
					<div class="mt-1">
						{{ __('Have something to add? Continue the discussion by sharing your point of view!') }}
					</div>
				</div>
			</div>
		</section>
	</div>

	<section id="section_3" class="mt-10 flex flex-col justify-center items-center">
		<h1 class="text-main text-3xl font-bold">{{ __('Top Popular by the Numbers') }}</h1>
		<div class="w-full lg:w-96 text-center mt-1">
			<p class="text-muted mx-12 lg:mx-0">
				{{ __('For all \'em stats nerds') }}
			</p>
		</div>

		<div class="w-full mx-6 md:w-4/5 xl:w-3/4 grid grid-cols-2 md:grid-cols-4 gap-4 mt-4 text-main">
			<div class="col-span-1 p-8 bg-card rounded-lg border border-main flex flex-col items-center justify-between">
				<x-lucide-user />
				<p class="text-3xl font-bold">{{ $stats->users }}</p>
				<p class="text-muted">{{ __('Users') }}</p>
			</div>
			<div class="col-span-1 p-8 bg-card rounded-lg border border-main flex flex-col items-center justify-between">
				<x-lucide-box />
				<p class="text-3xl font-bold">{{ $stats->categories }}</p>
				<p class="text-muted">{{ __('Categories') }}</p>
			</div>
			<div class="col-span-1 p-8 bg-card rounded-lg border border-main flex flex-col items-center justify-between">
				<x-lucide-dock />
				<p class="text-3xl font-bold">{{ $stats->posts }}</p>
				<p class="text-muted">{{ __('Posts') }}</p>
			</div>
			<div class="col-span-1 p-8 bg-card rounded-lg border border-main flex flex-col items-center justify-between">
				<x-lucide-messages-square />
				<p class="text-3xl font-bold">{{ $stats->comments }}</p>
				<p class="text-muted">{{ __('Comments') }}</p>
			</div>
		</div>
	</section>

</x-master-layout>