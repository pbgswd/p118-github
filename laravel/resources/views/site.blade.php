@extends('layouts.jumbo')
@section('content')
    <div class="container">
        @if(null === $data['user']->user_info)
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-primary" role="alert">
                        Please review your personal information and visibility settings in your
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
