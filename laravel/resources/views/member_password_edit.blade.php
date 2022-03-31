@extends('layouts.jumbo')
@section('content')
<div class="container border border-dark rounded-lg pt-5 pt-5 mb-3" style="background: rgba(220,220,220,0.8);">
    <div class="row mt-5 mb-3 p-2">
        <h3>
            <a href="{{route('members')}}">
                <i class="far fa-arrow-alt-circle-left"></i>
                Members /
            </a>
            <a href="{{route('member', $data['user']->id)}}">
                {{$data['user']->name}}
            </a>
        </h3>
    </div>
       <div class="row d-flex justify-content-around pb-4 text-center">
        <div class="col-12 col-md-4 mt-md-3">
            <h4>
                <a href="{{route('member_address_edit', $data['user']->id)}}">
                    <i class="fas fa-address-card text-success"></i>
                    <span class="font-weight-bold">Update address</span>
                </a>
            </h4>
        </div>
           <div class="col-12 col-md-4 mt-md-3 text-center">
               <h4>
                   <a href="{{route('member_edit', $data['user']->id)}}">
                       <i class="fas fa-first-aid text-danger"></i>
                       <span class="font-weight-bold">
                        Update Emergency Contact
                    </span>
                   </a>
               </h4>
           </div>
        <div class="col-12 col-md-4 mt-md-3 text-center">
            <h4>
                <a href="{{route('member_edit', $data['user']->id)}}">
                    <i class="fas fa-user"></i>
                    <span class="font-weight-bold">
                        Update profile
                    </span>
                </a>
            </h4>
        </div>
    </div>
    <form method="post" name="password_edit" action="{{ url()->current() }}" enctype="multipart/form-data"
          class="needs-validation" novalidate>
        @csrf
        <div class="row mt-md-5 pt-2">
            <div class="col-12 mb-3">
                <h3 class="">
                    <i class="fas fa-unlock-alt"></i>
                    Update Your Password
                </h3>
                <h5>
                    Your password must be a minimum of 6 characters.
                    Do not use an easily guessable password.
                </h5>
            </div>

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

            <div class="col-12 mt-2 mb-2">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-primary" type="submit"
                   value="{{ $data['action'] }} My Password" />
            </div>
        </div>
    </form>
</div>
@endsection
