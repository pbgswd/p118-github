<?php
$user = $data['invitation'];
?>
@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg p-5" style="background: rgba(220,220,220,0.6);">
        <h1>Hi {{$user->name}}</h1>
        <h3>
               Add your password. Once you do that you may log in to the site.
        </h3>
        <form method="post" name="user" action="{{ url()->current() }}" enctype="multipart/form-data" class="needs-validation" novalidate>
            {!! csrf_field() !!}
            <div class="row border border-primary rounded-lg border-3 p-4 mt-5">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Password</span>
                    </div>
                    <input type="password" class="form-control" name="user[new_password]" value="{{ old('user.new_password', $user->new_password ?? '')}}" size="80" required/>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Repeat Password</span>
                    </div>
                    <input type="password" class="form-control" name="user[new_password2]" value="{{ old('user.new_password2', $user->new_password2 ?? '')}}" size="80" required/>
                </div>
            </div>
            <div class="col-12 mt-lg-5">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-primary" type="submit" value="{{ $data['action'] }}" />
            </div>
        </form>
    </div>
</div>
<div class="row mt-5"></div>
@endsection
