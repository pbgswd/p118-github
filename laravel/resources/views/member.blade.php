<?php
$user = $data['user'];

//dd($data['user_phone']->phone_number);
?>
@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.6); padding:1em;">

        <a href="{{ route('hello') }}">Home/</a>
        <a href="{{route('members')}}">members/</a> {{$user->name}}

        <div class="row">
            @if( $user->user_info->image )
                <div class="col-1">
                    <img src="{{ asset('users/'.$user->user_info->image) }}" />
                </div>
            @endif
            <div class="col-6">
                <h1 class="display-3">{{$user->name}}</h1>
            </div>
        </div>
        <div class="col-12">
            @if ($data['user_info']->share_email == 1)
                <h3><i class="fas fa-envelope"></i> <a href="mailto:{{$user->email}}">{{$user->email}}</a></h3>
            @endif
            @if ($data['user_info']->share_phone == 1)
                <h3> <i class="fas fa-phone-square"></i> <a href="tel:{{$data['user_phone']->phone_number}}">{{$data['user_phone']->phone_number}}</a></h3>
            @endif
            <p>{!! $user->user_info->about !!}</p>
        </div>
  </div>
<div class="row" style="margin-top:6em;"></div>
@endsection
