<div class="p-6 text-gray-900 flex justify-center">
    <div class="flex flex-col justify-center items-center max-w-lg gap-4">
        <form action="{{ route('dashboard.categories.store') }}" method="post" class="w-full">
            <div class="w-full flex gap-2 justify-center items-center">
                @csrf
                <input type="text" id="small-input" name="name" placeholder="Category name" class="block w-full p-2.5 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                @error('name')
                    <span class="text-red-700">{{ $message }}</span>
                @enderror
                <x-primary-button>
                    {{ __('Add') }}
                </x-primary-button>
            </div>
        </form>
        <div class="flex justify-center w-full">
            <div class="relative overflow-x-auto rounded-lg shadow-sm">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                ID
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Category name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Number of Courses
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{  $category->id }}
                                </th>
                                <td class="px-6 py-2">
                                    {{  $category->name }}
                                </td>
                                <td class="px-6 py-2 text-center">
                                    {{  $category->courses->count() }}
                                </td>
                                <td class="px-6 py-2">
                                    <form method="post" action="{{ route('dashboard.categories.delete',$category->id) }}" class="w-full flex justify-center font-medium text-red-600 dark:text-red-500 hover:underline">
                                        @csrf
                                        @method('delete')
                                        <button type="submit">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
