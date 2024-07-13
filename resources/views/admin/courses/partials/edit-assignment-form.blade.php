
<div id="accordion-flush-assignment-{{ $key }}" data-accordion="collapse" data-active-classes="bg-white">
    <h1 id="accordion-flush-assignment-heading-{{ $key }}">
        <button type="button" class="flex items-center justify-between w-full font-medium rtl:text-right gap-3 p-4 text-gray-900" data-accordion-target="#accordion-flush-assignment-body-{{ $key }}" aria-expanded="false" aria-controls="accordion-flush-assignment-body-{{ $key }}">
            <div class="flex gap-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clipboard-list"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M12 11h4"/><path d="M12 16h4"/><path d="M8 11h.01"/><path d="M8 16h.01"/></svg>
                <span class="text-lg font-semibold" id="assignment-heading-{{ $key }}">{{ $assignment->title }}</span>
            </div>
            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
            </svg>
        </button>
    </h1>
    <div id="accordion-flush-assignment-body-{{ $key }}" class="hidden relative p-4 pt-2 mt-2" aria-labelledby="accordion-collapse-heading-{{ $key }}">
        <form action="{{ route('dashboard.assignment.update',$assignment->id) }}" id="update-assignment-form-{{ $key }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="flex flex-col gap-2 mb-3">
                <div>
                    <label for="assignment-title-new-{{ $key }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Assignment Title</label>
                    <input type="text" id="assignment-title-{{ $key }}" name="title" value="{{ $assignment->title }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm font-medium rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Example Assignment" required />
                    @error('title')
                        <span class="text-red-800">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex gap-4">
                    <div class="w-full">
                        <label for="assignment-due-date-{{ $key }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Assignment Due Date</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                </svg>
                            </div>
                            <input name="due_date" id="assignment-due-date-{{ $key }}" value="{{ Carbon\Carbon::parse($assignment->due_date)->format('m/d/Y') }}" datepicker datepicker-buttons datepicker-autoselect-today datepicker-orientation="top" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                        </div>
                        @error('description')
                            <span class="text-red-800">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-full">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="assignment-file-{{ $key }}">Upload file</label>
                        <input name="file" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="assignment-file-{{ $key }}" type="file">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" id="assignment-file-label-{{ $key }}" for="assignment-file-{{ $key }}">Uploaded file: {{ basename($assignment->file) }}</label>
                    </div>
                </div>
            </div>
            <div class="w-full flex justify-between">
                <input type="hidden" name="course_id" value="{{ $course->id }}">
                <x-primary-button id="assignment-form-submit-btn-{{ $key }}">
                    <svg id="loader" class="hidden animate-spin" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-loader-circle"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
                    {{ __('Submit') }}
                </x-primary-button>
                <x-danger-button id="delete-assignment-form-{{ $key }}" type="button" class="flex gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                    {{ __('Remove') }}
                </x-danger-button>
            </div>
        </form>
    </div>
</div>

@push('post-scripts')
    <script>
        const deleteAssignmentForm{{ $key }} = document.getElementById('delete-assignment-form-{{ $key }}');

        deleteAssignmentForm{{ $key }}.addEventListener('click', async (e) => {
            e.preventDefault();
            startLoading(true,"delete-assignment-form-{{ $key }}")
            try {
                const response = await axios.delete("{{ route('dashboard.assignment.destroy',$assignment->id) }}");
                console.log(response.data);
                showAlertMessage(response.data.message)

                startLoading(false,"delete-assignment-form-{{ $key }}")
                document.getElementById("assignment-id-{{ $assignment->id }}").classList.add('hidden')

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
        });

        const updateAssignmentForm{{ $key }} = document.getElementById('update-assignment-form-{{ $key }}');

        updateAssignmentForm{{ $key }}.addEventListener('submit', async (e) => {
            e.preventDefault();
            startLoading(true,"assignment-form-submit-btn-{{ $key }}")
            try {
                const formData = new FormData(updateAssignmentForm{{ $key }});
                const response = await axios.post("{{ route('dashboard.assignment.update',$assignment->id) }}",formData);

                document.getElementById("assignment-title-{{ $key }}").value = response.data.data.title;
                const date = new Date(response.data.data.due_date);
                const month = date.getMonth() + 1;
                const day = date.getDate();
                const year = date.getFullYear();
                document.getElementById("assignment-due-date-{{ $key }}").value = `${month}/${day}/${year}`;
                document.getElementById("assignment-file-label-{{ $key }}").innerText = `Uploaded file: ${response.data.data.file.split('/').pop()}`;
                document.getElementById("assignment-heading-{{ $key }}").innerText = response.data.data.title;
                startLoading(false,"assignment-form-submit-btn-{{ $key }}")

                showAlertMessage(response.data.message)

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
        });

    </script>
@endpush
