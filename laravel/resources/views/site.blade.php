@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h1 class="display-3">{{config('app.name')}}</h1>
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        You are redirected to this page when you are logged in.
                    </div>
                </div>
                @include('content_feature')
            </div>
        </div>
    </div>
</div>
@endsection
