@extends('layouts.dashboard',  ['title_icon' => '<i class="fas fa-tachometer-alt"></i></i>', 'title' => 'Admin Dashboard'])
@section('content')
<div class="container">
    <div class="row border border-dark rounded p-3 mb-4 bg-body-secondary">
        <h4><i class="fas fa-search"></i> Admin Search</h4>
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
            <h5>
                Members with the <strong>super-admin</strong> role can manage users, content, committees,
                and all aspects of the website.
            </h5>
        @endrole
        @role('office')
            <h5>
                Members with the <strong>office</strong> or <strong>super-admin</strong> role can manage users.
            </h5>
        @endrole
        @role('committee')
            <h5>
                Members with the <strong>committee</strong> management  or <strong>super-admin</strong>
                role can manage committee content, and members.
            </h5>
        @endrole
        @role('writer')
            <h5>
                Members with the <strong>writer</strong>  or <strong>super-admin</strong> role can manage the various
                sections of content on the website.
            </h5>
        @endrole
        <p>
            Use the links in the menu on the left for available sections and the <strong>Search</strong> input
            field above to find records.
        </p>
    </div>
    <div class="row border border-dark rounded p-3 pb-5 mt-4">
        <h4 class="text-center">Site content information</h4>
        <div class="col-sm-12 col-md-4 mb-3 h-100">
            <div class="card p-3">
                <h5 class="card-title">Users Info</h5>
                <div class="card-body">
                    <ul class="list-group">
                        <li>{!! $data['counts']['membership'] !!} Members</li>
                        <li>Not including {!! $data['counts']['invite'] !!} Members with pending website invitations</li>
                        <li>As well as {!! $data['counts']['office'] !!} Office Staff</li>
                        <li>{{$data['counts']['executives']}} Executives</li>
                        <li>{{$data['counts']['is_banned']}} Are banned Users</li>
                        <li><a href="{{route('admin_users_list_banned')}}">List banned Users</a></li>
                        <li><a href="{{ route('committees_list') }}">
                                {!! $data['counts']['committees'] !!} Committees
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('invite-new-user') }}">Invite new member
                                <i class="far fa-arrow-alt-circle-right"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-4 mb-3 h-100">
            <div class="card p-3">
                <h5 class="card-title">Content Info</h5>
                <div class="card-body">
                    <ul class="list-group">
                        <li>{{ $data['counts']['pages'] }} Pages</li>
                        <li>{{ $data['counts']['posts'] }} Posts</li>
                        <li>{{ $data['counts']['topics'] }} Topics</li>
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
                        <li>{{$data['counts']['total_messages']}} Messages</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-4  mb-3 h-100">
            <div class="card p-3">
                <h5 class="card-title">Additional Resources</h5>
                    <ul class="card-body">
                        <li>{{$data['counts']['carousels']}} Carousel images</li>
                        <li>{{$data['counts']['attachments']}} File attachments</li>
                        <li>{{$data['counts']['proofread']}} Entries to proofread</li>
                    </ul>
            </div>
        </div>
    </div>
    <div class="row border border-dark rounded p-3 pb-5 mt-4">
        <div class="col-12">
            <h3>New stuff, work in progress, not safe to use yet</h3>
        </div>
        @if(env('ENABLE_MESSAGING_FEATURE')==1)
            <div class="col-sm-12 col-md-4 mb-3 ">
                <div class="card p-3 h-100">
                    <h5 class="card-title">Email Messaging</h5>
                    <div class="card-body">
                     Mailer for general communication, work in progress.
                        <div class="mt-3">
                            <ul class="list-group">
                                <li class="list-group-item"><a href="{{route('admin_messages')}}">List Messages
                                    ( {{$data['messages_count']}} {{Str::plural('message', $data['messages_count'])}} )</a></li>
                                <li class="list-group-item"><a href="{{route('admin_message_create')}}">Create Message</a></li>
                                <li class="list-group-item"><a href="{{route('admin_email_queue_list')}}">View Mail Queue</a></li>
                                <li class="list-group-item">{{$data['counts']['total_messages']}} Total messages</li>
                                <li class="list-group-item">{{$data['counts']['total_emails_sent']}} Emails sent</li>
                                <li class="list-group-item">{{$data['counts']['not_sent']}}
                                    {{Str::plural('Message', $data['counts']['not_sent'])}} not yet sent</li>
                                <li class="list-group-item">{{$data['counts']['sending']}}
                                    {{Str::plural('Message', $data['counts']['sending'])}} going out now</li>
                                <li class="list-group-item">{{$data['counts']['sent']}} Messages sent</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-sm-12 col-md-4 mb-3 mt-sm-2 mt-md-0 h-100">
            <div class="card p-3">
                <h5 class="card-title">Media insert, work in progress</h5>
                <div class="card-body">
                    <ul class="list-group">
                        <li><a href="{{route('attachments_icons_list')}}">attachments_icons_list</a></li>
                        <li><a href="{{route('ajax_upload')}}">ajax_upload</a></li>
                        <li><a href="{{route('endless')}}">endless</a></li>
                        <li><a href="{{route('endless_data')}}">endless data</a></li>
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
            <div class="col-sm-12 col-md-4 mb-3 ">
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
            <div class="col-sm-12 col-md-4 mb-3 ">
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
            <div class="col-sm-12 col-md-4 mb-3 ">
                <a href="{{ route('developer') }}">
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

