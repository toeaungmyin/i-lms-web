@include('components.progress-init')
<div class="flex flex-col gap-4 bg-white p-4 rounded-md">
    @foreach ($course->assignments as $assignment)
            @php
                $remainingTime = Carbon\Carbon::parse($assignment->due_date)->diffInSeconds(Carbon\Carbon::now());
            @endphp
        <form action="{{ route('asignment.submit',$assignment->id) }}" enctype="multipart/form-data" id="assignemnt-upload-form-{{ $assignment->id }}" method="POST" class="flex flex-col gap-2 p-4">
            @csrf
            <h3 class="text-xl font-bold m-0">{{ $assignment->title }}</h3>
            <ul class="w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg">
                <li class="w-full border-b border-gray-200 rounded-t-lg">
                    <div class="flex flex-col md:flex-row">
                        <div class="md:w-1/6 bg-gray-100 px-4 py-2">
                            Expired Date
                        </div>
                        <div class="px-4 py-2">
                            <span>
                                {{ Carbon\Carbon::parse($assignment->due_date)->format('M/d/Y')}}
                            </span>
                            @if (Carbon\Carbon::parse($assignment->due_date)->diffInMilliseconds(Carbon\Carbon::now()) > 0)
                                <span class="text-red-500 font-semibold">( Overdue {{ Carbon\Carbon::parse($assignment->due_date)->diffForHumans() }} )</span>
                            @else
                                <span class="text-green-500 font-semibold">( Remaining {{ Carbon\Carbon::parse($assignment->due_date)->diffForHumans() }} )</span>
                            @endif
                        </div>
                    </div>
                </li>
                <li class="w-full border-b border-gray-200">
                    @php
                        $ext = pathinfo($assignment->file, PATHINFO_EXTENSION);
                        $ext = strtolower($ext);

                        switch ($ext) {
                            case 'pdf': $icon = 'assets/icons/pdf.png';
                            break;
                            case 'doc': $icon = 'assets/icons/doc.png';
                            break;
                            case 'docx': $icon = 'assets/icons/doc.png';
                            break;
                            case 'ppt': $icon = 'assets/icons/ppt.png';
                            break;
                            case 'pptx': $icon = 'assets/icons/ppt.png';
                            break;
                            case 'zip': $icon = 'assets/icons/zip.png';
                            break;
                            default: $icon = 'assets/icons/file.png';
                        }
                    @endphp
                    <div class="flex flex-col md:flex-row">
                        <div class="md:w-1/6 bg-gray-100 px-4 py-2 flex items-center">
                            Assignment File
                        </div>
                        <div class="px-4 py-2">
                            <a class="flex flex-col justify-center items-center gap-1" href="{{ asset($assignment->file) }}" download>
                                <img src="{{ asset($icon) }}" class="aspect-square w-8 h-8 md:w-10 md:h-10" alt="">
                                <span class="text-xs text-blue-600 underline text-wrap">
                                    {{ basename($assignment->file) }}
                                </span>
                            </a>
                        </div>
                    </div>
                </li>
                <li class="w-full rounded-b-lg">
                    <div class="flex flex-col md:flex-row">
                        <div class="md:w-1/6 bg-gray-100 px-4 py-2 flex items-center">
                            Uploaded File
                        </div>
                        <div class="md:w-5/6 flex px-4 py-2">
                            @if ($remainingTime < 1 && !$chs->is_finish)
                                <div class="flex items-center justify-center w-full">
                                    <label for="assignment-file-{{ $assignment->id }}" class="relative flex flex-col items-center justify-center w-full h-28 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50  hover:bg-gray-100 dark:border-gray-600 ">
                                        <div id="assignment-dropzone-cover-{{ $assignment->id }}" class="flex flex-col items-center justify-center pt-5 pb-6">
                                            @php
                                                $stdAssignment = $assignment->studentHasAssignment()->where('student_id',Auth::id())->first();
                                            @endphp
                                            @if ($stdAssignment)
                                                @php
                                                    $ext = pathinfo($stdAssignment->file, PATHINFO_EXTENSION);
                                                    $ext = strtolower($ext);

                                                    switch ($ext) {
                                                        case 'pdf': $icon = 'assets/icons/pdf.png';
                                                        break;
                                                        case 'doc': $icon = 'assets/icons/doc.png';
                                                        break;
                                                        case 'docx': $icon = 'assets/icons/doc.png';
                                                        break;
                                                        case 'ppt': $icon = 'assets/icons/ppt.png';
                                                        break;
                                                        case 'pptx': $icon = 'assets/icons/ppt.png';
                                                        break;
                                                        case 'zip': $icon = 'assets/icons/zip.png';
                                                        break;
                                                        default: $icon = 'assets/icons/file.png';
                                                    }

                                                @endphp
                                                    <a class="flex flex-col justify-center items-center" href="{{ asset($stdAssignment->file) }}" download>
                                                        <img src="{{ asset($icon) }}" class="aspect-square w-8 h-8 md:w-12 md:h-12" alt="">
                                                        <span class="text-xs text-blue-600 underline text-nowrap">
                                                            {{ basename($stdAssignment->file) }}
                                                        </span>
                                                    </a>
                                            @else
                                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                                </svg>
                                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                                            @endif
                                        </div>
                                        <input type="hidden" name="assignment_id" value="{{ $assignment->id }}">
                                        <input name="file" id="assignment-file-{{ $assignment->id }}" type="file" class="hidden" />
                                        <div id="progress-container-{{ $assignment->id }}" class="hidden absolute w-full h-full justify-center items-center transition-opacity duration-100">
                                            <div class="absolute top-0 left-0 w-full h-full bg-gray-200 opacity-60 cursor-not-allowed"></div>
                                                <div class="w-64 h-4 rounded-sm bg-gray-300 relative flex justify-center items-center overflow-hidden">
                                                    <div id="file-upload-progress-{{ $assignment->id }}" class="absolute left-0 h-full bg-gradient-to-r from-green-700 to-green-500 transition-all duration-300 w-full">
                                                </div>
                                                <div id="progress-value-{{ $assignment->id }}" class="text-xs text-gray-50 z-10"></div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            @else
                                @php
                                    $stdAssignment = $assignment->studentHasAssignment()->where('student_id',Auth::id())->first();
                                @endphp
                                @if ($stdAssignment)
                                    @php
                                        $ext = pathinfo($stdAssignment->file, PATHINFO_EXTENSION);
                                        $ext = strtolower($ext);

                                        switch ($ext) {
                                            case 'pdf': $icon = 'assets/icons/pdf.png';
                                            break;
                                            case 'doc': $icon = 'assets/icons/doc.png';
                                            break;
                                            case 'docx': $icon = 'assets/icons/doc.png';
                                            break;
                                            case 'ppt': $icon = 'assets/icons/ppt.png';
                                            break;
                                            case 'pptx': $icon = 'assets/icons/ppt.png';
                                            break;
                                            case 'zip': $icon = 'assets/icons/zip.png';
                                            break;
                                            default: $icon = 'assets/icons/file.png';
                                        }

                                    @endphp
                                    <a class="flex flex-col justify-center items-center" href="{{ asset($stdAssignment->file) }}" download>
                                        <img src="{{ asset($icon) }}" class="aspect-square w-8 h-8 md:w-12 md:h-12" alt="">
                                        <span class="text-xs text-blue-600 underline text-nowrap">
                                            {{ basename($stdAssignment->file) }}
                                        </span>
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>
                </li>
            </ul>

            @if ($remainingTime < 1 && !$chs->is_finish)
                <div class="flex justify-end">
                    <x-primary-button id="exam-form-submit-btn">
                        {{ __('Submit') }}
                    </x-primary-button>
                </div>
            @endif
        </form>
    @endforeach
