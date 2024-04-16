<aside id="default-sidebar" class="fixed top-16 left-0 bottom-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">
       <div class="space-y-2 font-medium flex flex-col justify-center">
          <x-admin.sidebar-item  :active="request()->routeIs('admin.index')">{{ __('Dashboard') }}</x-admin.sidebar-item>

          <x-admin.sidebar-title>{{ __('Forum') }}</x-admin.sidebar-title>
          <x-admin.sidebar-item>{{ __('Categories') }}</x-admin.sidebar-item>
          <x-admin.sidebar-item>{{ __('Tags') }}</x-admin.sidebar-item>
          <x-admin.sidebar-item>{{ __('Posts') }}</x-admin.sidebar-item>


          <x-admin.sidebar-title>{{ __('Users') }}</x-admin.sidebar-title>
          <x-admin.sidebar-item>{{ __('Users') }}</x-admin.sidebar-item>
          <x-admin.sidebar-item>{{ __('Mods') }}</x-admin.sidebar-item>

          <x-admin.sidebar-title>{{ __('Support') }}</x-admin.sidebar-title>
          <x-admin.sidebar-item>{{ __('Messages') }}</x-admin.sidebar-item>
          <x-admin.sidebar-item>{{ __('Logs') }}</x-admin.sidebar-item>
       </div>
    </div>
 </aside>