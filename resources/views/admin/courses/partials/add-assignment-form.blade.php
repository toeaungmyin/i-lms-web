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
                console.log(response.data);
                showAlertMessage(response.data.message)

                window.location.reload();
            } catch (error) {
                if (error.response && error.response.data.errors) {
                    console.log(error.response.data.errors);
                    // Optionally, you can display these errors to the user
                    showAlertMessage(response.data.message)
                } else {
                    console.error(error);
                    // Handle other errors, e.g., network issues
                    showAlertMessage(response.data.message)
                }
            }
            startLoading(false,"assignment-form-submit-btn-new")
        });

    </script>
@endpush
