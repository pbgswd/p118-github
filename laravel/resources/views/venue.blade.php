<?php
$venue = $data['venue'];
//dd($venue);
?>
@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.6); padding:1em;">

        <a href="{{ route('hello') }}">Home /</a>
        <a href="{{route('venues')}}">venues /</a> {{$venue->name}}

        <div class="col-12">
            <h1 class="display-3">{{$venue->name}}</h1>
        </div>
        <div class="col-12">
            <p><i class="fas fa-external-link-alt"></i> <a href="{{$venue->url}}" title="{{$venue->name}}" target="_blank">{{$venue->url}}</a></p>
        </div>
        <div class="col-12">
            {!! $venue->description !!}
        </div>
    </div>
</div>
<div class="row" style="margin-top:6em;"></div>
@endsection
