@extends('layouts.dashboard',  ['title_icon' => '<i class="fas fa-users-cog"></i>',
    'title' => 'Web Developer Resources'])
@section('content')
<div class="container">
    <div class="row my-5">
        <div class="col-12">
            <a href="{{ route('blank') }}">Blank Page</a> | <a href="{{ route('attachments_icons_list') }}">Insert img </a> |
           <a href="{{route('drag')}}">drag</a> |
        </div>
    </div>

    <div class="row">
        <div class="col-sm">
            <ul class="list-group flex-column mb-2">
                <li class="list-group-item">
                    <a class="nav-link" href="https://php.net/" target="_blank">
                        <span data-feather="file-text"></span>
                        <i class="bi bi-filetype-php"></i>
                        PHP
                    </a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link" href="{{route('phpinfo')}}" target="_blank">
                        <span data-feather="file-text"></span>
                        <i class="bi bi-filetype-php"></i>
                        phpinfo();
                    </a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link" href="https://dev.mysql.com/doc/" target="_blank">
                        <span data-feather="file-text"></span>
                        <i class="bi bi-database-add"></i>
                        MySQL
                    </a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link" href="https://docs.docker.com/" target="_blank">
                        <span data-feather="file-text"></span>
                        <i class="bi bi-server"></i>
                        Docker
                    </a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link" href="https://laradock.io/" target="_blank">
                        <span data-feather="file-text"></span>
                        <i class="bi bi-server"></i>
                        Laradock.io
                    </a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link" href="https://serversideup.net/open-source/spin/docs" target="_blank">
                        <span data-feather="file-text"></span>
                        <i class="bi bi-gear-wide-connected"></i>
                        Spin
                    </a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link" href="https://gist.github.com/pbgswd/ac7674ff360decbf21352d42e338ac6f"
                       target="_blank">
                        <span data-feather="file-text"></span>
                        <i class="bi bi-github"></i>
                        Laravel Crib Notes
                    </a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link" href="https://laravel.com/" target="_blank">
                        <span data-feather="file-text"></span>
                        <i class="bi bi-filetype-php"></i>
                        Laravel
                    </a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link"
                       href="https://getbootstrap.com/docs/5.3/" target="_blank">
                        <span data-feather="file-text"></span>
                        <i class="bi bi-bootstrap"></i>
                        Bootstrap 5.3 Documentation
                    </a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link" href="http://getskeleton.com/" target="_blank">
                        <span data-feather="file-text"></span>
                        <i class="bi bi-filetype-html"></i>
                        Skeleton
                    </a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link"
                       href="https://analytics.google.com/analytics/web/#/a192453396p265939066/admin/streams/table/"
                       target="_blank">
                        <span data-feather="file-text"></span>
                        <i class="bi bi-google"></i>
                        Google Analytics
                    </a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link" href="https://www.google.com/recaptcha/admin/site/449110639" target="_blank">
                        <span data-feather="file-text"></span>
                        <i class="bi bi-google"></i>
                        Google Recaptcha V.3
                    </a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link" href="https://aws.amazon.com/" target="_blank">
                        <span data-feather="file-text"></span>
                        <i class="bi bi-amazon"></i>
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
                        <i class="bi bi-git"></i>
                        BitBucket
                    </a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link" href=" https://trello.com/b/ArhvG4NS/local118" target="_blank">
                        <span data-feather="file-text"></span>
                        <i class="bi bi-trello"></i>
                        Trello Board
                    </a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link" href="https://fontawesome.com/v5/search" target="_blank">
                        <span data-feather="file-text"></span>
                        <i class="bi bi-file-earmark-font"></i>
                        FontAwesome Icons V5
                    </a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link" href="https://icons.getbootstrap.com/" target="_blank">
                        <span data-feather="file-text"></span>
                        <i class="bi bi-bootstrap"></i>
                        Bootstrap Icons
                    </a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link" href="https://ckeditor.com/ckeditor-5/builder/" target="_blank">
                        <span data-feather="file-text"></span>
                        <i class="bi bi-filetype-html"></i>
                        CkEditor
                    </a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link" href="https://alpinejs.dev/" target="_blank">
                        <span data-feather="file-text"></span>
                        <i class="bi bi-filetype-js"></i>
                        Alpine.js
                    </a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link" href="https://www.vultr.com/" target="_blank">
                        <span data-feather="file-text"></span>
                        <i class="bi bi-cloud"></i>
                        Vultr Cloud hosting
                    </a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link" href="http://localhost:8080/" target="_blank">
                        <span data-feather="file-text"></span>
                        <i class="bi bi-database"></i>
                        Localhost DB
                    </a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link" href="https://sendgrid.com/en-us" target="_blank">
                        <span data-feather="file-text"></span>
                        <i class="bi bi-envelope-at"></i>
                        SendGrid.com (free production emails)
                    </a>
                </li>

                <li class="list-group-item">
                    <a class="nav-link" href="https://mailtrap.io/" target="_blank">
                        <span data-feather="file-text"></span>
                        <i class="bi bi-envelope-at"></i>
                        MailTrap.io for test emails
                    </a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link" href="http://localhost:1080/" target="_blank">
                        <span data-feather="file-text"></span>
                        <i class="bi bi-envelope-at"></i>
                        MailDev on Localhost (not in use)
                    </a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link" href="https://mailchimp.com/developer/" target="_blank">
                        <span data-feather="file-text"></span>
                        <i class="bi bi-envelope-at"></i>
                        MailChimp Developers
                    </a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link" href="https://accounts.icdsoft.com/login" target="_blank">
                        <span data-feather="file-text"></span>
                        <i class="bi bi-pc-display-horizontal"></i>
                        ICDSoft Domain mgmt
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
