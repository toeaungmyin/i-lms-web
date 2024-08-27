<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
    <h3 class="font-semibold text-lg text-gray-800 leading-tight">Student's Courses</h3>
    <div class="p-6 text-gray-900">
        <form action="{{ route('dashboard.users.attachToCourse',$user->id) }}" method="POST">
            @csrf
            <div class="flex justify-between items-end gap-2">
                <div class="w-full">
                    <label for="courses" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select an option</label>
                    <select id="courses" name="course_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected>Choose a course</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id}}">{{ $course->title }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="inline-flex items-center px-4 py-3 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Attach') }}
                </button>
            </div>
        </form>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 py-4">
            @php
                if(request()->user()->is_role('instructor')){
                    $courses = $user->joinedCourses->where('instructor_id',Auth::id());
                } else {
                    $courses = $user->joinedCourses;
                }
            @endphp
            @foreach ($courses as $course)
                <div class="relative overflow-hidden rounded-lg shadow border group">
                    <img class="h-auto max-w-full" src="{{ asset($course->cover) }}" alt="">
                    <div class="min-h-[50%] p-2 absolute flex flex-col justify-center items-center w-full bg-blue-800/80 bottom-0 left-0 text-gray-100 transform translate-y-full group-hover:translate-y-0 group-hover:flex transition duration-200 ease-out">
                        <div class="flex flex-col items-center">
                            <h4 class="text-lg font-semibold text-center">
                                {{ $course->title }}
                            </h4>
                            <span class="">
                                by {{ $course->instructor->name }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
