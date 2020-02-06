<?php
$user = $data['user'];
?>
@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg p-2" style="background: rgba(220,220,220,0.6);">
        <h1><a href="{{route('members')}}">
                <i class="far fa-arrow-alt-circle-left"></i> members /</a>
            {{$user->name}}
        </h1>
        <div class="row">
            @if( $user->user_info->image && $user->user_info->show_picture == 1 )
                <div class="col-1">
                    <img src="{{ asset('storage/users/' . $user->user_info->image) }}" />
                </div>
            @endif
            <div class="col-3">
                @if ( Auth::user()->id == $user->id)
                    <div class="col-12" style="margin-top: 4em;">
                        <a href="{{route('member_edit', Auth::user()->id )}}" title="Edit my profile"><button type="button" class="btn btn-primary">Edit My Profile</button></a>
                    </div>
                @endif
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
        @if(count($user->committee_membership) > 0)
            <div class="col-12">
                <h3>Membership in committees</h3>
                @foreach($user->committee_membership as $m)
                    <div class="col-3 border border-dark rounded-lg mt-3 mr-3" style="margin: 1em;">
                        <h3>
                            <a href="{{ route('committee', $m->slug) }}" title="{{$m->name}}">{{$m->name}}</a>
                        </h3>
                    </div>
                @endforeach
            </div>
        @endif
  </div>
<div class="row" style="margin-top:6em;"></div>
@endsection
