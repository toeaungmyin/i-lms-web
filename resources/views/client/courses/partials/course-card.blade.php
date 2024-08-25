<div class="group relative">
    <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80">
        <img src="{{ $course->cover }}" alt="Front of men&#039;s Basic Tee in black." class="h-full w-full object-cover object-center lg:h-full lg:w-full">
    </div>
    <div class="mt-4 flex justify-between">
        <div>
        <h3 class="text-sm text-gray-700">
            <a href="{{ route('courses.show',$course->id) }}">
            <span aria-hidden="true" class="absolute inset-0"></span>
            {{ $course->title }}
            </a>
        </h3>
        <p class="mt-1 text-sm text-gray-500">{{ $course->category ? $course->category->name : '' }}</p>
        </div>
        <p class="text-sm font-medium text-gray-900">{{ $course->instructor->name }}</p>
    </div>
</div>
