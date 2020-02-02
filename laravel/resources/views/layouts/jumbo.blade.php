<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="IATSE Local 118 is the labour union supplying technicians, stagehands, artisans and craftspeople to the Greater Vancouver entertainment industry, including live theatre, rock and roll, and trade shows. Local 118 has a large, skilled, and experienced workforce ready to meet the needs of your production.">
        <meta name="keywords" content="iatse, local 118, stagehand, craftspeople, theatre, theater, live theatre,  rock and roll, trade shows, conventions, labour union, labor union, technicians, greater Vancouver entertainment industry, Vancouver, British Columbia, Canada">
        <meta name="author" content="IATSE Local 118 Web Admin">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name') }}</title>
        <!-- Scripts -->
        <script src="/js/popper.min.js"></script>
        <script src="/js/bootstrap.bundle.min.js"></script>
        <script src="/js/bootstrap-datepicker.min.js"></script>
        <script src="/js/jquery.slim.min.js"></script>


        <script src="{{ mix('js/app.js') }}"></script>

        <script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=7mnn730lyfsp3y0qkbgx80p4156c5bb0ooa9i201b4r5by7k"></script>
        <script src="/js/tinymce.js"></script>
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
                h2 {
                    font-size: 14px;
                }
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
                        <a class="nav-link" href="/page/about-us">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('topics')}}">Topics</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('pages')}}">Pages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('posts')}}">Posts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('hireus')}}">Hire Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('contact')}}">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('venues')}}">Venues</a>
                    </li>
                    @guest
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('admin')}}" title="Admin"><i
                                    class="fas fa-tachometer-alt"></i></a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="dropdown" data-toggle="dropdown" aria-haspopup="true"
                               aria-expanded="true">Menu</a>
                            <div class="dropdown-menu" aria-labelledby="dropdown">
                                <a class="dropdown-item" href="{{route('member', Auth::user()->id)}}" title="My Profile">&nbsp;<i class="fas fa-user"></i> {{ Auth::user()->name }}</a>
                                <a class="dropdown-item" href="{{route('committees')}}">&nbsp; <i class="fas fa-users"></i>Committees</a>
                                <a class="dropdown-item" href="{{route('list_meetings')}}">&nbsp; <i class="far fa-folder"></i> Meetings & Minutes</a>
                                <a class="dropdown-item" href="{{route('members')}}">&nbsp; <i class="fas fa-user-friends"></i>Members</a>
                                <a class="dropdown-item" href="/site">&nbsp; <i class="fas fa-industry"></i>Landing Page</a>
                            </div>
                        </li>
                    @endguest
                </ul>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
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
                <form class="form-inline my-2 my-lg-0" action="{{route('search')}}" method="post">
                    {!! csrf_field() !!}
                    <i class="fas fa-search"></i> &nbsp;
                    <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search" name="search">
                    <button type="submit" name="Submit" value="Submit" class="btn btn-outline-success my-2 my-sm-0">Search</button>
                </form>
            </div>
            <div>
                <a href="/page/terms-of-use">Terms of Use</a> | <a href="/page/privacy-policy">Privacy Policy</a> | <a
                    href="/page/disclaimer">Disclaimer</a> | <a href="/page/links">Links</a> | <a href="/page/apply-for-work">Apply
                    for work</a>
            </div>
            <div class="text-left" style="margin-top: 2em;">
                <i class="far fa-copyright"></i> {{ config('app.name')}} <?php echo date('Y'); ?>
            </div>
            <div class="text-right">
                <a href="#top" title="Top of page"><i class="fas fa-angle-up"></i> Top of page</a>
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

