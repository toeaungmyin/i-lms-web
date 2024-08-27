<div class="relative overflow-x-auto shadow-md sm:rounded-lg p-8 bg-white">
    <div class="pb-8 flex justify-end">
        <form action="{{ route('dashboard.users.enrollStudent',$course->id) }}" method="POST" class="w-full max-w-sm justify-start">
            @csrf
            <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
            <div class="relative">
                <input type="text" id="default-search" name="STDID" class="block w-full p-4 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Student ID" required />
                <x-primary-button class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{ __('add Student') }}</x-primary-button>
            </div>
        </form>
    </div>
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 rounded shadow overflow-hidden border">
        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
            <tr>
                <th scope="col" class="px-6 py-3">
                    SID
                </th>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Email
                </th>
                <th scope="col" class="px-6 py-3">
                    Assignment mark
                </th>
                <th scope="col" class="px-6 py-3">
                    Exam mark
                </th>
                <th scope="col" class="px-6 py-3">
                    Total
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                    <td class="px-6 py-4">
                        {{ $student->STDID }}
                    </td>
                    <th scope="row" class="px-6 py-4 font-medium max-w-sm text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $student->name }}
                    </th>
                    <td class="px-6 py-4 text-nowrap">
                        {{ $student->email }}
                    </td>
                    <td class="px-6 py-4 text-nowrap">
                        {{ $course->course_has_students->where('student_id',$student->id)->first()->exam_mark }}
                    </td>
                    <td class="px-6 py-4 text-nowrap">
                        {{ $course->course_has_students->where('student_id',$student->id)->first()->assignment_mark }}
                    </td>
                    <td class="px-6 py-4 text-nowrap">
                        {{ $course->course_has_students->where('student_id',$student->id)->first()->assignment_mark+$course->course_has_students->where('student_id',$student->id)->first()->exam_mark }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
