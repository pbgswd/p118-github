<?php
$user = $data['user'];
?>
@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.6); padding:1em;">

        <a href="{{ route('hello') }}">Home/</a>
        <a href="{{route('members')}}">members/</a> {{$user->name}}

        <div class="col-12">
            <h1 class="display-3">{{$user->name}}</h1>
        </div>
        <div class="col-12">
                <h2>{!! $user->description !!}</h2>
        </div>
        <div class="col-12">
            @if( $user->image )
                <div class="col-md-6">
                    <div class="col">
                        <img src="{{ asset('storage/'.$user->image) }}" />
                    </div>
                </div>
            @endif
            {!! $user->description !!}
        </div>
  </div>
<div class="row" style="margin-top:6em;"></div>
@endsection
