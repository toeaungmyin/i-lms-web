<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $course->title }}
        </h2>
    </x-slot>
    @include('admin.courses.partials.progress-init')

    <div class="max-w-7xl mx-auto flex flex-col md:gap-10 sm:px-6 lg:px-8">
        <div class="bg-white text-gray-900 overflow-hidden shadow-sm sm:rounded border">
            @include('admin.courses.partials.edit-course-form')
        </div>

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
    @push('pre-scripts')
        <script>
            const startLoading = (status,className) => {
                const submitBtn = document.getElementById(`${className}`);
                const loader = document.querySelector(`#${className} #loader`);
                if(status){
                    submitBtn.classList.add('flex','gap-2','cursor-not-allowed','opacity-50');
                    loader && loader.classList.remove('hidden');
                }else{
                    submitBtn.classList.remove('flex','gap-2','cursor-not-allowed','opacity-50');
                    loader && loader.classList.add('hidden');
                }
            }

            const getIconByFileType = (fileType, fileName) => {
                const icons = {
                    'application/pdf': "{{ asset('assets/icons/pdf.png') }}",
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document': "{{ asset('assets/icons/doc.png') }}",
                    'application/msword': "{{ asset('assets/icons/doc.png') }}",
                    'application/vnd.openxmlformats-officedocument.presentationml.presentation': "{{ asset('assets/icons/ppt.png') }}",
                    'application/x-zip-compressed': "{{ asset('assets/icons/zip.png') }}",
                    'application/zip': "{{ asset('assets/icons/zip.png') }}",
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
                        const response = await axios.delete(`${window.location.origin}/dashboard/assignment/${assignment_id}`);

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
        </script>
    @endpush
</x-app-layout>


