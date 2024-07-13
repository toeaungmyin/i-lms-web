<x-client-layout>
    <div class="md:mt-12 md:mx-16 overflow-hidden">
        <div class="bg-white rounded-md !rounded-b-none flex flex-col  items-center justify-center m-12">
                <h1 class="text-6xl font-bold text-gray-800">404</h1>
                <h2 class="text-2xl font-semibold text-gray-600">Page Not Found</h2>
                <p class="text-gray-500">The page you are looking for might have been removed had its name changed or is temporarily unavailable.</p>
                <a href="{{ route('welcome') }}" class="mt-4 px-4 py-2 bg-blue-500 text-black rounded-md">Back to Home</a>
        </div>
    </div>

    @push('script')
        <script type="text/javascript">
            console.log("Hello World");
        </script>
    @endpush
</x-client-layout>


