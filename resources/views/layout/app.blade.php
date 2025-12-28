<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('general.htmlTitle') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-black text-gray-100 h-full">
    <div class="flex flex-col min-h-screen max-w-[1920px] mx-auto bg-rockag">

        @if($includeHeader ?? false)
            @include('partials.header', ['pageTitle' => $pageTitle])
        @endif

        @yield('body')

        @include('partials.footer')
        
    </div>
</body>
</html>
