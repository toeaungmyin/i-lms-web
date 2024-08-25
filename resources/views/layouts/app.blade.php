<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('pre-scripts')
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-200">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow overflow-hidden">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between">
                        {{ $header }}
                    </div>
                    <x-alert/>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="md:py-12">
                {{ $slot }}
            </main>
        </div>
        <x-btn-loading/>
        @stack('post-scripts')
    </body>
</html>
