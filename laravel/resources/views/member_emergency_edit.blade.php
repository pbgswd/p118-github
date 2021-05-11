@extends('layouts.jumbo')
@section('content')
<div class="container border border-dark rounded-lg p-4 mb-3" style="background: rgba(220,220,220,0.8);">
    <div class="row">
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
       <div class="row d-flex justify-content-around pb-2 text-center">
        <div class="col-12 col-md-4 mt-md-3">
            <h4>
                <a href="{{route('member_address_edit', $data['user']->id)}}">
                    <i class="fas fa-address-card text-success"></i>
                    <span class="font-weight-bold">Update address</span>
                </a>
            </h4>
        </div>
           <div class="col-12 col-md-4 mt-md-3 mx-auto">
               <h4>
                   <a href="{{route('member_password_edit', $data['user']->id)}}">
                       <i class="fas fa-unlock-alt"></i>
                       <span class="font-weight-bold">
                            Update Password
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
    <form method="post" name="user_emergency" action="{{ url()->current() }}" enctype="multipart/form-data"
          class="needs-validation" novalidate>
        {!! csrf_field() !!}
        <div class="row mt-md-3 pt-2">
                <div class="col-12 mb-3">
                    <h3 class="">
                        <i class="fas fa-first-aid text-danger"></i>
                        Update Your Emergency Contact Information
                    </h3>
                </div>
            <div class="col-12 mb-3">
                <h3>
                    <i class="fas fa-exclamation-triangle text-secondary"></i>
                    The office has your current information. Please use this form
                    <span class="font-weight-bolder">only when there is a change.</span>
                </h3>
            </div>
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
                <div class="input-group mt-3 mb-3">
                    <h4>
                        Add any additional info for the office about this change.
                    </h4>
                    <textarea name="message" id="message" class="form-control">
                        {{ old('message', $message ?? '') }}
                    </textarea>
                </div>
                <div class="row">
                    <div class="col-12">
                        <p>
                            <i>
                                <i class="fas fa-asterisk"></i>
                                Please note: the website does not store your emergency contact information.
                                This form will email the office contacts to update your info.
                            </i>
                        </p>
                    </div>
                </div>
                <div class="col-12 mt-2">
                    <i class="fas fa-edit fa-2x"></i>
                    <input class="btn btn-primary" type="submit"
                       value="{{ $data['action'] }} My Emergency Contact Info" />
                </div>

        </div>
    </form>
</div>
@endsection
