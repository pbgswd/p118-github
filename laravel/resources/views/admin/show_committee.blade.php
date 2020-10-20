<?php
$committee = $data['committee'];
?>
@extends('layouts.dashboard', ['title' => ' <i class="fas fa-users"></i> View Committee \'' . $committee->name .'\''])
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
           <h4>{{$committee->name}}</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-10">
            {!! $committee->description !!}
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-lg-2">
            <i class="far fa-envelope"></i> &nbsp;
            <a href="mailto:{{$committee->email }}">{{$committee->email }}</a>
        </div>
         <div class="col-lg-2"> Created by:
             <i class="far fa-user"></i>
             <a href="{{route('user_edit', $committee->creator->id)}}">{{$committee->creator->name }}</a>
        </div>
    </div>
    <div class="row" style="margin-top:30px;"> &nbsp;</div>
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-6 col-sm-3 align-middle"><h4>Access Level</h4></div>
                <div class="col-6 col-sm-3">
                   Visible by: {{ $committee->access_level }}
                </div>
                <div class="col-6 col-sm-3"></div>
                <div class="col-6 col-sm-3"></div>
                <!-- Force next columns to break to new line -->
                <div class="w-100"></div>
                <div class="col-12">&nbsp;</div>
                <div class="col-6 col-sm-3"><h4>Sort Order</h4></div>
                <div class="col-6 col-sm-3">
                  {{ $committee->sort_order }}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-lg-6"><h4>Status <i class="fas fa-toggle-on"></i></h4></div>
            <div class="col-sm">
                @if($committee->in_menu == 1)
                    In Menu
                @else
                    Not seen in menu
                @endif
            </div>
            <div class="col-sm">
                @if($committee->allow_comments == 1)
                    &nbsp;
                @else
                    &nbsp;
                @endif
            </div>
            <div class="col-sm">
                @if($committee->live == 1)
                    This committee is live
                @else
                    Not enabled live.
                @endif
            </div>
        </div>
        <div class="col-sm">
            <h4>
                <a href="{{ route('committee', $committee->slug) }}"
                   title="View {{$committee->name }} on {{env('APP_NAME')}}" target="_blank">
                    <i class="fas fa-external-link-alt"></i>
                    View {{$committee->name }} on {{env('APP_NAME')}}.
                </a>
            </h4>
            <br />
            <h4>
                <a href="{{ route('committee_edit', $committee->slug) }}" title="Edit {{ $committee->name }}">
                <i class="fas fa-edit"></i> Edit {{ $committee->name }}
                </a>
            </h4>
        </div>
    </div>
    <hr />
    <div class="row" style="margin-top:2em;">
        <div class="col-md">
            <h4><i class="fas fa-users"></i>
                {{$committee['member_count']}} members in {{ $committee->name }}
            </h4>
            <h4>
                <a href="{{route('admin-list-committee-members', $committee->slug)}}">
                    <i class="fas fa-users"></i>
                    List, Add, Edit Committee Members
                </a>
            </h4>
        </div>
        @hasanyrole('super-admin|admin')
            <div class="col-md">
            </div>
        @endhasanyrole
        <div class="col-md">
            <h4>Committee Membership Roles</h4>
            @foreach ($committee['executives'] as $exec)
            <p>  {{$exec->pivot->role}}: <a href="{{route('user_edit', $exec->id)}}">{{$exec->name}}</a> </p>
            @endforeach
        </div>
    </div>
        <div class="row mt-lg-5 mb-lg-5">
            <h5>
                <a href="{{route('committee_posts_list', $committee->slug)}}">
                <i class="far fa-folder-open"></i> {{$committee['post_count']}}
                    posts in {{ $committee->name }} </a> |
                <a href="{{route('admin_committee_post', $committee->slug)}}">Add New Post</a>
            </h5>
        </div>
</div>
@endsection
