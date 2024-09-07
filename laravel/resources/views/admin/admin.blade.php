@extends('layouts.dashboard',  ['title' => '<i class="fas fa-users-cog"></i> Admin Dashboard'])
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Admin Dashboard</h1>
    </div>
<div class="container">
    <div class="row border border-dark rounded p-3 mb-4 bg-body-secondary">
        <h2>Admin Search</h2>
        <form name="adminsearch" method="post" action="/admin/search">
            @csrf
            <div class="input-group mb-3">
                <button class="btn btn-outline-secondary" type="submit" id="button-addon1">Search</button>
                <input type="text" class="form-control bg-secondary-subtle" name="search" placeholder="Admin Search" aria-label="Search" aria-describedby="button-addon1">
            </div>
        </form>
    </div>
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

    <div class="row border border-dark rounded p-3 pb-5 mt-4">
        <div class="col-4 h-100">
            <div class="card p-3">
                <h5 class="card-title">Users Info</h5>
                <div class="card-body">
                    <div class="ul">
                        <li>{!! $data['counts']['membership'] !!} Members</li>
                        <li>Not including {!! $data['counts']['invite'] !!} Members with pending website invitations</li>
                        <li>As well as {!! $data['counts']['office'] !!} Office Staff</li>
                        <li>{{$data['counts']['executives']}} Executives</li>
                        <li>{{$data['counts']['is_banned']}} Are banned Users</li>
                        <li><a href="{{ route('committees_list') }}">
                                {!! $data['counts']['committees'] !!} Committees
                            </a>
                        </li>
                        <li><a href="{{ route('invite-new-user') }}">Invite new member
                                <i class="far fa-arrow-alt-circle-right"></i>
                            </a>
                        </li>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4 h-100">
            <div class="card p-3">
                <h5 class="card-title">Content Info</h5>
                <div class="card-body">
                    <div class="ul">
                        <li>{!! $data['counts']['pages'] !!} Pages</li>
                        <li>{!! $data['counts']['posts'] !!} Posts</li>
                        <li>{!! $data['counts']['topics'] !!} Topics</li>
                        <li>{{$data['counts']['features']}} Features</li>
                        <li>{{$data['counts']['faqs']}} FAQs</li>
                        <li>{{$data['counts']['venues']}} Venues</li>
                        <li>{{$data['counts']['organizations']}} Organizations</li>
                        <li>{{$data['counts']['employments']}} Job postings</li>
                        <li>{{$data['counts']['minutes']}} Meetings & minutes</li>
                        <li>{{$data['counts']['bylaws']}} Bylaws</li>
                        <li>{{$data['counts']['agreements']}} Agreements</li>
                        <li>{{$data['counts']['policies']}} Policies</li>
                        <li>{{$data['counts']['memoriam']}} Memorials</li>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4 h-100">
            <div class="card p-3">
                <h5 class="card-title">Additional resources</h5>
                <div class="card-body">
                    <div class="ul">
                        <li>{{$data['counts']['carousels']}} Carousel images</li>
                        <li>{{$data['counts']['attachments']}} File attachments</li>
                        <li>{{$data['counts']['proofread']}} Entries to proofread</li>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row border border-dark rounded p-3 pb-5 mt-4">
        <div class="col-12">
            <h3>New stuff</h3>
        </div>
        @if(env('ENABLE_MESSAGING_FEATURE')==1)
            <div class="col-4">
                <div class="card p-3 h-100">
                    <h5 class="card-title">Email Messaging</h5>
                    <div class="card-body">
                     Mailer for general communication, work in progress.
                        <div class="mt-3">
                            <ul class="list-group">
                                <li class="list-group-item"><a href="{{route('admin_messages')}}">List Messages
                                    ( {{$data['messages_count']}} {{Str::plural('message', $data['messages_count'])}} )</a></li>
                                <li class="list-group-item"><a href="{{route('admin_message_create')}}">Create Messages</a></li>
                                <li class="list-group-item"><a href="{{route('admin_email_queue_list')}}">View Mail Queue</a></li>
                                <li class="list-group-item">{{$data['email_queue_count']}} messages currently in the queue</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-4 h-100">
            <a href="{{ route('admin_faqs_list') }}">
                <div class="card p-3">
                    <h5 class="card-title">FAQs</h5>
                    <div class="card-body">
                        Create content for any topic, especially common repeated information.
                    </div>
                </div>
            </a>
        </div>
        <div class="col-4 h-100">
            <a href="{{ route('admin_carousel_list') }}">
                <div class="card p-3">
                    <h5 class="card-title">Carousel Management</h5>
                    <div class="card-body">
                        For fresh pics for the front page slide show, showing the world what we do.
                    </div>
                </div>
            </a>
        </div>
        <div class="col-4 mt-2 h-100">
            <a href="{{ route('admin_qrcodes_list') }}">
                <div class="card p-3">
                    <h5 class="card-title">QR Codes</h5>
                    <div class="card-body">
                       Generate QR codes as needed.
                    </div>
                </div>
            </a>
        </div>
        <div class="col-4 mt-2 h-100">

                <div class="card p-3">
                    <h5 class="card-title">Media insert</h5>
                    <div class="card-body">
                        <ul class="list-group">
not now
                        </ul>
                    </div>
                </div>

        </div>


    </div>
    @role('super-admin')
        <div class="row border border-dark rounded p-3 pb-5 mt-4">
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

