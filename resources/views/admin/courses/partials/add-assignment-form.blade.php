<form class="p-4" action="{{ route('dashboard.assignment.store') }}" id="store-assignment-form-new" method="POST" enctype="multipart/form-data">
    @csrf
    <h1 class="text-lg font-semibold mb-3">
        <div class="flex gap-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clipboard-plus"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M9 14h6"/><path d="M12 17v-6"/></svg>
            Add New Assignment
        </div>
    </h1>
    <div class="flex flex-col gap-2 mb-3">
        <div>
            <label for="assignment-title-new" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Assignment Title</label>
            <input type="text" id="assignment-title-new" name="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm font-medium rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Example Assignment" required />
            @error('title')
                <span class="text-red-800">{{ $message }}</span>
            @enderror
        </div>
        <div class="flex gap-4">
            <div class="w-full">
                <label for="assignment-due-date-new" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Assignment Due Date</label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                        </svg>
                    </div>
                    <input name="due_date" id="assignment-due-date-new" datepicker datepicker-buttons datepicker-autoselect-today datepicker-orientation="top" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                </div>
                @error('description')
                    <span class="text-red-800">{{ $message }}</span>
                @enderror
            </div>
            <div class="w-full">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Upload file</label>
                <input name="file" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="file_input" type="file">
            </div>
        </div>
    </div>
    <div class="w-full flex justify-between">
        <input type="hidden" name="course_id" value="{{ $course->id }}">
        <x-primary-button id="assignment-form-submit-btn-new">
            <svg id="loader" class="hidden animate-spin" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-loader-circle"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
            {{ __('Submit') }}
        </x-primary-button>
    </div>
</form>

@push('post-scripts')
    <script>

        const addAssignmentForm = document.getElementById('store-assignment-form-new');

        addAssignmentForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            startLoading(true,"assignment-form-submit-btn-new")
            try {
                const formData = new FormData(addAssignmentForm);
                const response = await axios.post("{{ route('dashboard.assignment.store') }}",formData);

                showAlertMessage(response.data.message)
                renenderAssignmentAccordion(response.data.data)

            } catch (error) {
                if (error.response && error.response.data.errors) {
                    console.log(error.response.data.errors);
                    // Optionally, you can display these errors to the user
                    showAlertMessage(error.response.data.message)
                } else {
                    console.error(error);
                    // Handle other errors, e.g., network issues
                    showAlertMessage(error.response.data.message)
                }
            }
            startLoading(false,"assignment-form-submit-btn-new")
        });

        const renenderAssignmentAccordion = (data) => {
            const accordionElement = document.getElementById(`accordion-flush-assignment`)

            accordionElement.innerHTML += `
                <div id="assignment-id-${data.id}" class="bg-white text-gray-900 overflow-hidden shadow-sm sm:rounded border">
                    <h1 id="accordion-flush-assignment-heading-${data.id}">
                        <button type="button" class="flex items-center justify-between w-full font-medium rtl:text-right gap-3 p-4 text-gray-900" data-accordion-target="#accordion-flush-assignment-body-${data.id}" aria-expanded="true" aria-controls="accordion-flush-assignment-body-${data.id}">
                            <div class="flex gap-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clipboard-list"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M12 11h4"/><path d="M12 16h4"/><path d="M8 11h.01"/><path d="M8 16h.01"/></svg>
                                <span class="text-lg font-semibold" id="assignment-heading-${data.id}">${data.title}</span>
                            </div>
                            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="false" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                            </svg>
                        </button>
                    </h1>
                    <div id="accordion-flush-assignment-body-${data.id}" class="hidden relative p-4 pt-2 mt-2" aria-labelledby="accordion-flush-assignment-heading-${data.id}">
                        <form action="${window.location.origin}/dashboard/assignment/${data.id}" id="update-assignment-form-${data.id}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="PUT">
                            <div class="flex flex-col gap-2 mb-3">
                                <div>
                                    <label for="assignment-title-${data.id}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Assignment Title</label>
                                    <input type="text" id="assignment-title-${data.id}" name="title" value="${data.title}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm font-medium rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Example Assignment" required />
                                    @error('title')
                                        <span class="text-red-800">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="flex gap-4">
                                    <div class="w-full">
                                        <label for="assignment-due-date-${data.id}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Assignment Due Date</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                                </svg>
                                            </div>
                                            <input name="due_date" id="assignment-due-date-${data.id}" value="${data.due_date}" datepicker datepicker-buttons datepicker-autoselect-today datepicker-orientation="top" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                                        </div>
                                        @error('description')
                                            <span class="text-red-800">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="w-full">
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="assignment-file-${data.id}">Upload file</label>
                                        <input name="file" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="assignment-file-${data.id}" type="file">
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" id="assignment-file-label-${data.id}" for="assignment-file-${data.id}">Uploaded file: ${data.file.split('/').pop()}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full flex justify-between">
                                <input type="hidden" name="course_id" value="${data.course_id}">
                                <x-primary-button id="assignment-form-submit-btn-${data.id}">
                                    <svg id="loader" class="hidden animate-spin" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-loader-circle"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
                                    {{ __('Submit') }}
                                </x-primary-button>
                                <x-danger-button id="delete-assignment-btn-${data.id}" data-assignment-id="${data.id}" type="button" class="flex gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                    {{ __('Remove') }}
                                </x-danger-button>
                            </div>
                        </form>
                    </div>
                </div>
            `
            const accordionItems = Object.values(accordionElement.children).map((ch)=>{
                        const id = ch.id.split('-').pop()
                        return {
                            id: `accordion-flush-assignment-heading-${id}`,
                            triggerEl: document.querySelector(`#accordion-flush-assignment-heading-${id}`),
                            targetEl: document.querySelector(`#accordion-flush-assignment-body-${id}`),
                            active: false
                        }
                    })


                    const options = {
                alwaysOpen: false,
                activeClasses: 'bg-white',
            };

            const instanceOptions = {
                id: 'accordion-flush-assignment',
                override: true
            };

            new Accordion(accordionElement, accordionItems, options, instanceOptions);

            handleUpdateAssignment(document.getElementById(`update-assignment-form-${data.id}`))
            handleDeleteAssignment(document.getElementById(`delete-assignment-btn-${data.id}`))
        }
    </script>
@endpush
