@extends('layouts.jumbo')
@section('content')
    <div class="container mt-3">
        <div class="row">
            <div class="col-12 col-md-6">
                <h3>
                    Hi {{$data['user']->name}}
                </h3>
            </div>
            <div class="col-12 col-md-6 text-md-right">
                <h5 class="font-weight-bolder">

                    <a href="{{route('member', $data['user']->id)}}" title="My Profile">
                        <i class="fas fa-user"></i>
                        View your profile.
                    </a>
                </h5>
            </div>
        </div>
        @if(null === $data['user']->user_info)
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-primary" role="alert">
                        Please add your personal information and update the visibility settings to your
                        <span class="font-weight-bolder">
                            <a href="{{route('member', $data['user']->id)}}" title="My Profile">
                                personal profile.
                            </a>
                        </span>
                    </div>
                </div>
            </div>
        @endif
        @include('content_feature')
    </div>
@endsection
