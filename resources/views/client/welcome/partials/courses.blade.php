<div class="bg-white" id="course">
  <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
    <h2 class="text-3xl mb-12 font-bold tracking-tight text-gray-900 text-center uppercase">Courses</h2>

        <div class="flex items-center justify-center py-4 md:py-8 flex-wrap">
            <a href="{{ route('welcome') }}"
                @if (!request()->input('category'))
                    class="text-white bg-gray-400 hover:bg-gray-500 focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-full text-base font-medium px-5 py-3 text-center me-3 mb-3"
                @else
                    class="text-gray-700 border-2 border-white hover:border-gray-400 bg-white focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-full text-base font-medium px-5 py-2.5 text-center me-3 mb-3"
                @endif
            >
                All categories
            </a>
            @foreach ($categories as $category)
                <a href="{{ route('welcome', ['category' => $category->id]) }}"
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
</div>

