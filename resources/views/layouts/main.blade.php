<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css'
        integrity='sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=='
        crossorigin='anonymous' referrerpolicy='no-referrer' />
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @livewireStyles
    @livewireScripts
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <x-notifications z-index="z-50" />
    @if (count($errors) > 0)
        <div class="p-1">
            @foreach ($errors->all() as $error)
                <div class="alert alert-warning absolute z-50 top-5 left-5 w-1/4" role="alert">{{ $error }} <button
                        type="button" class="close" data-dismiss="alert" aria-label="Close">
            @endforeach
        </div>
    @endif
    @yield('content')
    <wireui:scripts />
    <script src="{{ mix('js/app.js') }}" defer></script>
</body>

</html>
