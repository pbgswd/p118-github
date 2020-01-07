@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container">
        <h1 class="display-3">{{config('app.name')}}</h1>

        <div class="row">

        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

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
