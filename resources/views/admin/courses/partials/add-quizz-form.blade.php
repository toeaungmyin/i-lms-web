<form class="w-full" id="add-quizz-form">
    <div class="flex gap-2 px-4 md:ps-10">
        <h3 class="w-full max-w-10 font-bold">
            New
        </h3>
        <div class="w-full mb-4 border border-gray-300 rounded-lg bg-gray-100 dark:bg-gray-700 dark:border-gray-600">
            @include('admin.courses.partials.quizz-editor-tools')
            <input type="hidden" name="course_id" value="{{ $course->id }}">
            <div class="px-4 py-2 bg-white dark:bg-gray-800">
                <label for="editor" class="sr-only">Publish post</label>
                <textarea name="question" id="editor" rows="5" class="block w-full px-0 text-sm font-bold font-mono text-gray-800 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400" placeholder="Write your question here. You can alos use HTML, CSS, and Tailwind classes." required ></textarea>
            </div>
            <div class="flex items-center justify-between px-2 py-2 border-t dark:border-gray-600">
                <div class="flex flex-wrap items-center divide-gray-200 sm:divide-x sm:rtl:divide-x-reverse dark:divide-gray-600">
                    <div class="flex items-center space-x-1 rtl:space-x-reverse sm:ps-2">
                        <div class="w-full flex justify-center items-center gap-4">
                            <label for="answer" class="block text-sm font-medium text-gray-900 dark:text-white text-nowrap">Answer :</label>
                            <input name="answer" type="text" id="answer" class="bg-white border border-gray-300 text-green-500 text-sm font-bold font-mono rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2" />
                        </div>
                    </div>
                </div>
                <x-primary-button id="new-quizz-form-submit-btn">
                    <svg id="loader" class="hidden animate-spin" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-loader-circle"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
                    {{ __('Add') }}
                </x-primary-button>
            </div>
        </div>
    </div>
</form>

@push('post-scripts')
    <script>
        const renenderQuizz = (quizz) => {
            const quizzesContainer = document.getElementById('quizzes-container');
            const quizzesForm = document.querySelectorAll('form[id^="quizz-form-"]');
            quizzesContainer.innerHTML += `
                <form class="w-full" id="quizz-form-${quizz.id}">
                    <input type="hidden" name="_method" value="PUT">
                    <div class="flex gap-2 px-4 md:ps-10">
                        <h3 class="font-bold">
                            ${quizzesForm.length + 1 + '.'}
                        </h3>
                        <div class="w-full mb-4 border border-gray-300 rounded-lg bg-gray-100 dark:bg-gray-700 dark:border-gray-600">
                            <input type="hidden" name="course_id" value="${quizz.course_id}">
                            <div class="px-4 py-2 bg-white rounded-t-lg dark:bg-gray-800">
                                <label for="editor" class="sr-only">Publish post</label>
                                <textarea id="editor" name="question" rows="4" class="block w-full px-0 text-sm text-gray-800 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400" placeholder="Write an article..." required >${quizz.question}</textarea>
                            </div>
                            <div class="flex items-center justify-between px-2 py-2 border-t dark:border-gray-600">
                                <div class="flex flex-wrap items-center divide-gray-200 sm:divide-x sm:rtl:divide-x-reverse dark:divide-gray-600">
                                    <div class="flex items-center space-x-1 rtl:space-x-reverse sm:ps-2">
                                        <div class="w-full flex justify-center items-center gap-4">
                                            <label for="answer" class="block text-sm font-medium text-gray-900 dark:text-white text-nowrap">Answer :</label>
                                            <input type="text" name="answer" id="answer" class="bg-white border border-gray-300 text-green-500 text-sm font-bold rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2" required value="${quizz.answer}" />
                                        </div>
                                    </div>
                                </div>
                                <x-primary-button id="chapter-form-submit-btn-${quizz.id}">
                                    <svg id="loader" class="hidden animate-spin" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-loader-circle"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
                                    {{ __('Submit') }}
                                </x-primary-button>
                            </div>
                        </div>
                    </div>
                </form>
            `;

            document.querySelector(`#add-quizz-form textarea[name="question"]`).value = '';
            document.querySelector(`#add-quizz-form input[name="answer"]`).value = '';

        }

        addQuizzForm = document.getElementById('add-quizz-form');

        addQuizzForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            startLoading(true,"new-quizz-form-submit-btn")

            try {
                const formData = new FormData(addQuizzForm);

                const response = await axios.post("{{ route('dashboard.quizzes.store') }}", formData);

                renenderQuizz(response.data.data)

                showAlertMessage(response.data.message)

            } catch (error) {
                if (error.response && error.response.data.errors) {
                    showAlertMessage(error.response.data.message)
                } else {
                    console.error(error);
                    // Handle other errors, e.g., network issues
                    showAlertMessage(error.response.data.message)
                }
            }
            startLoading(false,"new-quizz-form-submit-btn")
        });


    </script>
@endpush
