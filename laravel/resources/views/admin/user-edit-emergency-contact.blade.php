@extends('layouts.dashboard',  ['title' => ' <i class="fas fa-first-aid text-danger"></i>     ' . $data["action"]
            . ' Emergency Contact Info for ' . ($data["action"] == "Edit" ? $data['user']->name : '') ])
@section('content')
    @include('admin.admin_partials.admin_tinymce')
    <div class="row">
        <div class="col-12 m-3">
            <p>
            emerg cnotact
            </p>
        </div>
            <div class="col-12 m-3">
                <p>
                <i>
                    <i class="fas fa-asterisk"></i>
                    Please note: the website does not store emergency contact information.
                    This form will email the office contacts to update the info.
                </i>
            </p>
        </div>
    </div>
    <div class="row d-flex justify-content-around pb-2">
        <div class="col-12 col-md-5 mt-md-3">
            <h4>
                <a href="{{route('admin_edit_address', $data['user']->id)}}">
                    <i class="fas fa-address-card text-success"></i>
                    <span class="font-weight-bold">Update address</span>
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
    <form method="post" name="user_emergency" action="{{ url()->current() }}" enctype="multipart/form-data"
          class="needs-validation" novalidate>
        {!! csrf_field() !!}
        <div class="row mt-md-3 pt-2">
            <div class="col-12">

                <div class="input-group mb-3">
                    <div class="col-12 d-block d-md-none font-weight-bold">
                        Emergency Contact Name
                    </div>
                    <div class="input-group-prepend">
                        <span class="input-group-text d-none d-md-block" id="basic-addon1">
                            Emergency Contact Name
                        </span>
                    </div>
                    <input type="text" class="form-control" name="emergency_contact_name"
                           value="{{ old('emergency_contact_name', $emergency_contact_name ?? '') }}" size="40" />
                </div>
                <div class="input-group mb-3">
                    <div class="col-12 d-block d-md-none font-weight-bold">
                        Emergency Contact Phone
                    </div>
                    <div class="input-group-prepend">
                        <span class="input-group-text d-none d-md-block" id="basic-addon1">
                            Emergency Contact Phone
                        </span>
                    </div>
                    <input type="tel" class="form-control" name="emergency_contact_phone"
                           value="{{ old('emergency_contact_phone', $emergency_contact_phone ?? '') }}"
                           maxlength="20"
                           size="40" />
                </div>
                <div class="input-group mb-3">
                    <div class="col-12 d-block d-md-none font-weight-bold">
                        Emergency Contact Relationship
                    </div>
                    <div class="input-group-prepend">
                        <span class="input-group-text d-none d-md-block" id="basic-addon1">
                            Emergency Contact Relationship
                        </span>
                    </div>
                    <input type="text" class="form-control" name="emergency_contact_relationship"
                           value="{{ old('emergency_contact_relationship', $emergency_contact_relationship ?? '') }}"
                           size="40" />
                </div>
                <div class="input-group mt-lg-5 mb-3">
                    <div class="col-12">
                    <h4>
                        Add any additional info about this change.
                    </h4>
                    </div>
                    <textarea name="message" id="message" class="form-control">
                        {{ old('message', $message ?? '') }}
                    </textarea>
                </div>
                <div class="col-12 mt-lg-5">
                    <i class="fas fa-edit fa-2x"></i>
                    <input class="btn btn-primary" type="submit"
                           value="{{ $data['action'] }} Member Emergency Contact Info" />
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
