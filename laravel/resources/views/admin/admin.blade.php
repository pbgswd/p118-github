@extends('layouts.dashboard',  ['title' => '<i class="fas fa-users-cog"></i> Admin Dashboard'])
@section('content')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Admin Dashboard</h1>
    </div>
<div class="container">
    <div class="row border border-dark rounded p-3">
        @role('super-admin')
            <h3>
                Members with the <strong>super-admin</strong> role can manage users, content, committees,
                and all aspects of the website.
            </h3>
        @endrole
        @role('office')
            <h3>
                Members with the <strong>office</strong> or <strong>super-admin</strong> role can manage users.
            </h3>
        @endrole
        @role('committee')
            <h3>
                Members with the <strong>committee</strong> management  or <strong>super-admin</strong>
                role can manage committee content, and members.
            </h3>
        @endrole
        @role('writer')
            <h3>
                Members with the <strong>writer</strong>  or <strong>super-admin</strong> role can manage the various
                sections of content on the website.
            </h3>
        @endrole
        <h3>
            Use the links in the menu on the left for available sections and the <strong>Search</strong> input
            field above to find records.
        </h3>
    </div>
    <div class="row border border-dark rounded p-3 m-2">
        <div class="col-12">
            <h3>New stuff</h3>
        </div>
        <div class="col-4">
            <a href="{{ route('admin_faqs_list') }}">
                <div class="card p-3">
                    <h5 class="card-title">FAQs</h5>
                    <div class="card-body">
                        Create content for any topic, especially common repeated information.
                    </div>
                </div>
            </a>
        </div>
        <div class="col-4">
            <a href="{{ route('admin_carousel_list') }}">
                <div class="card p-3">
                    <h5 class="card-title">Carousel Management</h5>
                    <div class="card-body">
                        For fresh pics for the front page slide show, showing the world what we do.
                    </div>
                </div>
            </a>
        </div>
        <div class="col-4">
            <a href="{{ route('admin_qrcodes_list') }}">
                <div class="card p-3">
                    <h5 class="card-title">QR Codes</h5>
                    <div class="card-body">
                       Generate QR codes as needed.
                    </div>
                </div>
            </a>
        </div>
    </div>
    @role('super-admin')
        <div class="row border border-dark rounded p-3 m-2">
            <div class="col-12">
                <h3>Site Developer</h3>
            </div>
            <div class="col-4">
                <a href="{{ route('blank') }}">
                    <div class="card p-3">
                        <h5 class="card-title">
                            <span data-feather="file"></span>
                            Blank
                        </h5>
                        <div class="card-body">
                           Blank page for dev and things.
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-4">
                <a href="{{ route('developer') }}">
                    <div class="card p-3">
                        <h5 class="card-title">
                            <span data-feather="file"></span>
                            Developer Resources
                        </h5>
                        <div class="card-body">
                            Links to developer tools for the site.
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-4">
                <a href="{{ route('development') }}">
                    <div class="card p-3">
                        <h5 class="card-title">
                            <span data-feather="file"></span>
                            Development Page
                        </h5>
                        <div class="card-body">
                            Page for various things.
                        </div>
                    </div>
                </a>
            </div>
        </div>
    @endrole
    <div class="row border border-dark rounded mt-3 p-lg-5 d-block d-md-none d-lg-none">
        @include(('layouts.dashboard-list'))
    </div>
</div>
@endsection

