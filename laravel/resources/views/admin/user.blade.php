<?php
$user = $data['user'];
$currentUserPermissions = $data['currentUserPermissions'];
$roles = $data['roles'];
$user_roles = $data['user_roles'];
?>
@extends('layouts.dashboard',  ['title' => ' <i class="fas fa-edit"></i> ' . $data["action"] . ' Member ' . ($data["action"] == "Edit" ? $user->name : '') ])
@section('content')

    <script>
        tinymce.init({
            selector: 'textarea#admin_notes, textarea#about',
            height: 200,
            width:800,
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor textcolor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tiny.cloud/css/codepen.min.css'
            ]
        });
    </script>
<div class="container">
    <h3>
        <a href="{{ route('users_list') }}"> <i class="far fa-arrow-alt-circle-left"></i> List of members</a>
    </h3>
    <form method="post" name="user" action="{{ url()->current() }}" enctype="multipart/form-data" class="needs-validation" novalidate>
        {!! csrf_field() !!}
        <div class="row border border-primary rounded-lg border-3" style="margin-top:30px; padding:1em;">
            <div class="col-lg-12">
                <h3>Primary Contact Information</h3>
            </div>
            <div class="col-12 input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">Name</span>
                    <input type="text" class="form-control"  placeholder="Name" name="user[name]" value="{{ old('user.name', $user->name)}}" size="80" required/>
                </div>
            </div>
            <div class="col-12 input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">Email</span>
                <input type="text" class="form-control"  placeholder="Email" name="user[email]" value="{{ old('user.email', $user->email)}}" size="80" required/>
                </div>
            </div>
            <div class="col-12 input-group mb-6">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <input name="user_info[share_email]" type="hidden" value="0" />
                        <input name="user_info[share_email]" type="checkbox" value="1" {{ checked(old('user_info.share_email', $user->user_info->share_email)) }} />
                    </div>
                </div>
                <input type="text" class="form-control" aria-label="Text input with checkbox" value="Share email in profile?" size="40" readonly>
            </div>
            <div class="col-12 input-group mb-3" style="margin-top: 1em;">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">Phone</span>
                   <input type="text" class="form-control"  placeholder="Phone" name="user_phone[phone_number]" value="{{ old('user_phone.phone_number', $user->phone_number->phone_number)}}" size="80" required/>
                </div>
            </div>
            <div class="input-group mb-6 col-12">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <input name="user_info[share_phone]" type="hidden" value="0" />
                        <input name="user_info[share_phone]" type="checkbox" value="1" {{ checked(old('user_info.share_phone', $user->user_info->share_phone)) }} />
                    </div>
                </div>
                <input type="text" class="form-control" aria-label="Text input with checkbox" value="Share phone number in profile?" size="40" readonly>
            </div>
        </div>
        <div class="row border border-primary rounded-lg border-3" style="margin-top:1em; padding:1.5em;">
            <div class="row">
                <div class="col-12">
                    <h4>Member Info</h4>
                </div>
                <div class="input-group mb-6 col-12 border border-primary">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input name="user_info[show_profile]" type="hidden" value="0" />
                            <input name="user_info[show_profile]" type="checkbox" value="1" {{ checked(old('user_info.show_profile', $user->user_info->show_profile)) }} />
                        </div>
                    </div>
                    <input type="text" class="form-control" aria-label="Text input with checkbox" value="Check to share profile with other members." size="40" readonly>
                </div>

            </div>
            <div class="row" style="margin-top: 1em;">
                @if( $user->user_info->image )
                    <div class="col-4" style="margin: 1em;">
                        <h4><i class="far fa-images"></i> Profile Image</h4>
                        <h5>Currently: {{ $user->user_info->file_name }}</h5>
                        <img src="{{ asset('storage/users/'. $user->user_info->image) }}" width="150px" />
                        <input type="hidden"  name="user_info[image]" value="{{$user->user_info->image}}" />
                    </div>

                    <div class="input-group mb-6 col-12">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input name="user_info[show_profile]" type="checkbox" value="1" />
                            </div>
                        </div>
                        <input type="text" class="form-control" aria-label="Text input with checkbox" value="Check to delete image." size="40" readonly>
                    </div>

                    <div class="input-group mb-6 col-12">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input name="user_info[show_picture]" type="hidden" value="0" />
                                <input name="user_info[show_picture]" type="checkbox" value="1" {{ checked(old('user_info.show_picture', $user->user_info->show_picture)) }} />
                            </div>
                        </div>
                        <input type="text" class="form-control" aria-label="Text input with checkbox" value="Check to show picture in your profile." size="40" readonly>
                    </div>
                @else
                    <div class="col-12">
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
                    </div>
                @endif
            </div>

            <div class="row" style="margin-top: 1em;">
                <div class="col-lg-10"><h4>About Me</h4></div>
                <div class="col-lg-10">
                    <textarea name="user_info[about]" id="about" class="form-control"> {{ old('user_info.about', $user->user_info->about) }} </textarea>
                </div>
            </div>
        </div>

        <div class="row border border-primary rounded-lg border-3" style="margin-top:1em; padding:1em;">
            <div class="col-12"><h3>Primary Mailing Address</h3></div>
            <div class="col-12 input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">Apt#</span>
                </div>
                <input type="text" class="form-control" placeholder="Apt #" name="user_address[unit]" value="{{ old('user_address.unit', $user->address->unit) }}" size="60" />
            </div>
            <div class="col-12 input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">Street</span>
                </div>
                <input type="text" class="form-control" placeholder="Street" name="user_address[street]" value="{{ old('user_address.street', $user->address->street) }}" size="60" required/>
            </div>
            <div class="col-12 input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">City</span>
                </div>
                <input type="text" class="form-control" placeholder="City" name="user_address[city]" value="{{ old('user_address.city', $user->address->city)}}" size="40" required/>
            </div>
            <div class="col-12 input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">Province</span>
                </div>
            {{ select_options($data['provinces'], old('user_address.province', $user->address->province), ['name' => 'user_address[province]', 'class' => 'form-control', 'placeholder' => 'Province']) }}
            </div>
            <div class="col-12 input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default"> Postal Code</span>
                </div>
                    <input type="text" class="form-control"  placeholder="Postal Code" name="user_address[postal_code]" value="{{ old('user_address.postal_code', $user->address->postal_code)}}" size="60" required/>
                </div>
            <div class="col-12 input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">Country</span>
                </div>
                 {{ select_options($data['countries'], old('user_address.country', $user->address->country), ['name' => 'user_address[country]', 'class' => 'form-control', 'placeholder' => 'Country']) }}
            </div>
        </div>
        <div class="row">
            <div class="col-12 border border-primary rounded-lg border-3" style="margin-top:2em; padding:2em;">
                <h4>User website roles </h4>
                @foreach ($roles as $role)
                    <div class="input-group mb-6 col-12">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input name="user_roles[]" type="checkbox" value="{{$role->name}}" {{ checked(array_key_exists($role->name, $user_roles)) }} />
                            </div>
                        </div>
                        <input type="text" class="form-control" aria-label="Text input with checkbox" value="{{$role->name}} ( @foreach ($role->permissions as $p){{ $p->name }},  @endforeach)" size="40" readonly />
                    </div>
                @endforeach
            </div>
        </div>

        <fieldset disabled>
            <div class="row invisible">
                <span class="border border-primary rounded-lg border-3" style="margin-top:2em; padding:2em;">
                    <div class="col-lg-12">
                        <h3>Membership</h3>
                    </div>

                    <div class="col-10">
                        <div class="form-group form-inline">
                            Seniority Number
                            <input type="text" class="form-control"  placeholder="number" name="user_membership[seniority_number]" value="{{ old('user_membership.seniority_number', $user->membership->seniority_number)}}" size="20" required/>
                        </div>
                    </div>
                    <div class="col-lg-10">
                        <div class="form-group form-inline">
                            Member Status
                            <input type="text" class="form-control"  placeholder="status" name="user_membership[status]" value="{{ old('user_membership.status', $user->membership->status)}}" size="20" required/>
                        </div>
                    </div>
                    <div class="col-lg-10">
                        <div class="form-group form-inline">
                            Member Since
                            <input type="text" class="form-control"  placeholder="date" name="user_membership[membership_date]" value="{{ old('user_membership.membership_date', $user->membership->membership_date)}}" size="20" required/>
                        </div>
                    </div>
                    <div class="col-lg-10">
                        <div class="form-group form-inline">
                            Member Dues Status
                            <input type="text" class="form-control"  placeholder="dues status, paid until..." name="user_membership[membership_expires]" value="{{ old('user_membership.membership_expires', $user->membership->membership_expires)}}" size="20" required/>
                        </div>
                    </div>
                    <div class="col-lg-10" style="margin-top: 1em;">
                        <h4>Admin notes (admin only)</h4>
                    </div>
                    <div class="col-lg-10">
                        <textarea name="user_membership[admin_notes]" id="admin_notes" placeholder="Admin notes" class="form-control" disabled>{{old('user_membership.admin_notes', $user->membership->admin_notes)}}</textarea>
                    </div>
                 </span>
            </div>
        </fieldset>
        <div class="row" style="margin-top:30px;"> &nbsp;</div>
        <div class="row">
            <div class="col-sm">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
            </div>
    </form>
    <div class="col-sm"> &nbsp;</div>
    @if ($data['action'] == 'Edit')
        @hasanyrole('super-admin|admin')
         <div class="col-sm" style="float:right">
             (if admin)
             <form name="delete" method="POST" action="{{route('user_destroy')}}">
                 {!! csrf_field() !!}
                 {!! method_field('DELETE') !!}
                <i class="far fa-trash-alt fa-2x"></i>
                <input type="hidden" name="id[]" value="{{ $user->id }}">
                <input class="btn btn-outline-danger" type="submit" value="Delete">
            </form>
         </div>
        @endhasanyrole
    @endif
    <div class="row" style="margin-top:100px;"> &nbsp;</div>
</div>
@endsection
