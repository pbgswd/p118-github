<?php
$c = $data['committee'];
?>
@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.6); padding:1em;">
        <a href="{{ route('hello') }}">Home/</a>
        <a href="{{route('committees')}}">Committees/</a> {{$c->name}}
        <div class="col-12">
            <h1 class="display-3">{{$c->name}}</h1>
        </div>
        <div class="col-12">
                <h2>{!! $c->description !!}</h2>
        </div>
        <div class="col-12">
            <h4>Created by <a title="{{ $c->creator->name }}" href="{{ route('member', $c->creator->id) }}">{{$c->creator->name }}</a></h4>
            <div class="row">leader, secretary, members count</div>
            <div class="row">join / leave</div>
            <div class="row">subscribe</div>
            <div class="row">contact</div>
            <div class="row">posts</div>
        </div>
    </div>
</div>
@endsection
