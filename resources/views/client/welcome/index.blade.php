<x-client-layout>
    <div class="md:mt-12 md:mx-16 overflow-hidden">
        @include('client.welcome.partials.hero')
        @include('client.welcome.partials.feature')
        @include('client.welcome.partials.events')
        @include('client.welcome.partials.courses')
        @include('client.welcome.partials.status')
    </div>

    @push('script')
        <script type="text/javascript">
            console.log("Hello World");
        </script>
    @endpush
</x-client-layout>


