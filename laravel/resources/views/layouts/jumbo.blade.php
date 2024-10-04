<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="IATSE Local 118 is the labour union supplying technicians, stagehands,
        artisans and craftspeople to the Greater Vancouver entertainment industry, including live theatre,
        rock and roll, and trade shows. Local 118 has a large, skilled,
        and experienced workforce ready to meet the needs of your production.">
        <meta name="keywords" content="iatse, local 118, stagehand, craftspeople, theatre, theater, live theatre,
        rock and roll, trade shows, conventions, labour union, labor union, technicians, greater Vancouver
        entertainment industry, Vancouver, British Columbia, Canada">
        <meta name="author" content="IATSE Local 118 Web Admin">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name') }} {{ $data['title'] ?? ''}}</title>
        <script src="{{asset('/js/bootstrap-datepicker.min.js')}}"></script>

        <script async src="https://www.googletagmanager.com/gtag/js?id=G-WS6SX6VR7N"></script>
        <script src="{{asset('/js/google-analytics.js')}}"></script>
        <script src="{{asset('/js/alpine.min.js')}}" defer></script>
        <link rel="canonical" href="{{env('APP_URL')}}/">
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
        <link href="{{ mix('css/jumbotron.css') }}" rel="stylesheet">

        <link href="{{ mix('css/ck_style.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="/css/ckeditor5.css">

        <!-- Favicons -->
        <link rel="icon" href="/favicon-32x32.png" sizes="32x32" type="image/png">
        <link rel="icon" href="/favicon-16x16.png" sizes="16x16" type="image/png">
        <link rel="manifest" href="/manifest.json">
        <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#563d7c">
        <meta name="msapplication-config" content="/browserconfig.xml">
        <meta name="theme-color" content="#563d7c">
        <link rel="icon" href="/favicon.ico"><!-- 32×32 -->
        <link rel="icon" href="/icon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png"><!-- 180×180 -->
        <link rel="manifest" href="/manifest.webmanifest">
    </head>
    <body>
        <a id="top"></a>
        @include('layouts.nav')
        <main role="main" class="mt-4 px-2">
            @include('flash-messages')
            @yield('content')
        </main>
        @include('layouts.footer')
    </body>
</html>
