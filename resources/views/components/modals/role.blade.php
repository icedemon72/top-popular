@php
    $roles = [
        [ 'value' => 'user', 'name' => 'User' ],
        [ 'value' => 'moderator', 'name' => 'Moderator' ],
    ];
@endphp

@section('head')
	<link href="{{ asset('vendor/bladewind/css/animate.min.css') }}" rel="stylesheet" />
	<script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>
@endsection

<div id="roleModal" aria-hidden="true" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center md:inset-0 w-screen h-screen md:h-full">
    <div class="blur-lg bg-black opacity-60 z-40 h-screen w-screen absolute top-0 right-0" onClick="closeModal('roleModal')"></div>
    <div class="relative z-50  p-4 w-full max-w-md h-full md:h-auto" x-on:click.outside="open = false">
        <!-- Modal content -->
        <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
            <form id="roleForm" action="" method="POST">
                @method('PATCH')
                @csrf
                <button onClick="closeModal('roleModal')" type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg- nsparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="deleteModal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <x-lucide-award class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" />
                <div class="text-start">
                    <x-form.label for="role" :text="__('Role')" />
                </div>
                <x-bladewind::select 
                    id="role"
                    required="true"
                    name="role"
                    label_key="name"
                    value_key="value"
                    :placeholder="__('Select role')"
                    :data="$roles"
                />                
                <div class="flex justify-center items-center space-x-4">
                    <x-form.cancel onClick="closeModal('roleModal')" data-dismiss="modal" type="button" class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                        {{ __('Cancel') }}
                    </x-form.cancel>
                    <x-form.submit>
                        {{ __('Confirm') }}
                    </x-form.submit>
                    {{-- <button type="submit" class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                        {{ __('Confirm') }}
                    </button> --}}
                </div>
            </form>    
        </div>
    </div>
</div>