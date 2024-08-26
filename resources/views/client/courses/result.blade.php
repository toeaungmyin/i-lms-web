<x-client-layout>
    <div class="md:mt-6 md:mx-4 flex gap-8 flex-col overflow-hidden md:rounded-md !rounded-b-none shadow-sm px-4 md:px-12 pt-12 ">
        <div class="flex flex-col gap-8 bg-white p-8 rounded-md">
            <div class="flex justify-center items-center">
                <h2 class="text-xl font-bold bg-green-500 text-gray-50 p-2 px-4 rounded">
                    {{ $exam->course_has_student->course->title."'s Exam Result" }}
                </h2>
            </div>
            @foreach ($exam->answers as $answer)
                <div class="flex flex-col gap-2 border @if ($answer->is_correct)
                    bg-green-300 border-green-400
                @else
                    bg-red-300 border-red-400
                @endif  rounded p-4 px-12">
                    <div class="flex justify-between">
                        <div class="flex gap-4">
                            <div class="flex justify-center items-center text-right font-bold">
                            {{ $loop->iteration.'.'}}
                            </div>
                            <div class="flex justify-center items-center font-semibold">
                                {!! $answer->question->question !!}
                            </div>
                        </div>
                        <div class="flex flex-col gap-2 justify-center items-stretch">
                            <span class="flex justify-start items-center border p-2 font-semibold text-sm border-green-400 bg-green-100 rounded">
                                Answer : <span class="text-gray-900 px-2 font-bold">{{ $answer->value }}</span>
                            </span>
                            <span class="flex justify-start items-center border p-2 font-semibold text-sm border-green-400 bg-green-100 rounded">
                                Correct Answer : <span class="text-green-600 px-2 font-bold">{{ $answer->question->answer }}</span>
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="flex flex-col items-center justify-center gap-2 font-bold">
                <div class="flex gap-4 w-1/4 bg-gray-200 p-2 rounded justify-between">
                    <div class="">Total Quizz</div>
                    {{-- <div class="">{{ $exam->course_has_student->course->quizzes->count() }}</div> --}}
                </div>
                <div class="flex gap-4 w-1/4 bg-gray-200 p-2 rounded justify-between">
                    <div class="">Correct Answer</div>
                    {{-- <div class="">{{ $exam->answers()->where('is_correct',1)->count() }}</div> --}}
                </div>
                <div class="flex gap-4 w-1/4 bg-gray-200 p-2 rounded justify-between">
                    <div class="">Exam Mark Percentage</div>
                    {{-- <div class="">{{ ($exam->answers()->where('is_correct',1)->count()/$exam->course_has_student->course->quizzes->count() * 50 )." %" }}</div> --}}
                </div>
            </div>
        </div>
</x-client-layout>


