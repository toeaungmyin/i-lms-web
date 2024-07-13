
<form action="{{ route('dashboard.course.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="grid gap-6 mb-6 md:grid-cols-2">
        <div class="grid gap-6 grid-row-2">
            <div>
                <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Course Title</label>
                <input type="text" id="title" name="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Example Course" required />
                @error('title')
                    <span class="text-red-800">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Course Description</label>
                <textarea id="description" name="description" rows="12" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Short description about course"></textarea>
                @error('description')
                    <span class="text-red-800">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="grid gap-6 grid-row-2">
            <div class="">
                <label for="category_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select a category</label>
                <select id="category_id" name="category_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id}}">{{ $category->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="">
                <div class="flex flex-col w-full">
                    <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Course Cover Photo</label>
                    <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                        <div id="dropzone-cover" class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF</p>
                        </div>
                        <input id="dropzone-file" type="file" class="hidden" name="cover" accept="image/*" />
                    </label>
                </div>
                @error('cover')
                    <span class="text-red-800">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    <x-primary-button>
        {{ __('Submit') }}
    </x-primary-button>
</form>

@push('post-scripts')
    <script>
        const fileInput = document.getElementById('dropzone-file');
        const fileDropCover = document.getElementById('dropzone-cover');
        fileInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            const reader = new FileReader();
            reader.onload = (e) => {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('aspect-auto', 'max-h-56', 'rounded-md');
                fileDropCover.innerHTML = '';
                fileDropCover.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    </script>
@endpush
