<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $course->title }}
        </h2>
    </x-slot>
    @include('components.progress-init')

    <div class="max-w-7xl mx-auto flex flex-col md:gap-6 sm:px-6 lg:px-8W">
        <div class="bg-white text-gray-900 overflow-hidden shadow-sm sm:rounded border">
            @include('admin.courses.partials.edit-course-form')
        </div>

        <div class="border-b bg-white rounded-md">
            <ul class="flex flex-wrap justify-center -mb-px text-sm font-medium text-center" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg uppercase" id="chapter-tab" data-tabs-target="#chapter" type="button" role="tab" aria-controls="chapter" aria-selected="false">Chapters</button>
                </li>
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg uppercase hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="assignment-tab" data-tabs-target="#assignment" type="button" role="tab" aria-controls="assignment" aria-selected="false">Assignments</button>
                </li>
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg uppercase hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="quizzes-tab" data-tabs-target="#quizzes" type="button" role="tab" aria-controls="quizzes" aria-selected="false">Questions</button>
                </li>
                <li role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg uppercase hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="mark-tab" data-tabs-target="#mark" type="button" role="tab" aria-controls="mark" aria-selected="false">Students</button>
                </li>
            </ul>
        </div>
        <div id="default-tab-content">
            <div class="hidden" id="chapter" role="tabpanel" aria-labelledby="chapter-tab">
                <div class="flex flex-col md:gap-2">
                    <div class="flex flex-col md:gap-2" id="accordion-flush-chapter" data-accordion="collapse" data-active-classes="bg-white">
                        @foreach ($course->chapters as $key => $chapter)
                            @include('admin.courses.partials.edit-chapter-form')
                        @endforeach
                    </div>

                    <div class="bg-white text-gray-900 overflow-hidden shadow-sm sm:rounded border">
                        @include('admin.courses.partials.add-chapter-form')
                    </div>
                </div>
            </div>
            <div class="hidden" id="assignment" role="tabpanel" aria-labelledby="assignment-tab">
                <div class="flex flex-col md:gap-2">
                    <div class="flex flex-col md:gap-2" id="accordion-flush-assignment" data-accordion="collapse" data-active-classes="bg-white">
                        @foreach ($course->assignments as $key => $assignment)
                            @include('admin.courses.partials.edit-assignment-form')
                        @endforeach
                    </div>
                    <div class="bg-white text-gray-900 overflow-hidden shadow-sm sm:rounded border">
                        @include('admin.courses.partials.add-assignment-form')
                    </div>
                </div>
            </div>
            <div class="hidden" id="quizzes" role="tabpanel" aria-labelledby="quizzes-tab">
                <div class="flex flex-col md:gap-2 bg-white text-gray-900 overflow-hidden shadow-sm rounded border p-4">
                    <div class="flex gap-4 items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-question"><path d="M12 17h.01"/><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7z"/><path d="M9.1 9a3 3 0 0 1 5.82 1c0 2-3 3-3 3"/></svg>
                        <h1 class="text-lg font-semibold">
                            Exam Questions
                        </h1>
                    </div>
                    @include('admin.courses.partials.edit-quizz-form')
                </div>
            </div>
            <div class="hidden" id="mark" role="tabpanel" aria-labelledby="mark-tab">
                @include('admin.courses.partials.student-table')
            </div>
        </div>
    </div>
    @push('pre-scripts')
        <script>
            const getIconByFileType = (fileType, fileName) => {
                const icons = {
                    'application/pdf': "{{ asset('assets/icons/pdf.png') }}",
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document': "{{ asset('assets/icons/doc.png') }}",
                    'application/msword': "{{ asset('assets/icons/doc.png') }}",
                    'application/vnd.openxmlformats-officedocument.presentationml.presentation': "{{ asset('assets/icons/ppt.png') }}",
                    'application/x-zip-compressed': "{{ asset('assets/icons/zip.png') }}",
                    'application/zip': "{{ asset('assets/icons/zip.png') }}",
                    'audio/mpeg': "{{ asset('assets/icons/mp3.png') }}",
                    'video/mp4': "{{ asset('assets/icons/mp4.png') }}",
                };

                let icon = "{{ asset('assets/icons/file.png') }}";

                if (icons[fileType]) {
                    icon = icons[fileType];
                } else {
                    const extension = fileName.split('.').pop().toLowerCase();
                    const extensionIcons = {
                        'pdf': "{{ asset('assets/icons/pdf.png') }}",
                        'doc': "{{ asset('assets/icons/doc.png') }}",
                        'docx': "{{ asset('assets/icons/doc.png') }}",
                        'ppt': "{{ asset('assets/icons/ppt.png') }}",
                        'pptx': "{{ asset('assets/icons/ppt.png') }}",
                        'zip': "{{ asset('assets/icons/zip.png') }}",
                        'mp3': "{{ asset('assets/icons/mp3.png') }}",
                        'mp4': "{{ asset('assets/icons/mp4.png') }}",
                    };

                    if (extensionIcons[extension]) {
                        icon = extensionIcons[extension];
                    }
                }

                return icon;
            }

            const renenderFileInput = (key,assets) => {
                const chapterFileDropCover = document.getElementById(`chapter-dropzone-cover-${key}`);

                chapterFileDropCover.innerHTML = '';
                    chapterFileDropCover.classList.remove('flex-col', 'items-center', 'justify-center', 'pt-5', 'pb-6');
                    chapterFileDropCover.classList.add('grid', 'grid-cols-3','md:grid-cols-8', 'gap-2', 'w-full', 'h-full', 'p-6');

                Array.from(assets).forEach(asset => {
                    const [filePath, fileExt] = asset.split(/(?=\.[^.]+$)/);
                    const fileName = filePath.split('/').pop();
                    const shortFileName = fileName.length > 6 ? `${fileName.substring(0, 6)}...${fileExt}` : `${fileName}.${fileExt}`;

                    chapterFileDropCover.innerHTML += `
                        <a class="flex flex-col justify-center items-center" href="{{ asset('${asset}') }}" download>
                            <img src="${getIconByFileType(fileExt, asset)}" class="aspect-square w-10 h-10 md:w-20 md:h-20" alt="">
                            <span class="text-xs text-blue-600 underline text-wrap">
                                ${shortFileName}
                            </span>
                        </a>
                    `;
                });
            };

            const handleFileInput = (key) => {
                const chapterFileInput = document.getElementById(`chapter-dropzone-file-${key}`);
                const chapterFileDropCover = document.getElementById(`chapter-dropzone-cover-${key}`);

                chapterFileInput.addEventListener('change', (e) => {
                    const files = Array.from(e.target.files);

                    chapterFileDropCover.innerHTML = '';
                    chapterFileDropCover.classList.remove('flex-col', 'items-center', 'justify-center', 'pt-5', 'pb-6');
                    chapterFileDropCover.classList.add('grid', 'grid-cols-3','md:grid-cols-8', 'gap-2', 'w-full', 'h-full', 'p-6');

                    const progressBar = new ProgressBar(key);
                    let progressValue = 0;
                    const progressRate = 100 / files.length
                    progressBar.showProgress();

                    files.forEach((file) => {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            const [fileName, fileExt] = file.name.split(/(?=\.[^.]+$)/);
                            const shortFileName = fileName.length > 6 ? `${fileName.substring(0, 6)}...${fileExt}` : file.name;
                            chapterFileDropCover.innerHTML += `
                                <a class="flex flex-col justify-center items-center" href="${e.target.result}" download>
                                    <img src="${getIconByFileType(file.type, file.name)}" class="aspect-square w-10 h-10 md:w-20 md:h-20" alt="">
                                    <span class="text-xs text-blue-600 underline text-wrap">
                                        ${shortFileName}
                                    </span>
                                </a>
                            `;

                            progressValue += progressRate;
                            progressBar.updateProgress(Math.floor(progressValue));
                        };
                        reader.readAsDataURL(file);
                    });
                });
            };
        </script>
    @endpush
    @push('post-scripts')
        <script>
            const handleUpdateAssignment = (form) => {
                const formID = form.id.split('-').pop()
                form.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    startLoading(true,`assignment-form-submit-btn-${formID}`)
                    try {
                        const formData = new FormData(form);
                        const response = await axios.post(form.action,formData);

                        document.getElementById(`assignment-title-${formID}`).value = response.data.data.title;
                        const date = new Date(response.data.data.due_date);
                        const month = date.getMonth() + 1;
                        const day = date.getDate();
                        const year = date.getFullYear();
                        document.getElementById(`assignment-due-date-${formID}`).value = `${month}/${day}/${year}`;
                        document.getElementById(`assignment-file-label-${formID}`).innerText = `Uploaded file: ${response.data.data.file.split('/').pop()}`;
                        document.getElementById(`assignment-heading-${formID}`).innerText = response.data.data.title;

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
                    }finally{
                        startLoading(false,`assignment-form-submit-btn-${formID}`)
                    }
                });
            }

            const handleDeleteAssignment = (btn) => {
                const assignment_id = btn.getAttribute('data-assignment-id');
                btn.addEventListener('click', async (e) => {
                    e.preventDefault();
                    startLoading(true,btn.id)
                    try {
                        const response = await axios.delete(`${window.location.origin}/dashboard/assignments/${assignment_id}`);

                        showAlertMessage(response.data.message)

                        document.getElementById(`assignment-id-${assignment_id}`).classList.add('hidden')

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
                    } finally {
                        startLoading(false,btn.id)
                    }
                });
            }

            const updateAssignmentForms = document.querySelectorAll('#accordion-flush-assignment form');

            updateAssignmentForms.forEach((form)=>{
                handleUpdateAssignment(form)
            })

            const deleteAssignmentButtons = document.querySelectorAll('#delete-assignment-btn');

            deleteAssignmentButtons.forEach((btn)=>{
                handleDeleteAssignment(btn)

            })

            const updateQuizz = (quizzId) => {
                const quizzForm = document.getElementById(`quizz-form-${quizzId}`);
                quizzForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    startLoading(true,"quizz-form-submit-btn-"+quizzId)

                    try {
                        const formData = new FormData(quizzForm);

                        const response = await axios.post(quizzForm.action, formData);

                        document.querySelector(`#quizz-form-${quizzId} textarea[name="question"]`).value = response.data.data.question;
                        document.querySelector(`#quizz-form-${quizzId} input[name="answer"]`).value = response.data.data.answer;

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
                    startLoading(false,"quizz-form-submit-btn-"+quizzId)
                });
            }

            const handleUpdateQuizzes = () => {
                const quizzesForm = document.querySelectorAll('form[id^="quizz-form-"]');
                quizzesForm.forEach((quizzForm) => {
                    const quizzId = quizzForm.id.split('-').pop();
                    updateQuizz(quizzId);
                });
            }

            handleUpdateQuizzes()

            const handleQuizzEditor = (formId) => {
                const quizzEditor = document.querySelector(`#${formId} textarea[name="question"]`);

                const quizzEditorTools = document.querySelectorAll(`#${formId} #quizz-editor-tools button`);

                let historyStack = [];
                let redoStack = [];

                function saveState() {
                    historyStack.push(quizzEditor.value);
                    if (historyStack.length > 50) historyStack.shift();  // Limit history size to 50 states
                }

                // Save the initial state
                saveState();

                quizzEditorTools.forEach((child) => {
                    child.addEventListener('click', (e) => {
                        const startPos = quizzEditor.selectionStart;
                        const endPos = quizzEditor.selectionEnd;

                        let insertText = '';

                        switch (child.id) {
                            case 'add-paragraph':
                                insertText = `<p class=""></p>`;
                                break;
                            case 'add-list':
                                insertText = `<ol class="list-inside" style="list-style-type: lower-alpha;">\n\t<li></li>\n</ol>`;
                                break;
                            case 'add-blank':
                                insertText = `__________`;
                                break;
                            case 'redo':
                                if (redoStack.length > 0) {
                                    quizzEditor.value = redoStack.pop();
                                    saveState();
                                }
                                break;
                            case 'undo':
                                if (historyStack.length > 1) {
                                    redoStack.push(historyStack.pop());
                                    quizzEditor.value = historyStack[historyStack.length - 1];
                                }
                                break;
                            case 'clear':
                                quizzEditor.value = '';
                                saveState();
                                return;  // Exit the function if clearing the text
                            default:
                                insertText = '';
                                break;
                        }

                        saveState();

                        // Insert text at the cursor position
                        quizzEditor.value = quizzEditor.value.substring(0, startPos) + insertText + quizzEditor.value.substring(endPos);
                        // Move cursor to the end of the inserted text
                        quizzEditor.selectionStart = quizzEditor.selectionEnd = startPos + insertText.length;

                        redoStack = [];
                    });
                });

                document.addEventListener('keydown', (e) => {
                    if (e.ctrlKey && e.key === 'z') {
                        // Undo operation
                        e.preventDefault();
                        if (historyStack.length > 1) {
                            redoStack.push(historyStack.pop());
                            quizzEditor.value = historyStack[historyStack.length - 1];
                        }
                    }
                    if (e.ctrlKey && e.key === 'y') {
                        // Redo operation
                        e.preventDefault();
                        if (redoStack.length > 0) {
                            quizzEditor.value = redoStack.pop();
                            saveState();
                        }
                    }
                    if (e.key === 'Tab') {
                        e.preventDefault();

                        saveState();

                    }
                });

            }

            const allQuizzEditorForms = document.querySelectorAll('form[id^="quizz-form-"]');

            allQuizzEditorForms.forEach((qizzEditorForms) => {
                handleQuizzEditor(qizzEditorForms.id);
            });
            handleQuizzEditor('add-quizz-form')
        </script>
    @endpush
</x-app-layout>


