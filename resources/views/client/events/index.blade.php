<x-client-layout>
    <div class="md:mt-12 md:mx-16 flex gap-8 flex-col overflow-hidden bg-white md:rounded-md !rounded-b-none shadow-sm px-4 md:px-12 pt-12 pb-24">
        <div class="flex flex-col md:flex-row justify-between items-center gap-8">
            <x-search-form/>
            <x-date-filter/>
        </div>
        <div class="flex flex-col gap-8">
            @foreach ($events as $event)
                @include('client.events.partials.event-card')
            @endforeach
        </div>
    </div>
</x-client-layout>
