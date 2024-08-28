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
                    <th scope="row" data-modal-target="popup-modal" data-modal-toggle="popup-modal" class="px-6 py-4 font-medium max-w-sm text-gray-900 whitespace-nowrap dark:text-white cursor-pointer">
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

                <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <div class="flex flex-col gap-2 bg-white rounded-lg shadow dark:bg-gray-700 p-4">
                            <ul class="w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <li class="w-full px-4 py-2 border-b border-gray-200 rounded-t-lg dark:border-gray-600">
                                    <h3 class="text-lg font-semibold">
                                        {{ $student->name."'s Assignment" }}
                                    </h3>
                                </li>
                                <li class="w-full px-4 py-2 rounded-b-lg">
                                    <div class="flex gap-4">
                                        <div class="">
                                            Assignment :
                                        </div>
                                        <div class="flex flex-col">
                                            @foreach ($student->assignemnts()->whereIn('assignment_id',$course->assignments->pluck('id'))->get() as $assi)
                                                <a href="{{ asset($assi->file) }}" class="text-blue-800 underline" download>{{ $assi->assignment->title }}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                </li>
                                <li class="w-full px-4 py-2 rounded-b-lg">
                                    <form class="flex flex-col gap-4" action="{{ route('asignment.check',$course->id) }}" method="POST">
                                        @csrf
                                        <div class="w-full flex justify-center items-center gap-4">
                                            <label for="mark" class="block text-sm font-medium text-gray-900 dark:text-white text-nowrap">Mark :</label>
                                            <input type="number" name="mark" id="mark" class="w-48 bg-white border border-gray-300 text-gray-500 text-sm font-bold rounded-lg focus:ring-gray-500 focus:border-gray-500 block p-2" required value="{{ $course->course_has_students->where('student_id',$student->id)->first()->assignment_mark }}"/>
                                        </div>
                                        <input type="hidden" name="student_id" value="{{ $student->id }}">
                                        <div class="flex justify-end mt-3">
                                            <x-primary-button>
                                                {{ __('Submit') }}
                                            </x-primary-button>
                                        </div>
                                    </form>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>

            @endforeach
        </tbody>
    </table>
</div>
