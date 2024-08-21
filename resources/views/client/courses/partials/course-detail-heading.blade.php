<div class="flex gap-8">
    <img class="w-1/3 object-cover aspect-[4/3] rounded" src="{{ asset($course->cover) }}" alt="{{ $course->title }}">
    <div class="w-2/3 flex flex-col gap-6 justify-center">
        <div class="flex flex-col items-start gap-2">
            <h1 class="text-4xl font-bold text-gray-800">{{ $course->title }}</h1>
            <p class="text-lg font-medium text-gray-900">{{ 'Instructor : '.$course->instructor->name }}</p>
            <div class="text-gray-900 border-4 border-gray-200  bg-white rounded-full text-base font-medium px-5 py-1.5 text-center me-3 mb-3">{{ $course->category->name }}</div>
        </div>
        <p class="text-lg text-gray-900">{{ $course->description }}</p>
    </div>
</div>
