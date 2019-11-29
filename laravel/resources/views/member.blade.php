<?php
$user = $data['user'];
?>
@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.6); padding:1em;">
        <a href="{{ route('hello') }}">Home/</a>
        <a href="{{route('members')}}">members/</a> {{$user->name}}
        <div class="row">
            @if( $user->user_info->image && $user->user_info->show_picture == 1 )
                <div class="col-1">
                    <img src="{{ asset('users/' . $user->user_info->image) }}" />
                </div>
            @endif
            <div class="col-9">
                <h1 class="display-3">{{$user->name}}</h1>
            </div>
        </div>
        <div class="col-12">
            @if ($user->user_info->share_email == 1)
                <h3><i class="fas fa-envelope"></i> <a href="mailto:{{$user->email}}">{{$user->email}}</a></h3>
            @endif
            @if ($user->user_info->share_phone == 1)
                <h3> <i class="fas fa-phone-square"></i> <a href="tel:{{$user->phone_number->phone_number}}">{{$user->phone_number->phone_number}}</a></h3>
            @endif
            <p>{!! $user->user_info->about !!}</p>
        </div>
        @if ( Auth::user()->id == $user->id)
            <div class="col-12" style="margin-top: 4em;">
                <a href="{{route('member_edit', Auth::user()->id )}}" title="Edit my profile"><button type="button" class="btn btn-primary">Edit My Profile</button></a>
            </div>
        @endif
        <div class="col-12">
        <h3>Membership in committees</h3>
        </div>


  </div>
<div class="row" style="margin-top:6em;"></div>
@endsection
