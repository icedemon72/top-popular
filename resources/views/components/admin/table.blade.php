@props(['cols' => [], 'data', 'types', 'actions' => [], 'route'])

{{-- TODO: iterate only through provided types --}}

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
	<table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
		<thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
			<tr>
				@foreach ($cols as $col)
					<th class="px-6 py-4">{{ $col }}</th>
				@endforeach
			</tr>
		</thead>
		<tbody>
			@foreach($data as $col)
				<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
					@foreach($col->toArray() as $key => $value)
					<td class="px-6 py-4">
						@if($types[$key] == 'date')
							@if(isset($value)) 
								{{ date('d.m.Y H:i', strtotime($value)) }}
							@else
								-
							@endif
						@elseif ($types[$key] == 'icon')
							<img src="{{ asset("/storage/$value") }}" width="24" height="24"/>
						@else
							{{ $value }}
						@endif
					</td>
					@endforeach
					
					@if(sizeof($actions) != 0 && isset($route))
					<td class="flex items-center px-6 py-4">
						@if (in_array('edit', $actions))
							<a href="{{ route("{$route}.edit", $col->id) }}">
								<x-lucide-pencil />
							</a>
						@endif
						{{-- TODO: add delete? --}}
					</td>
					@endif
				</tr>
			@endforeach
			{{ $slot }}
		</tbody>
	</table>
</div>