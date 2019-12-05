<?php
$committee = $data['committee'];
?>
@extends('layouts.dashboard', ['title' => ' <i class="fas fa-users"></i> View Committee \'' . $committee->name .'\''])
@section('content')
<div class="container">
    <h3><a href="{{ route('committees_list') }}" title="return to list of committees"> <i class="far fa-arrow-alt-circle-left"></i> List of committees</a></h3>
        <div class="row" style="margin-top:30px;"> &nbsp;</div>
        <div class="row">
            <div class="col-lg-2"><h4>Name</h4></div>
            <div class="col-lg-10">
               <h4>{{$committee->name }}</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2">
                <h4>Description</h4>
            </div>
            <div class="col-lg-10">
                {!! $committee->description !!}
            </div>
        </div>

    <div class="row">
        <div class="col-lg-2"><h4>Email</h4></div>
        <div class="col-lg-10">
            <h4><a href="mailto:{{$committee->email }}">{{$committee->email }}</a></h4>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2"><h4>Created By</h4></div>
        <div class="col-lg-10">
            <h4>{{$committee->creator->name }}</h4>
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
                        Comments allowed
                    @else
                        Comments not allowed
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
                    <a href="{{ route('committee', $committee->slug) }}" title="View {{$committee->name }} on {{env('APP_NAME')}}" target="_blank">
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
    <div class="row" style="margin-top:2em;">
        <div class="col-md">
            <h4><i class="fas fa-users"></i> Committee Membership in {{ $committee->name }} </h4>
            <h4>
                <a href="{{route('list-bulk-add', $committee->slug)}}">Bulk add committee members</a>
            </h4>
        </div>
        @hasanyrole('super-admin|admin')
            <div class="col-md">
                (if admin)
                <form name="list-bulk-add" method="POST" action="{{route('list-bulk-add', $committee->id)}}">
                    {!! csrf_field() !!}
                    <i class="fas fa-users fa-2x"></i>
                    <input type="hidden" name="id" value="{{ $committee->id }}">
                    <input class="btn btn-outline-secondary" type="submit" value="Bulk add members">
                </form>
            </div>
        @endhasanyrole
        <div class="col-md">
            <h4>Committee Membership Levels</h4>
            <p>
                @foreach ($committee->committee_levels['committee_level'] as  $cl)
                    {{$cl}} <br />
                @endforeach
            </p>
        </div>
    </div>
        <div class="row" style="margin-top:100px;">
            <h5>
                <a href="{{route('committee_posts_list', $committee->slug)}}">
                <i class="far fa-folder-open"></i>
                    posts in {{ $committee->name }} </a> |
                <a href="{{route('committee_post', $committee->slug)}}">Add New Post</a>
            </h5></div>
    <br />
    <div class="row" style="margin-bottom:5em;"></div>
</div>
@endsection
