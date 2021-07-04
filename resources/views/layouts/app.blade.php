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
    <link rel="stylesheet" href="https://cdn.nayzac.online/svgCharts/css/style.css"/>

    @livewireStyles

    <!-- Scripts -->

</head>

<body class="font-sans antialiased overflow-hidden">
    @include('sweetalert::alert')

    <x-jet-banner />

    <div class="bg-gray-50 h-screen flex">
        @livewire('navigation-menu')

        <!-- Page Heading -->
        <div class="overflow-auto w-full">
            @if (isset($header))
                <header class="bg-white border-b border-gray-300">
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

    <script src="{{ asset('js/classes/IDrawable.js')}}" type="module"></script>
    <script src="{{ asset('js/classes/Pie.js')}}" type="module"></script>
    <script src="{{ asset('js/classes/Slice.js')}}" type="module"></script>
    <script src="{{ asset('js/main.js')}}" type="module"></script>
    @yield('footerScripts')
</body>

</html>
