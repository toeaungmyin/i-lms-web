<div class="flex flex-col gap-6">
    <div class="">
        <label for="event-date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Event Date</label>
        <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                </svg>
            </div>
            <input datepicker datepicker-buttons id="event-date" name="date" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500" placeholder="Select date">
        </div>
        @error('date')
            <span class="text-red-800">{{ $message }}</span>
        @enderror
    </div>
    <div class="">
        <label for="event-date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Event Time</label>
        <ul id="timetable" class="grid w-full grid-cols-2 gap-2 gap-y-4">
        </ul>
        @error('time')
            <span class="text-red-800">{{ $message }}</span>
        @enderror
    </div>
</div>
@push('post-scripts')
    <script>

        const times = [
            '8:00 AM',
            '9:00 AM',
            '10:00 AM',
            '11:00 AM',
            '12:00 AM',
            '1:00 PM',
            '2:00 PM',
            '3:00 PM',
            '4:00 PM',
            '5:00 PM',
        ]
        const timetableEL = document.getElementById('timetable');
        times.forEach(time => {
            timetableEL.innerHTML += `
                <li>
                    <input type="radio" id="${time}" value="${time}" class="hidden peer" name="time">
                    <label for="${time}"
                        class="inline-flex items-center justify-center w-full p-2 text-sm font-medium text-center bg-white border rounded-lg cursor-pointer text-gray-600 border-gray-600 dark:hover:text-white dark:border-gray-500 dark:peer-checked:border-gray-500 peer-checked:border-gray-600 peer-checked:bg-gray-600 hover:text-white peer-checked:text-white hover:bg-gray-500 dark:text-gray-500 dark:bg-gray-900 dark:hover:bg-gray-600 dark:hover:border-gray-600 dark:peer-checked:bg-gray-500">
                    ${time}
                    </label>
                </li>
            `
        });

        @if ($event->date)
            const eventDateEl = document.getElementById('event-date');
            eventDateEl.value = "{{ Carbon\Carbon::parse($event->date)->format('m/d/Y') }}"

            const eventTimeEl = document.querySelector(`input[value="{{ Carbon\Carbon::parse($event->date)->format('g:00 A') }}"]`);
            if(eventDateEl){
                eventTimeEl.checked = true;
            }
        @endif
    </script>
@endpush

