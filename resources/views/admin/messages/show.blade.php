@section('title', 'Message')

@php
  $status = ['Completed', 'Ignored', 'TODO'];
@endphp


<x-master-layout>
  <x-slot name="header">
		<div class="flex w-full justify-center">
			<h2 class="w-full flex gap-2 items-center md:w-4/5 lg:w-3/5 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight bg-white dark:bg-gray-800 p-4 rounded-lg">
				<a class="p-1 hover:bg-main rounded-lg cursor-pointer" href="{{ route('message.index') }}">
          <x-lucide-arrow-left class="w-8 h-8 md:w-6 md:h-6 lg:w-5 lg:h-5" />
        </a>
        <x-lucide-mail />
				{{ __('Message') }}
			</h2>
		</div>
	</x-slot>

  <div class="w-full flex flex-col items-center justify-center mt-7">
		<div class="flex flex-col w-full md:w-4/5 lg:w-4/5 justify-center items-start bg-card p-2 px-4 rounded-lg">
      <h1 class="flex items-center gap-3 text-3xl text-main">
        {{ $message->title }}
        <span class="bg-main px-2 py-1 rounded-lg text-sm cursor-pointer">{{ $message->category }}</span>
      </h1>
      <div class="flex w-full justify-between gap-2 items-center border-b-2 pb-3">
        <div>
          <a href="{{ route('user.show', $message->user->username) }}" class="text-main text-sm font-bold">{{ $message->user->username }}</a>
          <span class="text-muted text-xs">&lt;{{ $message->user->email }}&gt;</span>
        </div>
        <span class="text-sm text-muted">{{ $message->created_at }}</span>
      </div>
      <div class="mt-3 text-muted">
        {{ $message->body }}
      </div>

      <form class="flex w-full justify-end mt-5 gap-2" method="POST" action="{{ route('message.updateStatus', $message->id) }}">
        @method('PATCH')
        @csrf
        <select class='dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm p-2 cursor-pointer' name="status">
          @foreach($status as $option)
            <option :value="$option">{{ $option }}</option>
          @endforeach
        </select>
        <x-form.submit>{{ __('Set status') }}</x-form.submit>
      </form>
    </div>
  </div>
</x-master-layout>