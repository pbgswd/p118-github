@extends('layouts.dashboard',  ['title' => ' <i class="fas fa-address-card text-success"></i> ' . $data["action"]
            . ' Address for ' . ($data["action"] == "Edit" ? $data['user']->name : '') ])
@section('content')
    @include('admin.admin_partials.admin_tinymce')
    <div class="row">
        <h3>
            <a href="{{route('users_list')}}">
                <i class="far fa-arrow-alt-circle-left"></i>
                Members /
            </a>
            <a href="{{route('user_edit', $data['user']->id)}}">
                {{$data['user']->name}}
            </a>
        </h3>
    </div>

    <div class="row pb-2">
        <div class="col-12 m-3">
            <p>
                <i>Please note: the website does not store address information
                    for matters of efficiency sake.
                    This form will email the office contacts to update the address.
                </i>
            </p>
        </div>
    </div>
    <div class="row d-flex justify-content-around">
        <div class="col-12 col-md-5 mt-md-3">
            <h4>
                <a href="{{route('admin_edit_emergency_contact', $data['user']->id)}}">
                    <i class="fas fa-first-aid text-danger"></i>
                    <span class="font-weight-bold">
                        Update emergency contact
                    </span>
                </a>
            </h4>
        </div>
        <div class="col-12 col-md-5 mt-md-3">
            <h4>
                <a href="{{route('user_edit', $data['user']->id)}}">
                    <i class="fas fa-user"></i>
                    <span class="font-weight-bold">
                        Update profile
                    </span>
                </a>
            </h4>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-12">
            <form method="post" name="user_address" action="{{ url()->current() }}" enctype="multipart/form-data"
                  class="needs-validation" novalidate>
                {!! csrf_field() !!}
                <div class="col-lg-12">
                    <h3>
                        <i class="fas fa-address-card text-success"></i>
                        Update Member Address With The Office
                    </h3>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Apt #</span>
                    </div>
                    <input type="text" class="form-control" name="unit"
                           value="{{ old('unit', $unit ?? '') }}" size="40" />
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Street</span>
                    </div>
                    <input type="text" class="form-control" name="street"
                           value="{{ old('street', $street ?? '') }}" size="40" required/>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">City</span>
                    </div>
                    <input type="text" class="form-control" name="city"
                           value="{{ old('city', $city ?? '') }}" size="40" required/>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">Province</span>
                    </div>
                    {{ select_options($data['provinces'], old('province', $province ?? ''),
                        ['name' => 'province', 'class' => 'form-control', 'placeholder' => 'Province']) }}
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Postal Code</span>
                    </div>
                    <input
                        type="text"
                        class="form-control"
                        style="text-transform:uppercase"
                        name="postal_code"
                        value="{{ old('postal_code',
                        strtoupper($postal_code ?? '')) }}"
                        size="40" required/>
                </div>
                <div class="col-12 mt-4 mb-3">
                    <h4>
                        Add any additional info for the office about this change.
                    </h4>
                </div>
                    <div class="input-group mt-3 mb-3">
                    <textarea name="message" id="message" class="form-control">
                        {{ old('message', $message ?? '') }}
                    </textarea>
                </div>
                <div class="col-12 mt-lg-5">
                    <i class="fas fa-edit fa-2x"></i>
                    <input class="btn btn-primary" type="submit" value="{{ $data['action'] }} Member Address" />
                </div>
            </form>
        </div>
    </div>
@endsection
