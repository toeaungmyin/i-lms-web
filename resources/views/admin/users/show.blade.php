<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $user->name.' ('.$user->STDID.') '."'s ".'Profile' }}
        </h2>
    </x-slot>


    <div class="max-w-7xl mx-auto flex flex-col gap-8 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                @include('admin.users.partials.edit-user-form')
            </div>
        </div>

        @include('admin.users.partials.student-courses-form')
    </div>

</x-app-layout>


