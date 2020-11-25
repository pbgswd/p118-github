@extends('layouts.jumbo')
@section('content')
    <div class="container">
        <div class="row border border-dark rounded-lg p-3">
            <div class="col-4">


                <h2>
                  Hi {{$data['user']->name}}
                </h2>
            </div>
            <div class="col-8">
                @if($data['user']->phone_number === null)
                    <div class="alert alert-primary" role="alert">
                        Please add your phone number to your
                        <span class="font-weight-bolder">
                            <a href="{{route('member', $data['user']->id)}}" title="My Profile">
                                profile.
                            </a>
                        </span>
                    </div>
                @endif
                @if($data['user']->user_info === null)
                        <div class="alert alert-primary" role="alert">
                            Please add your personal information and visibility settings to your
                            <span class="font-weight-bolder">
                                <a href="{{route('member', $data['user']->id)}}" title="My Profile">
                                    profile.
                                </a>
                            </span>
                        </div>
                @endif
                @if($data['user']->address === null)
                        <div class="alert alert-primary" role="alert">
                            Please add your address to your
                            <span class="font-weight-bolder">
                                <a href="{{route('member', $data['user']->id)}}" title="My Profile">
                                    profile.
                                </a>
                            </span>
                        </div>
                    @endif


        </div>
        @include('content_feature')
    </div>
@endsection
