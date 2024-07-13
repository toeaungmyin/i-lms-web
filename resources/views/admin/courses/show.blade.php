<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $course->title }}
        </h2>
    </x-slot>
    @include('admin.courses.partials.progress-init')

    <div class="max-w-7xl mx-auto flex flex-col gap-12 sm:px-6 lg:px-8">
        <div class="bg-white text-gray-900 overflow-hidden shadow-sm sm:rounded border">
            @include('admin.courses.partials.edit-course-form')
        </div>

        <div class="flex flex-col gap-2">
            @foreach ($course->chapters as $key => $chapter)
            <div id="chapter-id-{{ $chapter->id }}" class="bg-white text-gray-900 overflow-hidden shadow-sm sm:rounded border">
                @include('admin.courses.partials.edit-chapter-form')
            </div>
            @endforeach
            <div class="bg-white text-gray-900 overflow-hidden shadow-sm sm:rounded border">
                @include('admin.courses.partials.add-chapter-form')
            </div>
        </div>
        <div class="flex flex-col gap-2">
            @foreach ($course->assignments as $key => $assignment)
            <div id="assignment-id-{{ $assignment->id }}" class="bg-white text-gray-900 overflow-hidden shadow-sm sm:rounded border">
                @include('admin.courses.partials.edit-assignment-form')
            </div>
            @endforeach
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

        </script>
    @endpush
</x-app-layout>


