<?php
//dd($data);
$c = $data['committee'];
$execs = $data['executives'];
?>
@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg p-4" style="background: rgba(220,220,220,0.6);">
        <div class="row">
            <div class="col-12">
                <h2>
                    <a href="{{route('committees')}}">Committees /</a>&nbsp;{{$c->name}}
                </h2>
            </div>
            <div class="col-12">
                <h2>{!! $c->description !!}</h2>
            </div>
            <div class="col-12 small">
                Created by <a title="{{ $c->creator->name }}" href="{{ route('member', $c->creator->id) }}">{{$c->creator->name }}</a>
            </div>
            <div class="col-12 mb-4">
                <h4>
                    <i class="far fa-newspaper"></i> {{$c->postsCount}} {{Str::plural('Post', $c->postsCount ) }}
                    @if($data['isMember'] == 1)
                        | <i class="far fa-edit"></i><a href="{{route('committee_add_public_post', $c)}}">Add New Post</a>
                    @endif
                </h4>
            </div>
            @foreach($c->posts as $p)
                <div class="col-12 border border-dark rounded-lg m-1">
                    <h3>
                        <a href="{{route('public_committee_post_show', [$c->slug, $p->slug])}}" title="{{$p->title}}">{{$p->title}}</a>
                    </h3>
                    {{$p->updated_at}}
                </div>
            @endforeach
            @if($c->posts->count() > 5)
                <div class="row mt-lg-4">
                    <div class="col-3 text-center">
                        {!! $c->posts->links() !!}
                    </div>
                </div>
            @endif
        </div>
        <div class="row mt-3">
            <div class="col-12 mr-2 pt-lg-2 border border-dark rounded-lg">
                <h5>{{$c->name}} Executive</h5>
                <p>
                    @foreach ($execs as $exec)
                        <i class="fas fa-user-tie"></i> {{$exec->pivot->role}}: <a href="{{route('member', $exec->id)}}">{{$exec->name}}</a> <br />
                    @endforeach
                </p>
                <p>
                    <i class="far fa-envelope"></i>
                    Email:
                    <a href="mailto:{{$data['committee']->email}}?subject={{$data['committee']->name}} committee"> {{$data['committee']->email}}</a>
                </p>
            </div>
            <div class="col-12 p-lg-2 mt-lg-3 border border-dark rounded-lg">
                <h4>
                    <span class="badge badge-primary badge-pill">
                        {{$c->active_committee_members->count()}}
                    </span>
                    {{Str::plural('Member', $c->active_committee_members->count())}}.
                    @if(0 < $c->active_committee_members->count())
                        <a href="{{route('committee_list_members', $data['committee']->slug)}}">View membership</a>
                    @endif
                </h4>
                @if($data['isMember'] != 1)
                    <form method="post" name="committee-join" action="{{ url()->current() }}/join" enctype="multipart/form-data" class="needs-validation" novalidate>
                        {!! csrf_field() !!}
                        <div class="col">
                            <button value="Join" class="btn btn-success" type="submit">Join {{$c->name}}</button>
                        </div>
                    </form>
                @else
                    <h5>You are a member of {{$c->name}}</h5>
                    <form method="post" name="committee-leave" action="{{ url()->current() }}/leave"  enctype="multipart/form-data" class="needs-validation" novalidate>
                        {!! csrf_field() !!}
                        <div class="col">
                            <button value="Leave" class="btn btn-outline-dark" type="submit">Leave {{$c->name}}</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
