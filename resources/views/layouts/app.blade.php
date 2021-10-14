<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Accounting software') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap">

    <!-- Styles -->

    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}" id="tailwindcss">
    <link rel="apple-touch-icon" href="icons/apple-icon-180.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#47BFBE" />
    <link rel="apple-touch-startup-image" href="{{ asset('images/icons/apple-splash-2048-2732.jpg') }}"
        media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
    <link rel="apple-touch-startup-image" href="{{ asset('images/icons/apple-splash-2732-2048.jpg') }}"
        media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)">
    <link rel="apple-touch-startup-image" href="{{ asset('images/icons/apple-splash-1668-2388.jpg') }}"
        media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
    <link rel="apple-touch-startup-image" href="{{ asset('images/icons/apple-splash-2388-1668.jpg') }}"
        media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)">
    <link rel="apple-touch-startup-image" href="{{ asset('images/icons/apple-splash-1536-2048.jpg') }}"
        media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
    <link rel="apple-touch-startup-image" href="{{ asset('images/icons/apple-splash-2048-1536.jpg') }}"
        media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)">
    <link rel="apple-touch-startup-image" href="{{ asset('images/icons/apple-splash-1668-2224.jpg') }}"
        media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
    <link rel="apple-touch-startup-image" href="{{ asset('images/icons/apple-splash-2224-1668.jpg') }}"
        media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)">
    <link rel="apple-touch-startup-image" href="{{ asset('images/icons/apple-splash-1620-2160.jpg') }}"
        media="(device-width: 810px) and (device-height: 1080px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
    <link rel="apple-touch-startup-image" href="{{ asset('images/icons/apple-splash-2160-1620.jpg') }}"
        media="(device-width: 810px) and (device-height: 1080px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)">
    <link rel="apple-touch-startup-image" href="{{ asset('images/icons/apple-splash-1284-2778.jpg') }}"
        media="(device-width: 428px) and (device-height: 926px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">
    <link rel="apple-touch-startup-image" href="{{ asset('images/icons/apple-splash-2778-1284.jpg') }}"
        media="(device-width: 428px) and (device-height: 926px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)">
    <link rel="apple-touch-startup-image" href="{{ asset('images/icons/apple-splash-1170-2532.jpg') }}"
        media="(device-width: 390px) and (device-height: 844px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">
    <link rel="apple-touch-startup-image" href="{{ asset('images/icons/apple-splash-2532-1170.jpg') }}"
        media="(device-width: 390px) and (device-height: 844px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)">
    <link rel="apple-touch-startup-image" href="{{ asset('images/icons/apple-splash-1125-2436.jpg') }}"
        media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">
    <link rel="apple-touch-startup-image" href="{{ asset('images/icons/apple-splash-2436-1125.jpg') }}"
        media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)">
    <link rel="apple-touch-startup-image" href="{{ asset('images/icons/apple-splash-1242-2688.jpg') }}"
        media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">
    <link rel="apple-touch-startup-image" href="{{ asset('images/icons/apple-splash-2688-1242.jpg') }}"
        media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)">
    <link rel="apple-touch-startup-image" href="{{ asset('images/icons/apple-splash-828-1792.jpg') }}"
        media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
    <link rel="apple-touch-startup-image" href="{{ asset('images/icons/apple-splash-1792-828.jpg') }}"
        media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)">
    <link rel="apple-touch-startup-image" href="{{ asset('images/icons/apple-splash-1242-2208.jpg') }}"
        media="(device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">
    <link rel="apple-touch-startup-image" href="{{ asset('images/icons/apple-splash-2208-1242.jpg') }}"
        media="(device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)">
    <link rel="apple-touch-startup-image" href="{{ asset('images/icons/apple-splash-750-1334.jpg') }}"
        media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
    <link rel="apple-touch-startup-image" href="{{ asset('images/icons/apple-splash-1334-750.jpg') }}"
        media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)">
    <link rel="apple-touch-startup-image" href="{{ asset('images/icons/apple-splash-640-1136.jpg') }}"
        media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
    <link rel="apple-touch-startup-image" href="{{ asset('images/icons/apple-splash-1136-640.jpg') }}"
        media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)">
    @livewireStyles

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
                <header class="bg-white border-b border-gray-300 ">
                    <div class="w-full py-6 px-4 sm:px-6 lg:px-8 relative">
                        {{ $header }}

                        <a id="backBtn"
                            class="rounded-full cursor-pointer text-lime flex top-0 text-xl left-8 bottom-0 my-auto absolute"><span
                                class="my-auto">الرجوع</span></a>

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


    <script src="{{ asset('js/tafqit.js') }}"></script>
    <script src="{{ asset('js/main.js') }}" type="module"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/jquery.debounce-1.0.5.js') }}"></script>
    @yield('footerScripts')
    @stack('custom-scripts')
    <script>
        $('#backBtn').click(function(e) {
            e.preventDefault();
            window.history.back();
        });
    </script>
</body>

</html>
