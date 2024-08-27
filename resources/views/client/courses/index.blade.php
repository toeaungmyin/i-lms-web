<x-client-layout>
    <div class="md:mt-12 md:mx-16 flex gap-8 flex-col overflow-hidden bg-white md:rounded-md !rounded-b-none shadow-sm px-4 md:px-12 pt-12 pb-24">
        <div class="flex justify-center items-center">
            <x-search-form/>
        </div>
        <div class="flex items-center justify-center py-4 md:py-8 flex-wrap">
            <a href="{{ route('courses') }}"
            @if (!request()->input('category'))
                class="text-white bg-gray-400 hover:bg-gray-500 focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-full text-base font-medium px-5 py-3 text-center me-3 mb-3"
            @else
                class="text-gray-700 border-2 border-white hover:border-gray-400 bg-white focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-full text-base font-medium px-5 py-2.5 text-center me-3 mb-3"
            @endif
            >All categories</a>
            @foreach ($categories as $category)
                <a href="{{ route('courses', ['category' => $category->id]) }}"
                    @if (request()->input('category') == $category->id)
                        class="text-white bg-gray-400 hover:bg-gray-500 focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-full text-base font-medium px-5 py-3 text-center me-3 mb-3"
                    @else
                        class="text-gray-700 border-2 border-white hover:border-gray-400 bg-white focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-full text-base font-medium px-5 py-2.5 text-center me-3 mb-3"
                    @endif
                >{{ $category->name }}</a>
            @endforeach
        </div>
        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
            @foreach ($courses as $course)
                @include('client.courses.partials.course-card')
            @endforeach
        </div>
        {{-- @include('client.courses.partials.components.pagination') --}}
        {{ $courses->onEachSide(1)->links() }}
    </div>
</x-client-layout>
