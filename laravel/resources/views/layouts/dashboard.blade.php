<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="auto">
    <head>
        <script src="{{ mix('js/admin/app.js') }}" defer></script>

        <link rel="stylesheet" href="/css/fontawesome/fontawesome-free-5.15.2-web/css/all.min.css" />

        <script src="{{ mix('js/admin/color-modes.js') }}" defer></script>

        <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>

        <script defer src="https://cdn.jsdelivr.net/npm/@imacrayon/alpine-ajax@0.9.0/dist/cdn.min.js"></script>

        <script src="{{asset('/js/alpine.min.js')}}" defer></script>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="{{ config('app.name') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title ?? '' }} - {{ config('app.name') }} </title>

        <link href="{{ mix('css/bootstrap.min.css') }}" rel="stylesheet">

        <link href="{{ mix('css/dashboard.css') }}" rel="stylesheet">

        <link href="{{ mix('css/dashboard-inline.css') }}" rel="stylesheet">

        <link href="{{ mix('css/ck_style.css') }}" rel="stylesheet">

        <link rel="stylesheet" href="/css/ckeditor5.css">
    </head>
    <body>
        <header class="navbar sticky-top bg-dark flex-md-nowrap p-0 shadow" data-bs-theme="dark">
            <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 text-white" href="/admin">
                <img src="/storage/public/wrITw0NW1mBky0LidKwgBwtOg9mLcUuDCmQDuiPk.png" alt="p118" class="rounded mx-2">
            </a>
            <ul class="navbar-nav flex-row">
                <li class="nav-item text-nowrap">
                    <button class="nav-link px-3 text-white" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSearch" aria-controls="navbarSearch" aria-expanded="false"
                            aria-label="Toggle search">
                        <svg class="bi"><use xlink:href="#search"/></svg>
                    </button>
                </li>
                <li class="nav-item text-nowrap">
                    <button class="nav-link px-3 text-white" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
                            aria-label="Toggle navigation">
                        <svg class="bi"><use xlink:href="#list"/></svg>
                    </button>
                </li>
            </ul>
            <div id="navbarSearch" class="navbar-search w-100 collapse">
                <input class="form-control w-100 rounded-0 border-0" type="text" placeholder="Search" aria-label="Search">
            </div>
        </header>
        <div class="container-fluid">
            <div class="row">
                <div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary">
                    <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="sidebarMenuLabel">Company name</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
                            @include('layouts.dashboard-list')
                        </div>
                    </div>
                </div>
                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    @include('flash-messages')
                    <h2 class="my-4">
                        {!! $title_icon !!}
                        {!! $title ?? '' !!}
                    </h2>
                    @yield('content')
                    <div class="row mt-5 mb-5 pb-5">
                        <div class="col-12 text-center">
                            <a href="#top" title="Top of page">
                                <i class="fas fa-angle-up"></i>
                                Top of page
                            </a>
                        </div>
                        @include('admin.admin_partials.bottom_info')
                    </div>
                </main>
            </div>
        </div>
        <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
        @include('admin.admin_partials.darkmode')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js" integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp" crossorigin="anonymous"></script><script src="dashboard.js"></script>

    </body>
</html>
