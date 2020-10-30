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
        <title>{{ config('app.name') }}</title>
        <script src="/js/bootstrap-datepicker.min.js"></script>
        <script
            src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=7mnn730lyfsp3y0qkbgx80p4156c5bb0ooa9i201b4r5by7k">
        </script>
        <script src="/js/tinymce.js"></script>
        <link rel="canonical" href="http://{{env('APP_URL')}}/">
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
        <!-- Styles -->
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
        <style>
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }
            .dropcap {
                font-size: 4rem;
                color: #903;
                float: left;
                line-height: 60px;
                padding-right: 4px;
                padding-left: 3px;
            }
            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                    font-size: 3.5rem;
                }
            }
            @media (min-width: 577px) {
                .container {
                    padding:1.5rem;
                }
            }
            @media (max-width: 576px) {
                h1.display-3 {
                  font-size: 16px;
                    font-weight: bold;
                }
                h2 { font-size: 14px;}
                h3 { font-size: 12px;}
                h4 { font-size: 11px;}
                p { font-size: 10px;}

                img {
                    max-width: 100px;
                }
                .container {
                    padding:0.5em;
                }
            }
        </style>
        <!-- Custom styles for this template -->
        <link href="{{ mix('css/jumbotron.css') }}" rel="stylesheet">
    </head>
    <body>
        <a id="top"></a>
        @include('layouts.nav')
        <main role="main">
            <div class="jumbotron">
                @include('flash-messages')
                @yield('content')
            </div>
            <div class="row">
                    @yield('data')
            </div> <!-- /container -->
        </main>
        @include('layouts.footer')
    </body>
</html>