</div>

@push('post-scripts')
    <script>
        const assignmentFileInputs = document.querySelectorAll('input[type="file"]');

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

        const handleFileInput = (key) => {
            const assFileInput = document.getElementById(`assignment-file-${key}`);
            const assFileDropCover = document.getElementById(`assignment-dropzone-cover-${key}`);

            assFileInput.addEventListener('change', (e) => {
                const files = Array.from(e.target.files);

                assFileDropCover.innerHTML = '';
                assFileDropCover.classList.remove('flex-col', 'items-center', 'justify-center', 'pt-5', 'pb-6');
                assFileDropCover.classList.add('grid', 'grid-cols-3','md:grid-cols-8', 'gap-2', 'w-full', 'h-full', 'p-6');

                const progressBar = new ProgressBar(key);
                let progressValue = 0;
                const progressRate = 100 / files.length
                progressBar.showProgress();

                files.forEach((file) => {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const [fileName, fileExt] = file.name.split(/(?=\.[^.]+$)/);
                        const shortFileName = fileName.length > 6 ? `${fileName.substring(0, 6)}...${fileExt}` : file.name;
                        assFileDropCover.innerHTML += `
                            <a class="flex flex-col justify-center items-center" href="${e.target.result}" download>
                                <img src="${getIconByFileType(file.type, file.name)}" class="aspect-square w-8 h-8 md:w-12 md:h-12" alt="">
                                <span class="text-xs text-blue-600 underline text-nowrap">
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

        assignmentFileInputs.forEach(fileInput => {
            const id = fileInput.id.split("-").pop()
            handleFileInput(id)
        });

    </script>
@endpush
