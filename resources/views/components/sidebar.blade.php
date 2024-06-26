<aside id="default-sidebar" class="fixed top-16 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0 border-r dark:border-gray-700" aria-label="Sidebar">
   <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">
      <ul class="space-y-2 font-medium">
         @foreach ($categories as $category)
            <x-sidebar-item active="{{ request()->is('post.index', $category->id) }}" href="{{ route('post.index', $category->id) }}">
               <div class="dark:bg-slate-200 p-2 rounded-full">
                  <img src="{{ asset("/storage/{$category->icon}") }}" class="w-6 h-6" alt="{{ $category->name }} icon" />
               </div>
               <span class="ms-3">{{ $category->name }}</span>
            </x-sidebar-item>
         @endforeach
      </ul>
   </div>
</aside>