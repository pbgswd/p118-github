<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <script src="{{asset('/js/alpine.min.js')}}" defer></script>
    <link rel="canonical" href="{{env('APP_URL')}}/">

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ mix('css/jumbotron.css') }}" rel="stylesheet">
</head>
<body>
<a id="top"></a>
@include('layouts.nav')
<main role="main" class="mt-10 px-2">
    @include('flash-messages')
    @yield('content')
</main>
@include('layouts.footer')
</body>
</html>
