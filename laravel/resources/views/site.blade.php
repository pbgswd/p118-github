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
                <h2>
                  Hi {{Auth::user()->name}}
                </h2>
                <h3>
                    <a href="{{route('member', Auth::user()->id)}}" title="My Profile">
                        <i class="fas fa-user"></i> My profile
                    </a>
                </h3>
            </div>
        </div>
        @include('content_feature')
    </div>
@endsection
