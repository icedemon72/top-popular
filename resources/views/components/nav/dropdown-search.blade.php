@props(['categories', 'show' => 'filterOpen'])

<script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>
<div x-cloak x-show="{{ $show }}" class="absolute flex justify-center top-[64px] left-0 md:left-[256px] w-full md:w-[calc(100%_-_256px)] h-screen bg-black/50">
    <div {{-- x-on:click.outside="{{ $show }} = !{{ $show }}" --}} class="w-full md:w-2/3 lg:w-5/12 h-full md:h-1/2 md:min-h-[300px] lg:h-[5/12] lg:min-h-[425px] xl:h-1/3 xl:min-h[350px] bg-card border-x border-b border-main p-4 shadow-sm">
        <div class="text-sm text-main flex items-center justify-between">
            <div class="flex items-center gap-2">
                <x-lucide-filter />
                {{ __('Filters') }}
            </div>
            <x-lucide-circle-x class="cursor-pointer hover:bg-main transition-all rounded-full" x-on:click="{{ $show }} = !{{ $show }}" />
        </div>
        <div class="mt-2 p-2">
            <form id="searchFilters" class="w-full">
                <div class="grid grid-cols-2 lg:grid-cols-3 gap-2">
                    <div class="col-span-1">
                        <p class="text-muted">{{ __('Date') }}</p>
                        <x-form.checkbox type="radio" value="today" field="time" text="{{ __('Last 24h')}}" />
                        <x-form.checkbox type="radio" value="week" field="time" text="{{ __('Last week')}}" />
                        <x-form.checkbox type="radio" value="month" field="time" text="{{ __('Last month')}}" />
                        <x-form.checkbox type="radio" value="year" field="time" text="{{ __('Last year')}}" />
                    </div>
                    <div class="col-span-1">
                        <p class="text-muted">{{ __('Status') }}</p>
                        <x-form.checkbox type="radio" value="1" field="archived" text="{{ __('Archived')}}" />
                        <x-form.checkbox type="radio" value="false" field="archived" text="{{ __('Not archived')}}" />
                    </div>
                    <div class="col-span-full">
                        <p class="text-muted">{{ __('Category') }}</p>
                    </div>
                </div>
                <x-bladewind::select 
                    id="category"
                    name="category"
                    searchable="true"
                    selected_value="{{ request('category') ?? null }}"
                    label_key="name"
                    value_key="id"
                    required="true"
                    placeholder="{{ __('Select a category') }}"
                    :data="$categories"
                />
                {{-- <select name="bw-select category">
                    <option value="0">{{ __('Search everywhere') }}</option>
                    @foreach($categories as $category)
                        <option :value="$category->id">{{ $category->name }}</option>
                    @endforeach
                </select> --}}
                </form>
        </div>
    </div>
</div>
