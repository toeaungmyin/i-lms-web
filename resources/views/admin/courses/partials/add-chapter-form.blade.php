
<form class="p-4" id="addChapterForm" action="{{ route('dashboard.chapters.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <h1 class="text-lg font-semibold mb-3">
        <div class="flex gap-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-book-plus"><path d="M12 7v6"/><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20"/><path d="M9 10h6"/></svg>
            Add New Chapter
        </div>
    </h1>
    <div class="flex flex-col gap-2 mb-3">
        <div>
            <label for="chapter-title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Chapter Title</label>
            <input type="text" id="chapter-title" name="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Example Chapter" required />
            @error('title')
                <span class="text-red-800">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="chapter-description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Chapter Description</label>
            <textarea id="chapter-description" name="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Short description about chapter"></textarea>
            @error('description')
                <span class="text-red-800">{{ $message }}</span>
            @enderror
        </div>
        <div class="">
            <div class="flex flex-col w-full">
                <label for="chapter-dropzone-file-new" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    <span>Chapter associated files</span>
                </label>
                <label for="chapter-dropzone-file-new" class="relative flex flex-col items-center justify-center w-full max-h-96 overflow-y-auto border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                    <div id="chapter-dropzone-cover-new" class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                        </svg>
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400" >PPTX, PDF, DOC or ZIP</p>
                    </div>
                    <input id="chapter-dropzone-file-new" type="file" class="hidden" name="assets[]" accept=".pptx,.doc,.docx,.pdf,.zip" multiple/>
                    <div id="progress-container-new" class="hidden absolute w-full h-full justify-center items-center transition-opacity duration-100">
                        <div class="absolute top-0 left-0 w-full h-full bg-gray-200 opacity-60 cursor-not-allowed"></div>
                            <div class="w-64 h-4 rounded-sm bg-gray-300 relative flex justify-center items-center overflow-hidden">
                                <div id="file-upload-progress-new" class="absolute left-0 h-full bg-gradient-to-r from-green-700 to-green-500 transition-all duration-300 w-full">
                            </div>
                            <div id="progress-value-new" class="text-xs text-gray-50 z-10"></div>
                        </div>
                    </div>
                </label>
            </div>
            @error('cover')
                <span class="text-red-800">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <input type="hidden" name="course_id" value="{{ $course->id }}">
    <x-primary-button id="chapter-form-submit-btn-new">
        <svg id="loader" class="hidden animate-spin" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-loader-circle"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
        {{ __('Submit') }}
    </x-primary-button>
</form>
@push('post-scripts')
    <script>

        document.addEventListener('DOMContentLoaded', () => {
            handleFileInput('new');
        });

        const addNewChapterForm = document.getElementById('addChapterForm');

        addNewChapterForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            startLoading(true,"chapter-form-submit-btn-new")

            try {
                const formData = new FormData(addNewChapterForm);

                const response = await axios.post("{{ route('dashboard.chapters.store') }}", formData);

                renenderChapter(response.data.data)

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
            startLoading(false,"chapter-form-submit-btn-new")

        });

        const renenderChapter = (data) => {
            const accordionElement = document.getElementById('accordion-flush-chapter');
            accordionElement.innerHTML += `
                <div id="chapter-id-${ data.id }" class="bg-white text-gray-900 overflow-hidden shadow-sm sm:rounded border">
                    <h1 id="accordion-flush-chapter-heading-${ data.id }">
                        <button type="button" class="flex items-center justify-between w-full font-medium rtl:text-right gap-3 p-4 text-gray-900" data-accordion-target="#accordion-flush-chapter-body-${ data.id }" aria-expanded="false" aria-controls="accordion-flush-chapter-body-${ data.id }">
                            <div class="flex gap-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-book-text"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20"/><path d="M8 11h8"/><path d="M8 7h6"/></svg>
                                <span class="text-lg font-semibold" id="chapter-heading-${ data.id }">{{ $chapter->title }}</span>
                            </div>
                            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                            </svg>
                        </button>
                    </h1>
                    <div id="accordion-flush-chapter-body-${ data.id }" class="hidden relative p-4 pt-2 mt-2" aria-labelledby="accordion-collapse-heading-${ data.id }">
                        <form action="${window.location.origin}/dashboard/chapters/${data.id}" id="update-chapter-form-${ data.id }" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="flex flex-col gap-2 mb-3">
                                <div>
                                    <label for="chapter-title-${ data.id }" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Chapter Title</label>
                                    <input type="text" id="chapter-title-${ data.id }" name="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm font-medium rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Example Lesson" required value="${ data.title }" />
                                    @error('title')
                                        <span class="text-red-800">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label for="chapter-description-${ data.id }" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Chapter Description</label>
                                    <textarea id="chapter-description-${ data.id }" name="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Short description about lesson">${ data.description }</textarea>
                                    @error('description')
                                        <span class="text-red-800">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="">
                                    <div class="flex flex-col w-full">
                                        <label for="chapter-dropzone-file-${ data.id }" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                            <span>Chapter associated files</span>
                                        </label>
                                        <label for="chapter-dropzone-file-${ data.id }" class="relative flex flex-col items-center justify-center w-full max-h-96 overflow-y-auto border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                            <div id="chapter-dropzone-cover-${ data.id }" class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                                </svg>
                                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400" >PPTX, PDF, DOC or ZIP</p>
                                            </div>
                                            <input id="chapter-dropzone-file-${ data.id }" type="file" class="hidden" name="assets[]" accept=".pptx,.doc,.docx,.pdf,.zip" multiple/>
                                            <div id="progress-container-${ data.id }" class="hidden absolute w-full h-full justify-center items-center transition-opacity duration-100">
                                                <div class="absolute top-0 left-0 w-full h-full bg-gray-200 opacity-60 cursor-not-allowed"></div>
                                                <div class="w-64 h-6 rounded-sm bg-gray-300 relative flex justify-center items-center overflow-hidden">
                                                <div id="file-upload-progress-${ data.id }" class="absolute left-0 h-full w-full bg-gradient-to-r from-green-700 to-green-500 transition-all duration-300">
                                                </div>
                                                <div id="progress-value-${ data.id }" class="text-xs text-gray-50 z-10"></div>
                                            </div>
                                            </div>
                                        </label>
                                    </div>
                                    @error('cover')
                                        <span class="text-red-800">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-full flex justify-between">
                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                                <x-primary-button id="chapter-form-submit-btn-${ data.id }">
                                    <svg id="loader" class="hidden animate-spin" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-loader-circle"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
                                    {{ __('Submit') }}
                                </x-primary-button>
                                <x-danger-button id="delete-lesson-form-${ data.id }" type="button" class="flex gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                    {{ __('Remove') }}
                                </x-danger-button>
                            </div>
                        </form>
                    </div>
                </div>
            `
            renenderFileInput(data.id,JSON.parse((data.assets)))

            const accordionItems = Object.values(accordionElement.children).map((ch) => {
                const id = ch.id.split('-').pop()
                return {
                    id: `accordion-flush-chapter-heading-${id}`,
                    triggerEl: document.querySelector(`#accordion-flush-chapter-heading-${id}`),
                    targetEl: document.querySelector(`#accordion-flush-chapter-body-${id}`),
                    active: false
                }
            })


            const options = {
                alwaysOpen: false,
                activeClasses: 'bg-white',
            };

            const instanceOptions = {
                id: 'accordion-flush-chapter',
                override: true
            };

            new Accordion(accordionElement, accordionItems, options, instanceOptions);
        }
    </script>
@endpush



