<?php
$user = $data['user'];
$roles = $data['roles'];
$user_roles = $data['user_roles'];
dd($user_roles);
?>
@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
<div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.6); padding:1em;">
    <a href="{{ route('hello') }}">Home/</a>
    <a href="{{route('members')}}">members/</a>  <a href="{{route('member', Auth::user()->id)}}">{{$user->name}}</a>
    <div class="container">
        <h3>
            <a href="{{ route('users_list') }}"> <i class="far fa-arrow-alt-circle-left"></i> List of members</a>
        </h3>
        <form method="post" name="user" action="{{ url()->current() }}" enctype="multipart/form-data" class="needs-validation" novalidate>
        <input type="hidden" name="user[id]" value="{{ $user['id'] }}">
            {!! csrf_field() !!}
            <div class="row border border-primary rounded-lg border-3" style="margin-top:30px; padding:1em;">
                <div class="col-lg-12">
                    <h3>Primary Contact Information</h3>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-lg-2"><h4>Name</h4></div>
                        <div class="col-lg-10">
                            <input type="text" class="form-control"  placeholder="Name" name="user[name]" value="{{ old('user.name', $user->name)}}" size="80" required/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-lg-2"><h4>Email</h4></div>
                        <div class="col-lg-10">
                            <input type="text" class="form-control"  placeholder="Email" name="user[email]" value="{{ old('user.email', $user->email)}}" size="80" required/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-lg-2"><h4>Phone</h4></div>
                        <div class="col-lg-10">
                            <input type="text" class="form-control"  placeholder="Phone" name="user_phone[phone_number]" value="{{ old('user_phone.phone_number', $user->phone_number->phone_number) }}" size="80" required />
                        </div>
                    </div>
                </div>
            </div>
            <div class="border border-primary rounded-lg border-3" style="margin-top:1em; padding:1.5em;">
                <div class="row" style="margin-bottom: 1em;">
                    <div class="col-12">
                        <h4>Member Info and Preferences</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <label>
                            <input name="user_info[show_profile]" type="hidden" value="0" />
                            <input name="user_info[show_profile]" type="checkbox" value="1" {{ checked(old('user_info.show_profile', $user->user_info->show_profile)) }} />
                            <h5>Check to share profile with other members.</h5>
                        </label>
                    </div>
                    @if( $user->user_info->image )
                        <div class="col-12">
                            <h4>
                                <i class="far fa-images"></i>
                                Image preview
                            </h4>
                            <h5>Currently: {{ $user->user_info->file_name }}</h5>
                            <img src="{{ asset('users/'. $user->user_info->image) }}" width="150px" />
                            <input type="hidden"  name="user_info[image]" value="{{$user->user_info->image}}" />
                            <label>
                                <input name="user_info[delete_image]" type="checkbox" value="1" /> <h5>Check to delete image</h5>
                            </label>
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
                    <div class="col-12">
                        <label>
                            <input name="user_info[show_picture]" type="hidden" value="0" />
                            <input name="user_info[show_picture]" type="checkbox" value="1" {{ checked(old('user_info.show_picture', $user->user_info->show_picture)) }} />
                            <h5>Check to show picture in your profile.</h5>
                        </label>
                    </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <div class="col-6"><h5>Share email in contact information?</h5></div>
                                <div class="col-2">
                                    <label>
                                        <input name="user_info[share_email]" type="hidden" value="0" />
                                        <input name="user_info[share_email]" type="checkbox" value="1" {{ checked(old('user_info.share_email', $user->user_info->share_email)) }} />
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <div class="col-6"><h5>Share phone in contact information?</h5></div>
                                <div class="col-2">
                                    <label>
                                        <input name="user_info[share_phone]" type="hidden" value="0" />
                                        <input name="user_info[share_phone]" type="checkbox" value="1" {{ checked(old('user_info.share_phone',$user->user_info->share_phone)) }} />
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-10"><h4>About Me</h4></div>
                        <div class="col-lg-10">
                            <textarea name="user_info[about]" id="about" class="form-control"> {{ old('user_info.about', $user->user_info->about) }} </textarea>
                        </div>
                    </div>
                </div>
                <div class="border border-primary rounded-lg border-3" style="margin-top:1em; padding:1em;">
                    <div class="row">
                        <div class="col-6"><h3>Primary Mailing Address</h3></div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                Apt # <input type="text" class="form-control" placeholder="Apt #" name="user_address[unit]" value="{{ old('user_address.unit', $user->address->unit) }}" size="40" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                Street <input type="text" class="form-control" placeholder="Street" name="user_address[street]" value="{{ old('user_address.street', $user->address->street) }}" size="40" required/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                City <input type="text" class="form-control" placeholder="City" name="user_address[city]" value="{{ old('user_address.city', $user->address->city)}}" size="40" required/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                Province {{ select_options($data['provinces'], old('user_address.province', $user->address->province), ['name' => 'user_address[province]', 'class' => 'form-control', 'placeholder' => 'Province']) }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                Postal Code <input type="text" class="form-control"  placeholder="Postal Code" name="user_address[postal_code]" value="{{ old('user_address.postal_code', $user->address->postal_code)}}" size="40" required/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                Country {{ select_options($data['countries'], old('user_address.country', $user->address->country), ['name' => 'user_address[country]', 'class' => 'form-control', 'placeholder' => 'Country']) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row col-12">&nbsp;
                    <span class="border border-primary rounded-lg border-3" style="margin-top:2em; padding:2em;">
                        <h4>User website roles </h4>
                        @foreach ($roles as $role)
                            <div class="col-12">
                                <label>
                                    <input name="user_roles[]" type="checkbox" value="{{$role->name}}" {{ checked(array_key_exists($role->name, $user_roles))  }} >
                                    {{$role->name}}
                                    (
                                     @foreach ($role->permissions as $p)
                                        {{ $p->name }}
                                    @endforeach
                                    )
                                </label>
                            </div>
                        @endforeach
                    </span>
                </div>
            @if(Auth::user()->id == $user->id)
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }} My Profile" />
            @endif
        </form>
    </div>
</div>
<div class="row" style="margin-top:6em;"></div>
@endsection
