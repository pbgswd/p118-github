<?php
$organization = $data['organization'];

?>
@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.6); padding:1em;">

        <a href="{{ route('hello') }}">Home /</a>
        <a href="{{route('organizations')}}">organizations /</a> {{$organization->name}}

        <div class="col-12">
            <h1 class="display-3">{{$organization->name}}</h1>
        </div>
        <div class="col-12">
            <p><i class="fas fa-external-link-alt"></i> <a href="{{$organization->url}}" title="{{$organization->name}}" target="_blank">{{$organization->url}}</a></p>
        </div>
        <div class="col-12">
            {!! $organization->description !!}
        </div>
    </div>
</div>
<div class="row mt-lg-5"></div>
@endsection
