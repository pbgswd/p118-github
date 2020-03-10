<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="{{ config('app.name') }}">
        <meta name="author" content="Peter Gordon">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name') }}</title>
        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
        <script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=7mnn730lyfsp3y0qkbgx80p4156c5bb0ooa9i201b4r5by7k"></script>
        <script src="/js/tinymce.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        <script src="/js/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script>window.jQuery || document.write('<script src="/js/jquery-slim.min.js"><\/script>')</script>
        <script src="/js/bootstrap.bundle.min.js" integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
        <script src="{{ mix('/js/dashboard.js') }}"></script>
        <!-- Datepicker -->
        <link href='/css/bootstrap-datepicker.min.css' rel='stylesheet' type='text/css'>
        <script src='/js/bootstrap-datepicker.min.js' type='text/javascript'></script>
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
            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                    font-size: 3.5rem;
                }
            }
        </style>
        <!-- Custom styles for this template -->
        <link href="{{ mix('/css/dashboard.css') }}" rel="stylesheet">
    </head>
    <body>
        <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
            <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">{{ config('app.name') }}</a>
            <span style="color: #999999; padding-left: 1em; font-weight: bolder;">{{ Auth::user()->name }}</span>
            <input class="form-control form-control-dark w-60" type="text" placeholder="Search" aria-label="Search">
            <ul class="navbar-nav px-3">
                <li class="nav-item text-nowrap">
                    <a class="nav-link" href="/logout"></a>
                </li>
            </ul>
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-outline-success my-2 my-sm-0 float-left" type="submit">Logout
                </button>
            </form>
        </nav>
        <div class="container-fluid">
            <div class="row">
                <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                    <div class="sidebar-sticky">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ route('hello')}}">
                                    <span data-feather="home"></span>
                                    Home Page
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ route('admin')}}">
                                    <span data-feather="home"></span>
                                    Admin Dashboard <span class="sr-only">(current)</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('topics_list')}}">
                                    <span data-feather="file"></span>
                                    Topics
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('users_list')}}">
                                    <span data-feather="file"></span>
                                    Members
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('list_invited_users')}}">
                                    <span data-feather="file"></span>
                                    Invite Members
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('meetings_list')}}">
                                    <span data-feather="file"></span>
                                    Meetings & Minutes
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('admin_bylaws_list')}}">
                                    <span data-feather="file"></span>
                                    Constitution & By-Laws
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('venues_list')}}">
                                    <span data-feather="file"></span>
                                    Venues
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('organizations_list')}}">
                                    <span data-feather="file"></span>
                                    Organizations
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('committees_list')}}">
                                    <span data-feather="file"></span>
                                    Committees
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('agreements_list')}}">
                                    <span data-feather="file"></span>
                                    Agreements
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('attachments_list')}}">
                                    <span data-feather="file"></span>
                                    Images & Attachments
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('pages_list')}}">
                                    <span data-feather="file"></span>
                                    Pages
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('posts_list')}}">
                                    <span data-feather="file"></span>
                                    Posts
                                </a>
                            </li>
                             <li class="nav-item">
                                <a class="nav-link" href="{{route('roles_list')}}">
                                    <span data-feather="file"></span>
                                    Roles
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('blank')}}">
                                    <span data-feather="file"></span>
                                    Blank Page
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('admin_employment_list')}}">
                                    <span data-feather="file"></span>
                                    Employment
                                </a>
                            </li>
                        </ul>
                        <hr />
                    </div>
                </nav>
                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">{!! $title ?? '' !!}</h1>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group mr-2">
                                <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                                <span data-feather="calendar"></span>
                                This week
                            </button>
                        </div>
                    </div>
                    @include('flash-messages')
                    @yield('content')
                </main>
            </div>
        </div>
    </body>
</html>
