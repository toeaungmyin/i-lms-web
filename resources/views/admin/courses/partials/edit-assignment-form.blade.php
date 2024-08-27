<div id="assignment-id-{{ $assignment->id }}" class="bg-white text-gray-900 overflow-hidden shadow-sm sm:rounded border">
    <h1 id="accordion-flush-assignment-heading-{{ $assignment->id }}">
        <button type="button" class="flex items-center justify-between w-full font-medium rtl:text-right gap-3 p-4 text-gray-900" data-accordion-target="#accordion-flush-assignment-body-{{ $assignment->id }}" aria-expanded="false" aria-controls="accordion-flush-assignment-body-{{ $assignment->id }}">
            <div class="flex gap-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clipboard-list"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M12 11h4"/><path d="M12 16h4"/><path d="M8 11h.01"/><path d="M8 16h.01"/></svg>
                <span class="text-lg font-semibold" id="assignment-heading-{{ $assignment->id }}">{{ $assignment->title }}</span>
            </div>
            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
            </svg>
        </button>
    </h1>
    <div id="accordion-flush-assignment-body-{{ $assignment->id }}" class="hidden relative p-4 pt-2 mt-2" aria-labelledby="accordion-flush-heading-{{ $assignment->id }}">
        <form action="{{ route('dashboard.assignments.update',$assignment->id) }}" id="update-assignment-form-{{ $assignment->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="flex flex-col gap-2 mb-3">
                <div>
                    <label for="assignment-title-{{ $assignment->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Assignment Title</label>
                    <input type="text" id="assignment-title-{{ $assignment->id }}" name="title" value="{{ $assignment->title }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm font-medium rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Example Assignment" required />
                    @error('title')
                        <span class="text-red-800">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex gap-4">
                    <div class="w-full">
                        <label for="assignment-due-date-{{ $assignment->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Assignment Due Date</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                </svg>
                            </div>
                            <input name="due_date" id="assignment-due-date-{{ $assignment->id }}" value="{{ Carbon\Carbon::parse($assignment->due_date)->format('m/d/Y') }}" datepicker datepicker-buttons datepicker-autoselect-today datepicker-orientation="top" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                        </div>
                        @error('description')
                            <span class="text-red-800">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-full">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="assignment-file-{{ $assignment->id }}">Upload file</label>
                        <input name="file" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="assignment-file-{{ $assignment->id }}" type="file">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" id="assignment-file-label-{{ $assignment->id }}" for="assignment-file-{{ $assignment->id }}">Uploaded file: {{ basename($assignment->file) }}</label>
                    </div>
                </div>
            </div>
            <div class="w-full flex justify-between">
                <input type="hidden" name="course_id" value="{{ $course->id }}">
                <x-primary-button id="assignment-form-submit-btn-{{ $assignment->id }}">
                    <svg id="loader" class="hidden animate-spin" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-loader-circle"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
                    {{ __('Submit') }}
                </x-primary-button>
                <x-danger-button id="delete-assignment-btn" data-assignment-id="{{ $assignment->id }}" type="button" class="flex gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                    {{ __('Remove') }}
                </x-danger-button>
            </div>
        </form>
    </div>
</div>
