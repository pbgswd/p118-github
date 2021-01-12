<?php
$user = $data['user'];
$roles = $data['roles'];
$user_roles = $data['user_roles'];
?>
@extends('layouts.jumbo')
@section('content')
<div class="container border border-dark rounded-lg p-1" style="background: rgba(220,220,220,0.8);">
    <div class="row">
        <div class="col mt-lg-5">
            <h3>
                <a href="{{route('members')}}">
                    <i class="far fa-arrow-alt-circle-left"></i>
                    Members /
                </a>
                <a href="{{route('member', $user->id)}}">
                    {{$user->name}}
                    @if($user->membership->membership_type != 'Member')
                        ({{$user->membership->membership_type}})
                    @endif
                </a>
            </h3>
        </div>
    </div>

    <div class="row p-4">
        @if( $data['user']->allExecutiveRoles->count() > 0 )
            <div class="col-5 border border-dark rounded-lg mr-1 p-lg-2">
                <h4>
                    Executive {{ Str::plural('Title', $data['user']->allExecutiveRoles->count()) }}
                </h4>
                @foreach($data['user']->allExecutiveRoles as $exec)
                    <h5>{{$exec->title}}
                        {{ \Carbon\Carbon::parse($exec->pivot->end_date)->isPast() ? '':'(Currently)'}}
                        <a href="mailto:{{$exec->email}}" title="Email {{$data['user']->name}} {{$exec->title}}
                            at {{$exec->email}}">
                            <i class="fas fa-envelope"></i>
                        </a> <br />
                        {{\Carbon\Carbon::parse($exec->pivot->start_date)->format('M j Y')}} -
                        {{\Carbon\Carbon::parse($exec->pivot->end_date)->format('M j Y')}}
                    </h5>
                    <br />
                @endforeach
            </div>
            <div class="col-1"></div>
        @endif
        @if($data['user']->committee_memberships->count() > 0)
            <div class="col-5 border border-dark rounded-lg p-lg-2">
                <h4 class="fw-bold">Membership in committees</h4>
                @foreach($data['user']->committee_memberships as $m)
                    @if($m->pivot->role != 'Past-Member')
                        <h5>
                            <a href="{{ route('committee', $m->slug) }}" title="{{$m->name}}">
                                {{$m->name}} -  {{$m->pivot->role}}
                            </a>
                        </h5>
                    @endif
                @endforeach
            </div>
        @endif
    </div>


    <div class="row">
        <div class="col-12">
            <form method="post" name="user" action="{{ url()->current() }}" enctype="multipart/form-data"
              class="needs-validation" novalidate>
                {!! csrf_field() !!}
                <h3 class="p-lg-2 fw-bold">Primary Contact Information</h3>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Name</span>
                    </div>
                    <input type="text" class="form-control"  placeholder="Name" name="user[name]"
                           value="{{ old('user.name', $user->name)}}" size="80" required/>
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Email</span>
                    </div>
                    <input type="text" class="form-control"  placeholder="Email" name="user[email]"
                           value="{{ old('user.email', $user->email ?? '')}}" size="80" required/>
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input name="user_info[share_email]" type="hidden" value="0" />
                            <input name="user_info[share_email]" type="checkbox" value="1"
                                {{ checked(old('user_info.share_email', $user->user_info->share_email ?? '')) }} />
                        </div>
                    </div>
                    <input type="text" class="form-control" aria-label="Text input with checkbox"
                           value="Share email in profile?" size="40" readonly>
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Phone</span>
                    </div>
                    <input type="text" class="form-control"  placeholder="Phone" name="user_phone[phone_number]"
                           value="{{ old('user_phone.phone_number', $user->phone_number->phone_number ?? '') }}" size="80"
                           required />
                </div>

                <div class="input-group mb-lg-4">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input name="user_info[share_phone]" type="hidden" value="0" />
                            <input name="user_info[share_phone]" type="checkbox"
                                   value="1"
                                {{ checked(old('user_info.share_phone', $user->user_info->share_phone ?? '')) }} />
                        </div>
                    </div>
                    <input type="text" class="form-control" aria-label="Text input with checkbox"
                           value="Share phone number in profile?" size="40" readonly>
                </div>

                <div class="m-lg-2">&nbsp;</div>

                <h2 class="mt-lg-5 mb-3 p-lg-2">Update My Mailing Address <br />
                    <a href="{{route('member_address_edit', $user->id)}}">
                        <i class="fas fa-info-circle"></i>
                        Do you need to update your mailing address? Do it here.
                    </a>
                </h2>


                <h2 class="mt-lg-5 p-lg-2 fw-bold">Member Info</h2>
                <div class="input-group mb-6">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input name="user_info[show_profile]" type="hidden" value="0" />
                            <input name="user_info[show_profile]" type="checkbox" value="1"
                                {{ checked(old('user_info.show_profile', $user->user_info->show_profile ?? '')) }} />
                        </div>
                    </div>
                    <input type="text" class="form-control" aria-label="Text input with checkbox"
                           value="Check to share profile with other members." size="40" readonly>
                </div>
                @if( isset($user->user_info->image) )
                    <div class="col-6 mt-2">
                        <h4>
                            <i class="far fa-images"></i>
                            Image preview - Currently: {{ $user->user_info->file_name }}
                        </h4>
                        <img src="{{ asset('storage/users/'. $user->user_info->image) }}" class="m-1"/>
                            <input type="hidden" name="user_info[image]" value="{{$user->user_info->image}}" />
                    </div>
                    <div class="col-6 mt-2">
                        <i class="fas fa-info-circle"></i>
                        Image help: use an image ideally no larger than 150x150px
                    </div>
                    <div class="input-group mb-6">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input name="user_info[delete_image]" type="checkbox" value="1" />
                            </div>
                        </div>
                        <input type="text" class="form-control" aria-label="Text input with checkbox"
                               value="Check to delete image." size="40" readonly>
                    </div>
                @else
                    <div class="form-group">
                        <label for="exampleInputFile">
                            <i class="fas fa-cloud-upload-alt fa-2x"></i>
                                File input
                        </label>
                        <input type="file" id="inputFile" name="image" />
                        <p class="help-block">
                            Upload image for your profile if you wish.
                        </p>
                    </div>
                @endif
                <div class="input-group mb-lg-3 mt-2 pb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input name="user_info[show_picture]" type="hidden" value="0" />
                            <input name="user_info[show_picture]" type="checkbox" value="1"
                                {{ checked(old('user_info.show_picture', $user->user_info->show_picture ?? '')) }} />
                        </div>
                    </div>
                    <input type="text" class="form-control" aria-label="Text input with checkbox"
                           value="Check to show picture in your profile." size="40" readonly>
                </div>

                <h2 class="mt-lg-5 p-lg-2 fw-bold">About Me</h2>
                <div class="input-group mb-3">
                    @if (!optional($user->user_info)->about || empty(optional($user->user_info)->about))
                        <p class="font-italic">
                            Add something here about you such as your experience in
                            stage and theatre, your skills. Do you have a side hustle?
                            Got creative work? Tell us about it! Share your social media
                            links if you like.
                        </p>
                    @endif
                    <textarea name="user_info[about]" id="about" class="form-control">
                        {{ old('user_info.about', $user->user_info->about ?? '') }}
                    </textarea>
                </div>
                <div class="pt-5 pl-2 m-2">
                    <i class="fas fa-edit fa-2x"></i>
                    <input class="btn btn-primary btn-lg" type="submit" value="{{ $data['action'] }} My Profile" />
                </div>
        </form>
    </div>
</div>
@endsection
