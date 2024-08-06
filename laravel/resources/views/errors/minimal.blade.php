<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>
        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .code {
                font-size: 48px;
                padding: 0 15px 0 15px;
                text-align: center;
            }

            .message {
                font-size: 24px;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row d-flex justify-content-center text-center mt-6"  style="padding-top: 4em;">
                <div class="col-sm-12 col-md-6 mx-auto">
                    <a href="/">
                        <i class="fas fa-home fa-2x text-secondary"></i> Home Page
                    </a>
                </div>
                <div class="col-sm-12 col-md-6">
                    <a href="/login">
                        <i class="fas fa-sign-in-alt fa-2x text-secondary"></i> Login
                    </a>
                </div>
            </div>
            <div class="flex-center position-ref full-height">
                <div class="row">
                    <div class="code">
                    Error     @yield('code')
                    </div>
                    <div class="message" style="padding: 10px;">
                        @yield('message')
                    </div>
                </div>

            </div>
        </div>
    </body>
</html>
