<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Cover
                </th>
                <th scope="col" class="px-6 py-3">
                    Title
                </th>
                <th scope="col" class="px-6 py-3">
                    Category
                </th>
                <th scope="col" class="px-6 py-3">
                    Instructor
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($courses as $course)
                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                    <td class="px-6 py-4">
                        <img src="{{ asset($course->cover) }}" class="aspect-square object-cover w-full min-w-32 h-32 rounded-md" alt="{{ $course->title }}">
                    </td>
                    <th scope="row" class="px-6 py-4 font-medium max-w-sm text-gray-900 whitespace-nowrap dark:text-white">
                        <div class="flex flex-col gap-2">
                            <a href="{{ route('dashboard.courses.show',$course->id) }}" class="text-lg font-semibold hover:underline">{{ $course->title }}</a>
                            <p class="text-wrap text-justify">
                                {{ $course->description }}
                            </p>
                        </div>
                    </th>
                    <td class="px-6 py-4 text-nowrap">
                        {{ $course->category->name }}
                    </td>
                    <td class="px-6 py-4 text-nowrap">
                        {{ $course->instructor->name }}
                    </td>
                    <td class="px-6 py-4">
                        <form method="post" action="{{ route('dashboard.courses.destroy',$course->id) }}" class=" font-medium text-red-600 dark:text-red-500 hover:underline">
                            @csrf
                            @method('delete')
                            <button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
