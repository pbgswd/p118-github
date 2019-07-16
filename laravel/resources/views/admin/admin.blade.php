@extends('layouts.dashboard',  ['title' => '<i class="fas fa-users-cog"></i> Admin Dashboard'])
@section('content')
<div class="container">
    <h1 class="display-3">Dashboard Content</h1>
        <p>
            Page for admin level management of content, privileges for executive, editors, webmin.
        </p>
    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
        <span>Web Resources</span>
        <a class="d-flex align-items-center text-muted" href="#">
            <span data-feather="plus-circle"></span>
        </a>
    </h6>
    <ul class="nav flex-column mb-2">

        <li class="nav-item">
            <a class="nav-link" href="https://laravel.com/" target="_blank">
                <span data-feather="file-text"></span>
                Laravel
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="https://getbootstrap.com/" target="_blank">
                <span data-feather="file-text"></span>
                Twitter Bootstrap
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="http://getskeleton.com/" target="_blank">
                <span data-feather="file-text"></span>
                Skeleton
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('telescope')}}">
                <span data-feather="file-text"></span>
                Telescope
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="https://fontawesome.com/icons?d=gallery" target="_blank">
                <span data-feather="file-text"></span>
                FontAwesome Icons
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="https://www.tiny.cloud/" target="_blank">
                <span data-feather="file-text"></span>
                TinyMCE
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="https://vuejs.org/" target="_blank">
                <span data-feather="file-text"></span>
                Vue.js
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="https://www.vultr.com/" target="_blank">
                <span data-feather="file-text"></span>
                Vultr
            </a>
        </li>
    </ul>
</div>
@endsection
