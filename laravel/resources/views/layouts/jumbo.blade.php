<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
        <meta name="generator" content="Jekyll v3.8.5">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name') }}</title>
        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}"></script>
        <link rel="canonical" href="http://project118/hello/">
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
        </style>
        <!-- Custom styles for this template -->
        <link href="{{ mix('css/jumbotron.css') }}" rel="stylesheet">
    </head>
    <body>
        <a name="top"></a>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <a class="navbar-brand" href="{{ route('hello') }}">{{config('app.name')}}</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
                    aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('hello') }}" title="Home Page {{ config('app.name') }}"><i
                                class="fas fa-home"></i><span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/page/about-us">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('topics')}}">Topics</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('pages')}}">Pages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Hire Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('contact')}}">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('venues')}}">Venues</a>
                    </li>
                    @guest
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="#">Collective Agreements</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Sub Committees</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Departments</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Resources</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">People</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/site" title="Members"><i class="fas fa-industry"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('admin')}}" title="Admin"><i
                                    class="fas fa-tachometer-alt"></i></a>
                        </li>
                    @endguest
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#">Disabled</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true"
                           aria-expanded="false">Dropdown</a>
                        <div class="dropdown-menu" aria-labelledby="dropdown01">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </li>
                </ul>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <div style="color: white">Left Div</div>
                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a href="/login">
                                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Login</button>
                                </a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item float-right">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a id="" class="nav-link" href="#">
                                    <i class="fas fa-user"></i> {{ Auth::user()->name }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="btn btn-outline-success my-2 my-sm-0 float-right" type="submit">Logout
                                    </button>
                                </form>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main role="main">
            <!-- Main jumbotron for a primary marketing message or call to action -->
            <div class="jumbotron">
                @include('flash-messages')
                @yield('content')
            </div>
            <div class="container">
                @yield('data')
                <hr/>
            </div> <!-- /container -->
        </main>
        <footer class="container">
            <div style="margin-bottom: 1em;">
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
            <div><a href="/page/terms-of-use">Terms of Use</a> | <a href="/page/privacy-policy">Privacy Policy</a> | <a
                    href="/page/disclaimer">Disclaimer</a> | <a href="/page/links">Links</a> | <a href="/page/apply-for-work">Apply
                    for work</a></div>
            <div class="text-left" style="margin-top: 2em;"><i
                    class="far fa-copyright"></i> {{ config('app.name')}} <?php echo date('Y'); ?></div>
            <div class="text-right"><a href="#top" title="Top of page"><i class="fas fa-angle-up"></i> Top of page</a>
            </div>
            <div style="height: 2em;"></div>
        </footer>
        <script src="/js/jquery-3.3.1.slim.min.js"
                integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
                crossorigin="anonymous"></script>
        <script>window.jQuery || document.write('<script src="/js/jquery-slim.min.js"><\/script>')</script>
        <script src="/js/bootstrap.bundle.min.js"
                integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o"
                crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
              integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        </body>
</html>

