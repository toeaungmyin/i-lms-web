<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12 relative">
        @session('message')
            <div class="absolute top-0 w-full p-3 text-center bg-red-100">
                {{ $value }}
            </div>
        @endsession
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between py-6">
                        <x-search-form/>
                        <div class="flex py-1.5">
                            <x-primary-button>{{ __('New User') }}</x-primary-button>
                        </div>
                    </div>
                    @include('admin.users.partials.users-table')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
