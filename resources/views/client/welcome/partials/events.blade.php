<div class="bg-white" id="event">
  <div class="mx-auto max-w-2xl px-4 py-16 pt-0 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
    <h2 class="text-2xl mb-24 font-bold tracking-tight text-gray-900 text-center uppercase">upcoming events</h2>

    <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
      @foreach ($events as $event)
          <a href="#" class="group">
            <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-h-8 xl:aspect-w-7">
            <img src="{{ $event->cover }}" alt="{{ $event->title }}" class="max-h-52 aspect-square h-full w-full object-cover object-center group-hover:opacity-75">
            </div>
            <h3 class="mt-4 text-lg font-medium text-gray-900">{{ $event->title }}</h3>
            <div class="flex justify-between">
                <span class="flex gap-2 mt-1 text-sm font-medium text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-days"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/></svg>
                    {{ Carbon\Carbon::parse($event->date)->format('M/d/Y')}}
                </span>
                <span class="flex gap-2 mt-1 text-sm font-medium text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-alarm-clock-check"><circle cx="12" cy="13" r="8"/><path d="M5 3 2 6"/><path d="m22 6-3-3"/><path d="M6.38 18.7 4 21"/><path d="M17.64 18.67 20 21"/><path d="m9 13 2 2 4-4"/></svg>
                    {{ Carbon\Carbon::parse($event->date)->format('h:m A')}}
                </span>
            </div>

        </a>
      @endforeach

    </div>
  </div>
</div>
