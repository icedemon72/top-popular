@props(['categories'])

<section {{ $attributes->merge(['class' => "w-full flex overflow-x-auto" ])}} >
    <div class="min-w-full flex flex-nowrap items-center pb-4">
        @foreach($categories as $category)
            <div class="inline-block px-3 ">
                <a href="{{ route('post.index', $category->id) }}" class="w-40 h-40 flex flex-col items-center justify-center rounded-lg text-main shadow-md bg-card hover:shadow-xl transition-shadow duration-300 ease-in-out cursor-pointer">
                    <img class="w-16 h-16 dark:bg-slate-200 rounded-full p-2" src="{{ asset("storage/".$category->icon) }}" alt="{{ $category->name }}'s icon" />
                    <h1 class="font-bold text-2xl">{{ $category->name }}</h1>
                </a>
            </div>
        @endforeach
    </div>
</section>