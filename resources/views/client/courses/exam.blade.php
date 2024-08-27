<x-client-layout>
    <div class="md:mt-6 md:mx-4 flex gap-8 flex-col overflow-hidden md:rounded-md !rounded-b-none shadow-sm px-4 md:px-12 pt-12 ">
        <div class="flex flex-col gap-8 bg-white p-8 rounded-md">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold bg-gray-200 p-2 px-4 rounded">
                    {{ $course->title."'s Exam" }}
                </h2>
                <div class="flex gap-2 font-semibold text-red-500">
                    <div class="">
                        Remaining Time -
                    </div>
                    <div id="countdown" class="font-mono"></div>
                </div>
            </div>
            <form id="exam-form" action="{{ route('exam.submit',$activeExam->id) }}" method="POST" class="flex flex-col gap-4">
                @csrf
                @foreach ($course->questions as $quizz)
                    <div class="flex flex-col gap-2 bg-slate-200 border border-slate-300 rounded p-8">
                        <div class="flex gap-4">
                            <div class="text-right font-bold">
                                {{ $loop->iteration.'.'}}
                            </div>
                            <div class="flex flex-col gap-2 font-semibold">
                                <div class="">
                                    {!! $quizz->question !!}
                                </div>
                                <div class="max-w-60 flex justify-center items-center gap-4">
                                    <label for="answer-{{ $quizz->id }}" class="block text-sm font-medium text-gray-900 dark:text-white text-nowrap pb-1">Answer :</label>
                                    <input type="text" data-question-id="{{ $quizz->id }}" id="answer-{{ $quizz->id }}" class="bg-green-50 text-blue-500 border-b-2 border-0 border-green-300 text-sm font-bold font-mono focus:ring-0 focus:border-green-400 block w-full p-0.5" />
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="flex justify-center mt-8">
                    <x-primary-button id="exam-form-submit-btn">
                        <svg id="loader" class="hidden animate-spin" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-loader-circle"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
                        {{ __('Submit') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
        @push('post-scripts')
            <script>
                const examStartAt = new Date("{{ $activeExam->started_at }}")
                const examTimeLimit = {{ $course->examTimeLimit }}

                const updateDisplayTimeRemaining = (start,max) => {
                    const now = new Date();
                    const takenTime = now - start;
                    const remainingTime = max - (takenTime/1000)
                    let hours = Math.floor(remainingTime / (60 * 60));
                    let minutes = Math.floor((remainingTime % (60 * 60)) / (60));
                    let seconds = Math.floor((remainingTime % (60)) );

                    const countdownElement = document.getElementById('countdown')
                    countdownElement.innerHTML= `${hours} : ${minutes} : ${seconds}`

                    if(remainingTime < 0){
                        submitExam()
                    }
                }

                setInterval(() => {
                    updateDisplayTimeRemaining(examStartAt,examTimeLimit)
                }, 1000);

                const answersInputs = document.querySelectorAll('[id^="answer-"]');

                const examForm = document.getElementById('exam-form');

                examForm.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    submitExam()
                });

                const submitExam = () =>{
                    startLoading(true,"exam-form-submit-btn")

                    try {
                        const formData = new FormData();
                        const answers = []
                        answersInputs.forEach(input => {
                            answers.push({
                                'question_id' : input.getAttribute('data-question-id'),
                                'value' : input.value
                            })
                        });

                        answers.forEach(answer => {
                            formData.append('answers[]', JSON.stringify(answer));
                        });

                        const response = await axios.post("{{ route('exam.submit',$activeExam->id) }}", formData);

                        showAlertMessage(response.data.message)

                        if (response.data.message.status === 'success' && response.data.redirect_url) {
                            setTimeout(() => {
                                window.location.href = response.data.redirect_url;
                            }, 3000);

                        }

                    } catch (error) {
                        if (error.response && error.response.data.errors) {
                            showAlertMessage(error.response.data.message)
                        } else {
                            console.error(error);
                            // Handle other errors, e.g., network issues
                            showAlertMessage(error.response.data.message)
                        }
                    }
                    startLoading(false,"exam-form-submit-btn")
                }

            </script>
        @endpush
</x-client-layout>


