

@php
	use Carbon\Carbon;
	$edited = $data->created_at != $data->updated_at;
	$type = $likeObj->type ?? null;
	$categoryName = $data->category->name;
@endphp

@section('title', "$data->title: $categoryName")

<script type="text/javascript">
	document.addEventListener('DOMContentLoaded', function() {
		handleModal("{{ route('post.destroy', ':id') }}");
	});
</script>

<x-master-layout>
	<x-modals.delete text="{{ __('Are you sure you want to delete the post?') }}" />
	<div x-data="{commentOpen: false}" class="w-full flex flex-col justify-cente items-center">
		{{-- POST --}}
		<div class="w-full md:w-4/5 lg:w-3/5 bg-card rounded-lg p-4">
			@if(session('edited'))
				<x-form.success>
					{{ __('Post edited successfully') }}
				</x-form.success>
			@endif
			<div  x-data="{open: false}" class="flex items-center justify-between">
				<div class="flex items-center gap-1">
					<a class="hover:bg-main rounded-xl" href="{{ route('post.index', $data->category_id) }}">
						<x-lucide-arrow-left />
					</a>
					<div class="flex items-center gap-2">
						<a href="{{ route('user.show', $data->poster->username) }}" class="text-xs text-main font-bold hover:underline underline-offset-1 cursor-pointer">
							{{ $data->poster->username }}
						</a> 
						<x-profile.badge role="{{ $data->poster->role }}" />
					</div>
					<p class="text-xs text-muted">•</p>
					<p class="text-xs text-muted cursor-default" title="{{ $data->created_at }}">{{ Carbon::parse($data->created_at)->diffForHumans() }}</p>
					@if($edited)
						<p class="text-xs text-muted cursor-default" title="{{ $data->updated_at }}">(Edited)</p>
					@endif
				</div>
				<div class="select-none">
					<div x-on:click="open = !open" x-on:click.outside="open = false" class="flex items-center hover:bg-main p-2 rounded-xl text-main cursor-pointer">
						<svg x-cloak x-show="!open" class="w-4 h-4" rpl="" fill="currentColor" icon-name="overflow-horizontal-fill" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <!--?lit$164882748$--><!--?lit$164882748$--><path d="M6 10a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm6 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z"></path><!--?--> </svg>
						<x-lucide-circle-x x-cloak x-show="open" class="w-4 h-4" />
					</div>
					<x-animation.pop-in class="relative" open="open">
						@if(Auth::check())
							<x-posts.dropdown>
								@if(in_array(Auth::user()->role, ['admin', 'moderator']) || Auth::user()->id == $data->user_id)
									<x-nav.dropdown-link class="flex items-center gap-2" href="{{ route('post.edit', ['category' => $data->category_id, 'post' => $data->id]) }}">
										<x-lucide-pencil />
										{{ __('Edit') }}
									</x-nav.dropdown-link>
									<x-nav.dropdown-link class="modalTrigger flex items-center gap-2 text-red-500" data-trigger="{{ $data->id }}">
										<x-lucide-trash-2 />
										{{ __('Delete') }}
									</x-nav.dropdown-link>
								@endif
								@if(in_array(Auth::user()->role, ['admin', 'moderator']))
									@if($data->archived)
									<form method="POST" action="{{ route('post.archive', ['post' => $data->id, 'status' => 0]) }}">
										@method('PATCH')
										@csrf
										<x-nav.dropdown-link class="flex items-center gap-2 cursor-pointer">
											<x-lucide-archive-x />
											<button type="submit">
												{{ __('Re-publish') }}
											</button>
										</x-nav.dropdown-link>
									</form>
									@else
										<x-nav.dropdown-link class="cursor-pointer">
											<form class="flex items-center gap-2" method="POST" action="{{ route('post.archive', ['post' => $data->id, 'status' => 1]) }}">
												@method('PATCH')
												@csrf
												<x-lucide-archive-restore />
												<button type="submit">
													{{ __('Archive') }}
												</button>
											</form>
										</x-nav.dropdown-link>
									@endif
								@endif
								@if(Auth::check() && Auth::user()->id != $data->id)
									<x-nav.dropdown-link class="flex items-center gap-2" href="#">
										<x-lucide-flag />
										{{ __('Report') }}
									</x-nav.dropdown-link> {{-- {{ route('post.edit', ['category' => $data->category_id, 'post' => $data->id]) }} --}}
								@endif
							</x-posts.dropdown>		
						@endif
					</x-animation.pop-in>
				</div>	
			</div>

			<div class="mt-2">
				<h1 class="text-xl text-main font-bold">{{ $data->title }}</h1>
				<div class="flex mt-1 items-center">
					@foreach($data->tags as $tag)
					<a href="#" class="flex items-center gap-1 p-2 rounded-full text-xs text-main bg-main hover:bg-card hover:underline">
							<x-lucide-tag class="w-3 h-3"/>
							{{ $tag->name }}
						</a>
					@endforeach
				</div>
				<div class="text-main">{{ $data->body }}</div>
			</div>

			<div class="mt-2 flex justify-between lg:justify-start items-center gap-8 text-main">
				<div id="post_{{ $data->id }}" class="flex gap-5 md:gap-3 lg:gap-1 items-center">
					<div id="post_likes" class="p-1 hover:bg-main rounded-lg cursor-pointer {{ $type == 'like' ? 'bg-main' : '' }}" onClick="giveLike('like', '{{ $data->id }}', '{{ route('post.like', ['post' => $data->id]) }}', '{{ csrf_token() }}')">
						<x-lucide-arrow-big-up-dash class="w-8 h-8 md:w-6 md:h-6 lg:w-5 lg:h-5 text-green-500" />
					</div>
					<p id="post_likes_count" class="lg:text-xs font-bold mr-1">{{ $data->likeCount}}</p>
		
					<div id="post_dislikes" class="p-1 hover:bg-main rounded-lg cursor-pointer {{ $type == 'dislike' ? 'bg-main' : '' }}" onClick="giveLike('dislike', '{{ $data->id }}', '{{ route('post.like', ['post' => $data->id]) }}', '{{ csrf_token() }}')">
						<x-lucide-arrow-big-down-dash class="w-8 h-8 md:w-6 md:h-6 lg:w-5 lg:h-5 text-red-500 " />
					</div>
					
					<p id="post_dislikes_count" class="lg:text-xs font-bold">{{ $data->dislikeCount }}</p>
				</div>
		
				<a class="flex items-center gap-1 hover:bg-main rounded-lg p-2" href="#comments">
					<x-lucide-message-square-text class="w-8 h-8 md:w-6 md:h-6 lg:w-5 lg:h-5" />
					<p class="text-xs font-bold">{{ count($comments) }}</p>
				</a>
		
				<div x-data="{
					link: '{{ route('post.show', ['post' => $data->id, 'category' => $data->category_id]) }}',
					timeout: null,
					copied: false,
					open: false,    
					copy () {
						$clipboard(this.link);
						this.copied = true;
						clearTimeout(this.timeout);
		
						this.timeout = setTimeout(() => {
							this.copied = false;
						}, 2000)
					}
				}" x-on:click.outside="open = false" >
					<div x-on:click="open = !open" class="flex items-center gap-1 hover:bg-main rounded-lg p-2 cursor-pointer">
						<x-lucide-square-arrow-out-up-right class="w-8 h-8 md:w-6 md:h-6 lg:w-5 lg:h-5" />
						<p class="lg:text-xs">{{ __('Share') }}</p>
					</div>
					<div x-on:click="copy">
						<x-animation.pop-in class="relative" open="open">
							<x-posts.dropdown open="open" class="absolute w-72">
								<div>
									<h2 class="text-md text-main text-center font-semibold mb-2">{{ __('Share the post') }}</h2>
									<div class="flex items-center justify-between relative w-full border-b-2 text-main dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm p-2 ">
										<div class="flex gap-1 items-center">
											<x-lucide-link-2 class="w-3 h-3" />
											<p class="text-xs flex items-center overflow-x-auto select-none">
													{{ route('post.show', ['category' => $data->category_id, 'post' => $data->id]) }}
											</p>
										</div>
										<x-lucide-copy x-cloak x-show="!copied" class="w-4 h-4 cursor-pointer" />
										<x-lucide-circle-check-big x-cloak x-show="copied" class="w-4 h-4 cursor-pointer text-green-500" />									
									</div>
	
									<div class="mt-2 p-2">
										<p class="text-xs text-muted">{{ __('You can copy the link by clicking the button above or by doing it manually.') }}</p>
									</div>
								</div>
							</x-posts.dropdown>
						</x-animation.pop-in>
					</div>
				</div>
			</div>
			
		</div>

		{{-- COMMENTS --}}
		<div class="w-full md:w-4/5 lg:w-3/5 flex items-center gap-3 bg-card rounded-lg p-4 mt-5 font-bold text-main">
			COMMENTS ({{ count($comments) }})
			@if(!$data->archived)
				@if(Auth::check())
					<button x-on:click="commentOpen = !commentOpen" class="text-xs uppercase bg-main rounded-lg p-2 text-main hover:bg-card">
						{{ __('Add a comment') }}
					</button>
				@else
					<span class="text-muted"><a href="{{ route('login') }}" class="underline hover:text-main">Login</a> to post a comment...</span>
				@endif
			@else 
				<span class="text-muted text-sm">{{ __('This post has been archived, new comments cannot be made.') }}</span>
			@endif
		</div>

		<div :class="{'block': commentOpen, 'hidden': !commentOpen}" class="hidden w-full md:w-4/5 lg:w-3/5 bg-card rounded-lg p-4 mt-1">
			<form class="w-full" method="POST" action="{{ route('comment.store', ['post' => $data->id]) }}">
				@csrf

				<x-form.label class="my-1" for="body" text="{{ __('Comment body') }}" />
				<x-form.text-area class="w-full" placeholder="Your comment" field="body" :required="true"/>
				<div class="flex flex-1 justify-end">
					<x-form.submit class="mt-2">{{ __('Post a comment') }}</x-form.submit>
				</div>
			</form>
		</div>

		<div class="w-full md:w-4/5 lg:w-3/5 bg-card rounded-lg p-4 mt-3">
			<div class="flex items-center mb-2 p-1 gap-2">
				<x-lucide-arrow-down-narrow-wide class="w-5 h-5 text-muted" />
				<div class="flex items-center cursor-pointer bg-main rounded-xl">
					<select id="select1" onChange="changePopularity()" class="appearance-none bg-main text-xs text-muted p-2 cursor-pointer hover:bg-card rounded-xl">
						<option value="popular">{{ __('Popular') }}</option>
						<option value="new">{{ __('New') }}</option>
						<option value="top">{{ __('Top') }}</option>
					</select>
				</div>
				<div class="flex items-center cursor-pointer bg-main rounded-xl" id="comments">
					<select id="select1" onChange="changePopularity()" class="appearance-none bg-main text-xs text-muted p-2 cursor-pointer hover:bg-card rounded-xl">
						<option value="today">{{ __('Today') }}</option>
						<option value="week">{{ __('This week') }}</option>
						<option value="month">{{ __('This month') }}</option>
						<option value="year">{{ __('This year') }}</option>
						<option value="all">{{ __('All') }}</option>
					</select>
				</div>
			</div>
			@foreach($comments as $comment) 
				@if($comment->parent === null)
					<div x-data="{ open: false }" class="{{ count($comment->replies) > 0 ? 'border-l-gray-400 border-l-2 p-2' : '' }}">
						<x-posts.comment :comment="$comment" :op="$data->user_id" :archived="$data->archived"/>
					</div>
				@endif
			@endforeach
		</div>

	</div>
</x-master-layout>