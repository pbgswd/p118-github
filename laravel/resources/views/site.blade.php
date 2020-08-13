@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container">
        <div class="row">
            <div class="col-3 border border-dark rounded-lg">
                <h1>{{config('app.name')}}</h1>
            </div>
            <div class="col-2">
                
            </div>
            <div class="col-6 border border-dark rounded-lg">
                Hi {{Auth::user()->name}} <br />

                <a href="{{route('member', Auth::user()->id)}}" title="My Profile">
                    <i class="fas fa-user"></i> My profile
                </a>

            </div>
        </div>
        @include('content_feature')
    </div>
@endsection
