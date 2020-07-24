<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="IATSE Local 118 is the labour union supplying technicians, stagehands,
        artisans and craftspeople to the Greater Vancouver entertainment industry, including live theatre,
        rock and roll, and trade shows. Local 118 has a large, skilled, and experienced workforce ready to meet the
        needs of your production.">
        <meta name="keywords" content="iatse, local 118, stagehand, craftspeople, theatre, theater, live theatre,
        rock and roll, trade shows, conventions, labour union, labor union, technicians, greater Vancouver
        entertainment industry, Vancouver, British Columbia, Canada">
        <meta name="author" content="IATSE Local 118 Web Admin">
        <!-- CSRF Token -->
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
        <a name="top"></a>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <a class="navbar-brand" href="{{ route('hello') }}">{{config('app.name')}}</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
                    aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">Menus
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav mr-auto">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            About Us
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                            <a class="dropdown-item" href="{{route('page_show', 'history')}}" title="History">
                                History
                            </a>
                            <a class="dropdown-item" href="#">Governance</a>
                            <a class="dropdown-item" href="{{route('executive')}}">Executive</a>
                            <a class="dropdown-item" href="{{route('bylaws_list_public')}}">C & B</a>
                            <a class="dropdown-item" href="{{route('page_show', 'links')}}">Links</a>
                            <a class="dropdown-item" href="#">118 Store</a>
                            <a class="dropdown-item" href="#">Photos</a>
                        </div>
                    </div>&nbsp;
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Membership
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdown">
                            <a class="dropdown-item" href="{{route('page_show', 'apply-for-work')}}"
                               title="Apply for Work">Apply</a>
                            <a class="dropdown-item" href="{{route('page_show', 'skills-verification-procedure')}}">
                                Skills Update Procedure
                            </a>
                            <a class="dropdown-item" href="#">Availability & Dispatch</a>
                            <a class="dropdown-item" href="#">Dues</a>
                            <a class="dropdown-item" href="#">Leaving Membership</a>
                        </div>
                    </div>&nbsp;
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Benefits
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdown">
                            <a class="dropdown-item" href="{{route('topic_show', 'health-and-welfare-info')}}"
                               title="Health & Welfare Overview">H & W Overview</a>
                            <a class="dropdown-item" href="#">RRSP Overview</a>
                            <a class="dropdown-item" href="#">Financial Assistance</a>
                            <a class="dropdown-item" href="#">Discounts & Promotions</a>
                            <a class="dropdown-item" href="#">Health & Safety</a>
                        </div>
                    </div>&nbsp;
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            News & Events
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdown">
                            <a class="dropdown-item" href="#" title="Events">Event Listings</a>
                            <a class="dropdown-item" href="#">Members Only Events</a>
                            <a class="dropdown-item" href="#">Calendar</a>
                            <a class="dropdown-item" href="#">News</a>
                            <a class="dropdown-item" href="#">Photos</a>
                        </div>
                    </div>&nbsp;
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Employers & Venues
                        </button>&nbsp;
                        <div class="dropdown-menu" aria-labelledby="dropdown">
                            <a class="dropdown-item" href="{{route('organizations')}}">
                                <i class="fas fa-user-tie"></i>
                                Organizations</a>
                            <a class="dropdown-item" href="{{route('venues')}}">
                                <i class="far fa-building"></i> Venues</a>
                            <a class="dropdown-item" href="{{route('agreement_show', 38)}}" title="">
                                Master Rate Sheet</a>
                            <a class="dropdown-item" href="{{route('agreements_list_public')}}">
                                <i class="far fa-handshake"></i>
                                Agreements</a>
                        </div>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Contact Us
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdown">
                            <a class="dropdown-item" href="{{route('hireus')}}">Why Hire Union</a>
                            <a class="dropdown-item" href="{{route('contact')}}">Contact</a>
                        </div>
                    </div>
                    @guest
                    @else&nbsp;
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Members
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdown">
                                <a class="dropdown-item" href="{{route('list_meetings')}}"><i class="far fa-folder"></i>
                                    Meetings & Minutes</a>
                                <a class="dropdown-item" href="#"><i class="far fa-folder"></i> Budgets & Audits</a>
                                <a class="dropdown-item" href="{{route('committees')}}"><i class="fas fa-users"></i>
                                    Committees</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-users"></i> elections</a>
                                <a class="dropdown-item" href="{{route('jobs_list')}}"><i class="fas fa-hard-hat"></i>
                                    Jobs</a>
                                <a class="dropdown-item" href="https://login.callsteward.ca/" target="_blank"
                                   title="Link to CallSteward">
                                    <i class="fas fa-headset"></i> CS</a>
                                <a class="dropdown-item" href="{{route('member', Auth::user()->id)}}" title="My Profile">
                                    <i class="fas fa-user"></i> {{ Auth::user()->name }}</a>
                                <a class="dropdown-item" href="{{route('members')}}">
                                    <i class="fas fa-user-friends"></i> Members</a>
                                <a class="dropdown-item" href="{{route('bylaws_list_public')}}">
                                    <i class="fas fa-gavel"></i> By-Laws</a>
                                <a class="dropdown-item" href="{{route('policies_list_public')}}">
                                    <i class="fas fa-scroll"></i>  Policies</a>
                                <a class="dropdown-item" href="/site"><i class="fas fa-industry">
                                    </i> Landing Page</a>
                            </div>
                        </div>
                    @endguest
                    @guest
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="/site"><i class="fas fa-industry"></i> Landing Page</a>
                    </li>
                        @role('super-admin')
                             <li class="nav-item">
                                <a class="nav-link" href="{{route('admin')}}" title="Admin"><i
                                        class="fas fa-tachometer-alt"></i></a>
                            </li>
                        @endrole
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
                                    <button class="btn btn-outline-success my-2 my-sm-0 float-right" type="submit">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main role="main">
            <div class="jumbotron">
                @include('flash-messages')
                @yield('content')
            </div>
            <div class="row">
                    @yield('data')
            </div> <!-- /container -->
        </main>
        <footer class="container border border-dark rounded-lg mb-2">
            <div class="row mb-5">
                <div class="col-3">
                    <a href="http://www.bcfed.com/" title="BC Federation of Labour" target="_blank">
                        <img src="/storage/public/w8x7LmSqnTLjEHyftPbYRh3JFmBNh1GOVgjvGX6z.png" class="p-1" />
                    </a>
                </div>
                <div class="col-3">
                    <a href="http://www.iatse-intl.org/" title="IATSE International" target="_blank">
                        <img src="/storage/public/dK2ytnJHZU1Q0eJ3FTJYG9ogwR9V1zLHzB1ab9RE.png" class="p-1" />
                    </a>
                </div>
                <div class="col-3">
                    <a href="https://canadianlabour.ca/" title="Canadian labour Congress" target="_blank">
                        <img src="/storage/public/KKVqVfiv4hU4ayxNukvYJsN5EKgIqnYfx5mssuT7.png" class="p-1" />
                    </a>
                </div>
                <div class="col-3">
                    <a href="http://www.vdlc.ca/" title="Vancouver & District Labour Congress" target="_blank">
                        <img src="/storage/public/mlL21yHivsR7ztxYh3hRB2Y8j9rcFzY5BfXtSLE1.jpeg" class="p-1" />
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-4">
                    <a href="/page/terms-of-use">Terms of Use</a> | <a href="/page/privacy-policy">Privacy Policy</a> |
                    <a href="/page/disclaimer">Disclaimer</a> | <a href="/page/links">Links</a> |
                    <a href="/page/apply-for-work">Apply for work</a>
                    @guest
                    @else
                        @role('super-admin')
                        | <a href="{{route('admin')}}" title="Admin"><i
                                class="fas fa-tachometer-alt"></i></a>
                        @endrole
                </div>
                @endguest
            </div>
                @guest
                <div class="row">
                    <div class="col-12 mb-4">
                        <a href="/login">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Login</button>
                        </a>
                    </div>
                </div>
                @else
                <div class="row">
                    <div class="col-6 mb-4">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="btn btn-outline-success my-2 my-sm-0 float-left" type="submit">
                                Logout
                            </button>
                        </form>
                    </div>
                    <div class="col-6 mb-5">
                        <form class="form-inline my-2 my-lg-0" action="{{route('search')}}" method="post">
                            {!! csrf_field() !!}
                            <i class="fas fa-search"></i> &nbsp;
                            <input class="form-control mr-sm-2" type="text" placeholder="Search"
                                   aria-label="Search" name="search">
                            <button type="submit" name="Submit" value="Submit"
                                    class="btn btn-outline-success my-2 my-sm-0">
                                Search
                            </button>
                        </form>
                    </div>
                </div>
                @endguest
            </div>

            <div class="row mb-6">
                <div class="col-6">
                    <h2>IATSE Local 118</h2>
                    <h4>#206 - 2940 Main Street<br />
                    Vancouver, BC, V5T 3G3</h4>
                </div>
                <div class="col-6">
                    <h3>
                        <a href="https://goo.gl/maps/pXb7Bv8n1jHGykjh8" target="_blank" title="IATSE Local 118 Office">
                            <i class="fas fa-map-marked-alt"></i>
                            Maps
                        </a>
                    </h3>
                    <h3><a href="tel:604-685-9553"><i class="fas fa-phone-square"></i> 604-685-9553</a></h3>
                    <h3>
                        <a href="mailto:office@iatse118.com"><i class="fas fa-envelope"></i> office@iatse118.com</a>
                    </h3>
                </div>

            </div>


            <div class="row mt-2 mb-lg-2">
                <div class="col-4 text-left">
                    <i class="far fa-copyright"></i> <?php echo date('Y'); ?> {{ config('app.name')}}
                </div>
                <div class="col-4 text-left">
                    <h6>Site by Peter Gordon <br />& IATSE 118 Members</h6>
                </div>
                <div class="col-4 text-right">
                    <a href="#top" title="Top of page"><i class="fas fa-angle-up"></i> Top of page</a>
                </div>
            </div>




        </footer>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
              integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf"
              crossorigin="anonymous">
        <script src="/js/jquery-3.4.1.slim.min.js"
                integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
                crossorigin="anonymous">
        </script>
        <script>window.jQuery || document.write('<script src="/js/jquery.slim.min.js"><\/script>')</script>
        <script src="/js/bootstrap.bundle.min.js"
                integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm"
                crossorigin="anonymous">
        </script>
        </body>
</html>

