<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Accounting software') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    @livewireStyles

    <!-- Scripts -->

</head>

<body class="font-sans antialiased">
    @include('sweetalert::alert')

    <x-jet-banner />

    <div class="min-h-screen bg-gray-50">
        @livewire('navigation-menu')

        <!-- Page Heading -->
        <div class="fixed bottom-0 top-0 left-0 w-10/12  overflow-auto">
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="w-full py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="">
                {{ $slot }}
            </main>
        </div>
    </div>

    @stack('modals')

    @livewireScripts

    <script src="{{ mix('js/app.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    @yield('footerScripts')
</body>

</html>
