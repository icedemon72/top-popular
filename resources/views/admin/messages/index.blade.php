@section('title', 'Messages')

<x-admin-layout>
  <x-slot name="header">
		<div class="flex w-full justify-center">
			<h2 class="w-full flex gap-2 items-center md:w-4/5 lg:w-3/5 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight bg-white dark:bg-gray-800 p-4 rounded-lg">
				<x-lucide-mails />
				{{ __('Messages') }}
			</h2>
		</div>
	</x-slot>
	{{--  --}}

	<div x-data="{ open: false }" class="w-full flex flex-col items-center justify-center mt-7">
    <div class="flex w-full md:w-4/5 lg:w-4/5 justify-between items-center">
			<div x-on:click="open = !open" x-bind:class="open ? 'bg-card shadow-sm' : ''" class="flex gap-2 rounded-lg shadow-sm text-main	hover:bg-card p-2 cursor-pointer">
				<x-lucide-filter />
				{{ __('Filters') }}
			</div>
			<form class="flex" method="GET">
				<x-form.search-input class="bg-card" field="search" placeholder="{{ __('Search messages...') }}" value="{{ request()->input('search') }}" />
			</form>
    </div>
    <div x-collapse x-cloak x-show="open" class="w-full flex md:w-4/5 lg:w-4/5 mt-2">
      <form id="filters" class="w-full">
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-2">
          <div class="col-span-1">
            <p class="text-muted">{{ __('Status') }}</p>
						@foreach($status as $value)
            	<x-form.checkbox  field="status[]" value="{{ $value->status }}" text="{{ $value->status ? $value->status : 'Not assigned' }} ({{ $value->count }})" />
						@endforeach
          </div>

					<div class="col-span-1">
            <p class="text-muted">{{ __('Status') }}</p>
						@foreach($categories as $value)
            	<x-form.checkbox  field="category[]" value="{{ $value->category }}" text="{{ $value->category }} ({{ $value->count }})" />
						@endforeach
          </div>

					<div class="col-span-1">
						<p class="text-muted">{{ __('Date') }}</p>
						<x-form.checkbox type="radio" value="today" field="time" text="{{ __('Last 24h')}}" />
						<x-form.checkbox type="radio" value="week" field="time" text="{{ __('Last week')}}" />
						<x-form.checkbox type="radio" value="month" field="time" text="{{ __('Last month')}}" />
						<x-form.checkbox type="radio" value="year" field="time" text="{{ __('Last year')}}" />
					</div>
        </div>
        
        <x-form.submit class="mt-1">{{ __('Apply filters') }}</x-form.submit>
      </form>
    </div>
  </div>

	<div class="w-full flex flex-col items-center justify-center mt-1">
		<div class="flex w-full md:w-4/5 lg:w-4/5 justify-between items-center">
			<div class="flex flex-grow flex-col bg-card p-2 rounded-lg">
				@if (count($messages) > 0)
					@foreach ($messages as $message)
						@php
							$dayPassed = time() - strtotime($message->created_at) > 86400;
						@endphp
						<a href="{{ route('message.show', $message->id) }}" class="flex flex-grow jusitfy-between items-center gap-2 rounded-sm py-5 md:py-3 lg:py-2 p-2 cursor-pointer hover:bg-main hover:shadow-sm hover:border-l-4 border-blue-700 transition-all">
							<div class="flex items-center gap-2">
								<div class="uppercase text-main text-xs font-bold bg-main rounded-lg p-1">
									{{ $message->category }}
								</div>
								<span class="font-black text-main text-xs">{{ $message->user->username }}</span>
							</div>
							<div class="flex-1">
								<span class="font-bold text-main">{{ substr($message->title, 0, 16) }} -</span>
								<span class="text-muted">{{ substr($message->body, 0, 16) }}</span>
							</div>
							<div class="text-main font-bold flex items-center gap-2">
								@if($message->status)
									<div class="text-xs p-1 bg-main rounded-lg">{{ $message->status }}</div>
								@endif
								@if($dayPassed)
									{{ date_format(date_create($message->created_at), 'd.m.Y') }}
								@else
									{{ date_format(date_create($message->created_at), 'H:i') }}
								@endif
							</div>
						</a>	
					@endforeach	
				@else
					Hello
				@endif
			</div>
		</div>
	</div>
</x-admin-layout>