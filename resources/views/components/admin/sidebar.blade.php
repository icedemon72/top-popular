<aside id="default-sidebar" class="fixed top-16 left-0 bottom-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">
       <div class="font-medium flex flex-col justify-center">
         <x-admin.sidebar-item :href="route('admin.index')" :active="request()->routeIs('admin.index')">
            <x-lucide-layout-dashboard />
            {{ __('Dashboard') }}
         </x-admin.sidebar-item>

         <x-admin.sidebar-title>{{ __('Forum') }}</x-admin.sidebar-title>

         <x-admin.sidebar-item :href="route('admin.post.index')" :active="request()->routeIs('admin.post.index')">
            <x-lucide-dock />
               {{ __('Posts') }}
         </x-admin.sidebar-item>

         @if(Auth::user()->role == 'admin')
            <x-admin.sidebar-item :href="route('category.index')"  :active="request()->routeIs('category.index') || request()->routeIs('category.create')">
               <x-lucide-box />
               {{ __('Categories') }}
            </x-admin.sidebar-item>
            
         @endif
            
         <x-admin.sidebar-item :href="route('tag.index')" :active="request()->routeIs('tag.index') || request()->routeIs('tag.create') || request()->routeIs('tag.edit')">
            <x-lucide-tag />
            {{ __('Tags') }}
         </x-admin.sidebar-item>
         

         <x-admin.sidebar-title>{{ __('Users') }}</x-admin.sidebar-title>
         <x-admin.sidebar-item :href="route('user.index')" :active="request()->routeIs('user.index')">
            <x-lucide-users />
            {{ __('Users') }}
         </x-admin.sidebar-item>
         @if(Auth::user()->role == 'admin')
            <x-admin.sidebar-item :href="route('mod.index')" :active="request()->routeIs('mod.index')">
               <x-lucide-shield-plus />
               {{ __('Moderators') }}
            </x-admin.sidebar-item>
         @endif
         <x-admin.sidebar-item :href="route('admin.user.ban')" :active="request()->routeIs('admin.user.ban')">
            <x-lucide-ban />
            {{ __('Bans') }}
         </x-admin.sidebar-item>

         @if(Auth::user()->role == 'admin')
            <x-admin.sidebar-title>{{ __('Support') }}</x-admin.sidebar-title>
            <x-admin.sidebar-item :href="route('message.index')" :active="request()->routeIs('message.index') || request()->routeIs('message.show')">
               <x-lucide-mails />
               {{ __('Messages') }}
            </x-admin.sidebar-item>
            <x-admin.sidebar-item>
               <x-lucide-scroll-text />
               {{ __('Logs') }}
            </x-admin.sidebar-item>
         @endif
       </div>
    </div>
 </aside>