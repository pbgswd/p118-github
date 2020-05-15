<?php

$user = $data['user'];

?>

@extends('layouts.jumbo')

@section('content')
    <div class="jumbotron mb-lg-5">
        <div class="container border border-dark rounded-lg p-2" style="background: rgba(220,220,220,0.8);">
            <h1>
                <a href="{{route('members')}}">
                    <i class="far fa-arrow-alt-circle-left"></i> Members /
                </a>
                {{$user->name}}
            </h1>
            <div class="row">
                @if ( ($user->user_info->image ?? '') && $user->user_info->show_picture == 1 )
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
                @if (($user->user_info->share_email ?? '' ) == 1)
                    <h3><i class="fas fa-envelope"></i> <a href="mailto:{{$user->email}}">{{$user->email}}</a></h3>
                @endif
                @if (($user->user_info->share_phone  ?? '' )  == 1)
                    <h3><i class="fas fa-phone-square"></i> <a href="tel:{{$user->phone_number->phone_number}}">{{$user->phone_number->phone_number}}</a></h3>
                @endif
                <p>{!! $user->user_info->about  ?? '' !!}</p>
            </div>
            <div class="row">
                <div class="col-6 border border-dark rounded-lg mt-3">
                    @foreach($user->executives as $exec)
                            Executive Title: {{$exec->title}} <br />
                            From: {{$exec->start_date}} <br />
                            Until: {{$exec->end_date}} <br />
                        Email: {{$exec->email}} <br />

                            {!! $exec->current ? "<i class='fas fa-check'></i>" : "<i class='far fa-times-circle'></i>" !!}
                    @endforeach
                </div>

                @if(count($user->committee_memberships) > 0)
                    <div class="col-6">
                        <h3>Membership in committees</h3>
                        @foreach($user->committee_memberships as $m)
                            @if($m->pivot->role != 'Past-Member')
                                <div class="col-12 border border-dark rounded-lg m-1 mt-3 mr-3">
                                    <h3>
                                        <a href="{{ route('committee', $m->slug) }}" title="{{$m->name}}">{{$m->name}}</a>
                                    </h3>
                                    <h6>
                                        {{$m->pivot->role}}
                                    </h6>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
