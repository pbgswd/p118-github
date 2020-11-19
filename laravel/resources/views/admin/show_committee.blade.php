@extends('layouts.dashboard', ['title' => ' <i class="fas fa-users"></i> View Committee \'' .
    $data['committee']->name .'\''])
@section('content')
    <div class="container">
        <h5>
            <a href="{{ route('committees_list') }}" title="return to list of committees">
                <i class="far fa-arrow-alt-circle-left"></i>
                List of Committees
            </a>
        </h5>
        <div class="row">
            <div class="col-lg-10">
               <h4>{{$data['committee']->name}}</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-10">
                {!! $data['committee']->description !!}
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-lg-2">
                <i class="far fa-envelope"></i> &nbsp;
                <a href="mailto:{{$data['committee']->email }}">
                    {{$data['committee']->email}}
                </a>
            </div>
             <div class="col-lg-2">
                 Created by:
                 <i class="far fa-user"></i>
                 <a href="{{route('user_edit', $data['committee']->creator->id)}}">
                     {{$data['committee']->creator->name }}
                 </a>
            </div>
        </div>
        <div class="row mt-lg-5">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-6 col-sm-3 align-middle">
                        <h4>Access Level</h4>
                    </div>
                    <div class="col-6 col-sm-3">
                       Visible by: {{ $data['committee']->access_level }}
                    </div>
                    <div class="col-6 col-sm-3"></div>
                    <div class="col-6 col-sm-3"></div>
                    <!-- Force next columns to break to new line -->
                    <div class="w-100"></div>
                    <div class="col-6 col-sm-3">
                        <h4>Sort Order</h4>
                    </div>
                    <div class="col-6 col-sm-3">
                      {{ $data['committee']->sort_order }}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="col-lg-6">
                    <h4>
                        Status
                        <i class="fas fa-toggle-on"></i>
                    </h4>
                </div>
                <div class="col-sm">
                    @if($data['committee']->in_menu == 1)
                        In Menu
                    @else
                        Not seen in menu
                    @endif
                </div>
                <div class="col-sm">
                    @if($data['committee']->allow_comments == 1)
                        &nbsp;
                    @else
                        &nbsp;
                    @endif
                </div>
                <div class="col-sm">
                    @if($data['committee']->live == 1)
                        This committee is live
                    @else
                        Not enabled live.
                    @endif
                </div>
            </div>
            <div class="col-sm">
                <h4>
                    <a href="{{ route('committee', $data['committee']->slug) }}"
                       title="View {{$data['committee']->name }} on {{env('APP_NAME')}}" target="_blank">
                        <i class="fas fa-external-link-alt"></i>
                        View {{$data['committee']->name }} on website.
                    </a>
                </h4>
                @can('edit articles')
                <h4>
                    <a href="{{ route('committee_edit', $data['committee']->slug) }}" title="Edit {{ $data['committee']->name }}">
                        <i class="fas fa-edit"></i>
                        Edit {{ $data['committee']->name }}
                    </a>
                </h4>
                @endcan
            </div>
        </div>
        <hr />
        <div class="row mt-2">
            <div class="col-md">
                <h4>
                    <i class="fas fa-users"></i>
                    {{$data['committee']->active_committee_members->count()}} active
                    {{Str::plural('member', $data['committee']->active_committee_members->count())}}
                    in {{$data['committee']->name}}
                </h4>
                @can('edit articles')
                <h4>
                    <a href="{{route('admin-list-committee-members', $data['committee']->slug)}}">
                        <i class="fas fa-users"></i>
                        List, Add, Edit Committee Members & Roles
                    </a>
                </h4>
                @endcan
            </div>
                <div class="col-md">
                </div>
            <div class="col-md">
                <h4>Committee Membership Roles</h4>
                @foreach ($data['committee']['executives'] as $exec)
                    <p>  {{$exec->pivot->role}}:
                        <a href="{{route('user_edit', $exec->id)}}">
                            {{$exec->name}}
                        </a>
                    </p>
                @endforeach
            </div>
        </div>
        @can('edit articles')
            <div class="row mt-lg-5 mb-lg-5">
                <h5>
                    <a href="{{route('committee_posts_list', $data['committee']->slug)}}">
                        <i class="far fa-folder-open"></i>
                        {{$data['committee']['post_count']}}
                        {{Str::plural('post', $data['committee']['post_count'])}}
                        in {{ $data['committee']->name }}
                    </a> |
                    <a href="{{route('admin_committee_post', $data['committee']->slug)}}">
                        Add New Post
                    </a>
                </h5>
            </div>
        @endcan
    </div>
@endsection
