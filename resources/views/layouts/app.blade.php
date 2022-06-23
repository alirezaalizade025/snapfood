<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    @livewireStyles
    <wireui:scripts />
    {{-- @powerGridStyles --}}
    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>


<body class="font-sans antialiased">

    <div class="h-full bg-gray-100">
        @livewire('aside-menu')
        <main>
            <div class="h-full ml-auto mb-6 lg:w-[75%] xl:w-[80%] 2xl:w-[85%]">
                @livewire('navigation-menu')
                <x-jet-banner />
                {{ $slot }}
            </div>
        </main>
    </div>

    {{-- @stack('modals') --}}
    <livewire:delete-modal />
    @livewireScripts
    {{-- @powerGridScripts --}}
</body>

</html>
