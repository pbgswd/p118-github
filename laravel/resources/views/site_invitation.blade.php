@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.8);">
        <div class="col-12 p-2">
            <h1>Welcome</h1>
            <h2>{{$data['invitation']->name}}</h2>
            <h4>
               Add your password. Once you do that you may log in to the site.
            </h4>
            <h5>
                Your password must be a minimum of 6 characters.
                Do not use an easily guessable password.
            </h5>
        </div>
        <div class="col-12 p-2 pt-2 mt-5 pt-lg-3 mb-3">
        <form method="post" name="user" action="{{ url()->current() }}" enctype="multipart/form-data"
              class="needs-validation" novalidate>
            {!! csrf_field() !!}

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Password</span>
                    </div>
                    <input type="password" class="form-control" name="password"
                           value="{{ old('password', $password ?? '')}}" size="80" required/>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Repeat Password</span>
                    </div>
                    <input type="password" class="form-control" name="password_confirmation"
                           value="{{ old('password_confirmation', $password_confirmation ?? '')}}" size="80" required/>
                </div>

            <div class="d-flex justify-content-center mt-2">
                <input class="btn btn-primary" type="submit" value="{{ $data['action'] }}" />
            </div>
        </form>
    </div>
    </div>
</div>
<div class="row mt-5"></div>
@endsection
