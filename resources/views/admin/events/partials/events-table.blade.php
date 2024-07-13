<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3 hidden md:table-cell">
                    Cover
                </th>
                <th scope="col" class="px-6 py-3">
                    Event
                </th>
                <th scope="col" class="px-6 py-3 hidden md:table-cell">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($events as $event)
                <tr class="odd:bg-white md:even:bg-gray-50 border-b">
                    <td class="px-2 py-2 hidden md:table-cell">
                        <img src="{{ asset($event->cover) }}" class="aspect-square object-cover max-w-48 h-40 rounded-md" alt="{{ $event->title }}">
                    </td>
                    <td class="px-6 py-4 text-gray-800 text-justify">
                        <div class="flex flex-col gap-2">
                            <div class="flex md:flex-col flex-col-reverse  gap-3 md:gap-2">
                            <img src="{{ asset($event->cover) }}" class="inline md:hidden aspect-auto w-full md:max-w-40 rounded-md" alt="{{ $event->title }}">
                            <div class="flex justify-between">
                                <div class="md:w-full flex md:justify-between flex-col md:flex-row">
                                    <a href="{{ route('dashboard.event.show',$event->id) }}" class="text-lg font-semibold hover:underline">{{ $event->title }}</a>
                                    <span class="text-sm">
                                        {{ Carbon\Carbon::parse($event->date)->format('M-d-Y h:m A')}}
                                    </span>
                                </div>
                                <form method="post" action="{{ route('dashboard.event.destroy',$event->id) }}" class="md:hidden flex justify-center items-center font-medium text-red-600 dark:text-red-500 hover:underline">
                                    @csrf
                                    @method('delete')
                                    <button type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <p class="text-gray-500">
                                {{ $event->description }}
                        </p>
                        </div>
                    </td>

                    <td class="px-6 py-4 hidden md:table-cell">
                        <form method="post" action="{{ route('dashboard.event.destroy',$event->id) }}" class=" font-medium text-red-600 dark:text-red-500 hover:underline">
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
