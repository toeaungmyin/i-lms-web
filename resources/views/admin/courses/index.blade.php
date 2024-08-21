<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Courses') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center py-6 gap-2">
                    <x-search-form/>
                    <div class="flex py-1.5">
                        <a href="{{ route('dashboard.courses.create') }}" class="text-white text-center uppercase bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded text-sm px-5 py-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">{{ __('New Course') }}</a>
                    </div>
                </div>
                @include('admin.courses.partials.courses-table')
                {{ $courses->onEachSide(1)->links() }}
            </div>
        </div>
    </div>

    @push('post-scripts')

    @endpush
</x-app-layout>

{{-- @vite(['resources/js/admin/user.js']) --}}

