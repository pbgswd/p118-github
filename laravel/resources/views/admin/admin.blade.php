@extends('layouts.dashboard',  ['title' => '<i class="fas fa-users-cog"></i> Admin Dashboard'])
@section('content')
<div class="container">
    <h1 class="display-3">Dashboard Content</h1>
        <p>
            Page for admin level management of content, privileges for executive, editors, webmin.
        </p>
    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
        <span>Web Developer Resources</span>
    </h6>
    <div class="row">
        <div class="col-sm">
            <ul class="nav flex-column mb-2">
                <li class="nav-item">
                    <a class="nav-link" href="https://php.net/" target="_blank">
                        <span data-feather="file-text"></span>
                        PHP
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://dev.mysql.com/doc/" target="_blank">
                        <span data-feather="file-text"></span>
                        MySQL
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://docs.docker.com/" target="_blank">
                        <span data-feather="file-text"></span>
                        Docker
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://gist.github.com/pbgswd/ac7674ff360decbf21352d42e338ac6f" target="_blank">
                        <span data-feather="file-text"></span>
                        Laravel Crib Notes
                    </a>
                </li>
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
                    <a class="nav-link" href="#">
                        <span data-feather="file-text"></span>
                        Telescope
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-sm">
            <ul class="nav flex-column mb-2">
                <li class="nav-item">
                    <a class="nav-link" href="https:///bitbucket.org" target="_blank">
                        <span data-feather="file-text"></span>
                        BitBucket
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://app.asana.com/0/home/132683619818221" target="_blank">
                        <span data-feather="file-text"></span>
                        Asana
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href=" https://trello.com/b/ArhvG4NS/local118" target="_blank">
                        <span data-feather="file-text"></span>
                        Trello Board
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
                <li class="nav-item">
                    <a class="nav-link" href="http://localhost:8080/" target="_blank">
                        <span data-feather="file-text"></span>
                        Localhost DB
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="http://localhost:1080/" target="_blank">
                        <span data-feather="file-text"></span>
                        MailDev on Localhost
                    </a>
                </li>
            </ul>
        </div>
    </div>


@endsection
