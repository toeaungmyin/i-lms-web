<div class="flex flex-col justify-center items-start gap-4 mt-4">
    <div id="quizzes-container" class="w-full">
        @foreach ($course->quizzes as $key => $quizz)
            <form class="w-full" id="quizz-form-{{ $quizz->id }}" action="{{ route('dashboard.quizzes.update',$quizz->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="flex gap-2 px-4 md:ps-10">
                    <h3 class="w-full max-w-10 font-bold">
                        {{ $key + 1 . '.' }}
                    </h3>
                    <div class="w-full mb-4 border border-gray-300 rounded-lg bg-gray-100 dark:bg-gray-700 dark:border-gray-600">
                        @include('admin.courses.partials.quizz-editor-tools')
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                        <div class="px-4 py-2 bg-white dark:bg-gray-800">
                            <label for="editor" class="sr-only">Question</label>
                            <textarea id="editor" name="question" rows="5" class="block w-full px-0 text-sm font-bold font-mono text-gray-800 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400" placeholder="Write your question here. You can alos use HTML, CSS, and Tailwind classes." required >{{ $quizz->question }}</textarea>
                        </div>
                        <div class="flex items-center justify-between px-2 py-2 border-t dark:border-gray-600">
                            <div class="flex flex-wrap items-center divide-gray-200 sm:divide-x sm:rtl:divide-x-reverse dark:divide-gray-600">
                                <div class="flex items-center space-x-1 rtl:space-x-reverse sm:ps-2">
                                    <div class="w-full flex justify-center items-center gap-4">
                                        <label for="answer" class="block text-sm font-medium text-gray-900 dark:text-white text-nowrap">Answer :</label>
                                        <input type="text" name="answer" id="answer" class="bg-white border border-gray-300 text-green-500 text-sm font-bold font-mono rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2" required value="{{ $quizz->answer }}" />
                                    </div>
                                </div>
                            </div>
                            <x-primary-button id="quizz-form-submit-btn-{{ $quizz->id }}">
                                <svg id="loader" class="hidden animate-spin" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-loader-circle"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
                                {{ __('Update') }}
                            </x-primary-button>
                        </div>
                    </div>
                </div>
            </form>
        @endforeach
    </div>
    @include('admin.courses.partials.add-quizz-form')
</div>

@push('post-scripts')
@endpush
