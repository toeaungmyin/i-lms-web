<x-client-layout>
    <div class="md:mt-12 md:mx-16 flex gap-8 flex-col overflow-hidden bg-white md:rounded-md !rounded-b-none shadow-sm px-4 md:px-12 pt-12 pb-24">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 md:gap-8">
            <x-search-form/>
            <x-date-filter/>
        </div>
        <div class="flex items-center justify-center py-4 md:py-8 flex-wrap">
            <button type="button" class="text-gray-700 hover:text-white border border-gray-600 bg-white hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-full text-base font-medium px-5 py-2.5 text-center me-3 mb-3 dark:bg-gray-900">All categories</button>
            @foreach ($categories as $category)
                <button type="button" class="text-gray-900 border border-white hover:border-gray-200 dark:border-gray-900 dark:bg-gray-900 dark:hover:border-gray-700 bg-white focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-full text-base font-medium px-5 py-2.5 text-center me-3 mb-3 dark:text-white dark:focus:ring-gray-800">{{ $category->name }}</button>
            @endforeach
        </div>
        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
            @foreach ($courses as $course)
                @include('client.courses.partials.course-card')
            @endforeach
        </div>
        @include('client.courses.partials.components.pagination')
    </div>
</x-client-layout>
