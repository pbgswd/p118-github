@extends('layouts.dashboard',  ['title' => '<i class="fas fa-users-cog"></i>  Web Developer Resources'])
@section('content')
<div class="container">
    <div class="row my-5">
        <div class="col-12">
            <a href="{{ route('blank') }}">Blank Page</a> | <a href="{{ route('development') }}">Development Page</a>
        </div>
    </div>

    <div class="row">
        <div class="col-sm">
            <ul class="list-group flex-column mb-2">
                <li class="list-group-item">
                    <a class="nav-link" href="https://php.net/" target="_blank">
                        <span data-feather="file-text"></span>
                        PHP
                    </a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link" href="{{route('phpinfo')}}" target="_blank">
                        <span data-feather="file-text"></span>
                        phpinfo();
                    </a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link" href="https://dev.mysql.com/doc/" target="_blank">
                        <span data-feather="file-text"></span>
                        MySQL
                    </a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link" href="https://docs.docker.com/" target="_blank">
                        <span data-feather="file-text"></span>
                        Docker
                    </a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link" href="https://gist.github.com/pbgswd/ac7674ff360decbf21352d42e338ac6f"
                       target="_blank">
                        <span data-feather="file-text"></span>
                        Laravel Crib Notes
                    </a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link" href="https://laravel.com/" target="_blank">
                        <span data-feather="file-text"></span>
                        Laravel
                    </a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link"
                       href="https://getbootstrap.com/docs/5.3/" target="_blank">
                        <span data-feather="file-text"></span>
                        Bootstrap 5.3 Documentation
                    </a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link" href="http://getskeleton.com/" target="_blank">
                        <span data-feather="file-text"></span>
                        Skeleton
                    </a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link"
                       href="https://analytics.google.com/analytics/web/#/a192453396p265939066/admin/streams/table/"
                       target="_blank">
                        <span data-feather="file-text"></span>
                        Google Analytics
                    </a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link" href="https://www.google.com/recaptcha/admin/site/449110639" target="_blank">
                        <span data-feather="file-text"></span>
                        Google Recaptcha V.3
                    </a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link" href="https://aws.amazon.com/" target="_blank">
                        <span data-feather="file-text"></span>
                        AWS
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-sm">
            <ul class="list-group mb-2">
                <li class="list-group-item">
                    <a class="nav-link" href="https:///bitbucket.org" target="_blank">
                        <span data-feather="file-text"></span>
                        BitBucket
                    </a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link" href=" https://trello.com/b/ArhvG4NS/local118" target="_blank">
                        <span data-feather="file-text"></span>
                        Trello Board
                    </a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link" href="https://fontawesome.com/v5/search" target="_blank">
                        <span data-feather="file-text"></span>
                        FontAwesome Icons V5
                    </a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link" href="https://ckeditor.com/ckeditor-5/builder/" target="_blank">
                        <span data-feather="file-text"></span>
                        CkEditor
                    </a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link" href="https://alpinejs.dev/" target="_blank">
                        <span data-feather="file-text"></span>
                        Alpine.js
                    </a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link" href="https://www.vultr.com/" target="_blank">
                        <span data-feather="file-text"></span>
                        Vultr
                    </a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link" href="http://localhost:8080/" target="_blank">
                        <span data-feather="file-text"></span>
                        Localhost DB
                    </a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link" href="http://localhost:1080/" target="_blank">
                        <span data-feather="file-text"></span>
                        MailDev on Localhost
                    </a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link" href="https://mailchimp.com/developer/" target="_blank">
                        <span data-feather="file-text"></span>
                        MailChimp Developers
                    </a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link" href="https://accounts.icdsoft.com/login" target="_blank">
                        <span data-feather="file-text"></span>
                        ICDSoft Domain mgmt
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
