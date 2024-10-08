<div class="w-full flex flex-col xl:flex-row items-center bg-white rounded-md shadow">
    <img class="xl:w-1/2 h-full object-cover aspect-[4/3] rounded-t-lg md:rounded-none xl:rounded-s-lg" src="{{ $event->cover }}" alt="{{ $event->title }}">
    <div class="xl:w-1/2 h-full flex flex-col justify-between p-6 leading-normal">
            <div class="flex flex-col gap-2">
                <h5 class="text-xl font-bold tracking-tight text-gray-900 ">{{ $event->title }}</h5>
                <p class="font-normal text-justify text-gray-700">
                    {{ $event->description }}
                </p>
            </div>
            <div class="w-full flex justify-between text-gray-500">
                <span class="flex gap-2 mt-1 text-sm font-medium text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-days"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/></svg>
                    {{ Carbon\Carbon::parse($event->event_date)->format('M/d/Y')}}
                </span>
                <span class="flex gap-2 mt-1 text-sm font-medium text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-alarm-clock-check"><circle cx="12" cy="13" r="8"/><path d="M5 3 2 6"/><path d="m22 6-3-3"/><path d="M6.38 18.7 4 21"/><path d="M17.64 18.67 20 21"/><path d="m9 13 2 2 4-4"/></svg>
                    {{ Carbon\Carbon::parse($event->event_date)->format('h:m A')}}
                </span>
            </div>
    </div>
</div>
