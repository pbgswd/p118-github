<?php
$c = $data['committee'];
?>
@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.6); padding:1em;">
        <div class="row">
            <a href="{{ route('hello') }}">Home/</a>
            <a href="{{route('committees')}}">Committees/</a> {{$c->name}}
        </div>
        <div class="row">
            <div class="col-md-6">
                <h1 class="display-3">{{$c->name}}</h1>
            </div>
            <div class="col-md-6">
                @if($data['isMember'] !=1)
                    <form method="post" name="committee-join" action="{{ url()->current() }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                        {!! csrf_field() !!}
                        <input type="hidden" name="committee[slug]" value="{{$data['committee']->slug}}" />
                        <div class="col">
                            <input class="btn btn-success" type="submit" value="Join {{$c->name}} Committee">
                        </div>
                    </form>
                @else
                <form>
                    {!! csrf_field() !!}
                    <input type="hidden" name="committee[slug]" value="{{$data['committee']->slug}}" />
                    <button type="button" type="submit" class="btn btn-outline-dark">Leave {{$c->name}}</button>
                </form>

                @endif
            </div>
        </div>

        <div class="col-12">
                <h2>{!! $c->description !!}</h2>
        </div>
        <div class="col-12">
            <h4>Created by <a title="{{ $c->creator->name }}" href="{{ route('member', $c->creator->id) }}">{{$c->creator->name }}</a></h4>
            <div class="row">
                <div class="col-6">
                        leader, secretary
                </div>
                <div class="col-6">
                    <h4>{{count($c->committee_members)}} Members. <a href="{{route('committee_list_members', $data['committee']->slug)}}">View full list of Members</a></h4>
                </div>

            </div>
            <div class="row">

            </div>
            <div class="row">subscribe</div>
            <div class="row">
                <div class="col-12">
                    <i class="far fa-envelope"></i> <a href="mailto:{{$data['committee']->email}}?subject={{$data['committee']->name}} committee">{{$data['committee']->email}}</a>
                </div>
            </div>
            <div class="row">posts</div>
        </div>
    </div>
</div>
@endsection
