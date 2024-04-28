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

	<div class="w-full flex flex-col items-center justify-center mt-7">
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