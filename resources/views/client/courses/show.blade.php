<x-client-layout>
    <div class="md:mt-6 md:mx-4 flex gap-8 flex-col overflow-hidden md:rounded-md !rounded-b-none shadow-sm px-4 md:px-12 pt-12 pb-12">
        @include('client.courses.partials.course-detail-heading')
        @include('client.courses.partials.course-detail-chapter')
        @include('client.courses.partials.course-detail-assignment')

        <div class="flex flex-col items-center gap-4 bg-white p-8 rounded-md">
            <h3 class="text-lg font-bold uppercase">
                Final Online Exam
            </h3>
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <tbody>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                Allowed Time
                            </th>
                            <td class="px-6 py-4 min-w-40 font-bold">
                                @php
                                    $hours = floor($course->examTimeLimit / 3600);
                                    $minutes = floor(($course->examTimeLimit % 3600) / 60);
                                @endphp
                                {{ $hours.':'.str_pad($minutes, 2, '0', STR_PAD_LEFT) }}
                            </td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                Maximun Retake
                            </th>
                            <td class="px-6 py-4 min-w-40 font-bold">
                                {{ $course->maxExamAttempts }}
                            </td>
                        </tr>
                        <tr class="bg-white dark:bg-gray-800">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                Exam Mark Percentage
                            </th>
                            <td class="px-6 py-4 min-w-40 font-bold">
                                {{ $course->exam_grade_percent }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="flex justify-center flex-col gap-2">
                @if ($course->course_has_students->where('student_id',Auth::id())->first()->exams()->count() < $course->maxExamAttempts && !$chs->is_finish)
                    <a href="{{ route('exam.start',$course->id) }}" class="self-center text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded text-sm px-5 py-2">{{ __('Take Exam') }}</a>
                @endif

                @if ($course->course_has_students->where('student_id',Auth::id())->first()->exams()->count() > 0)
                    <div class="flex gap-2">
                        <a href="{{ route('exam.result',Auth::user()->exams->last()->id) }}" class="self-center border-2 border-gray-400 text-gray-900 hover:text-gray-50 bg-gray-50 hover:bg-gray-400 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded text-sm px-3 py-2 ">{{ __('Show Result') }}</a>
                    </div>
                @endif

            </div>
        </div>

        <div class="flex flex-col items-center justify-center bg-white p-8 rounded-md">
            @if ($chs->is_finished)
                <a href="{{ route('course.finish',$course->id) }}" class="self-center text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded text-sm px-5 py-2">{{ __('Finish Course') }}</a>
            @endif
            <div>
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <tbody>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                Exam Mark
                            </th>
                            <td class="px-6 py-4 min-w-40 font-bold">
                                {{ $chs->exam_mark }}
                            </td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                Assignment Mark
                            </th>
                            <td class="px-6 py-4 min-w-40 font-bold">
                                {{ $chs->assignment_mark }}
                            </td>
                        </tr>
                        <tr class="bg-white dark:bg-gray-800">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                Total
                            </th>
                            <td class="px-6 py-4 min-w-40 font-bold">
                                {{$chs->exam_mark + $chs->assignment_mark }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-client-layout>
