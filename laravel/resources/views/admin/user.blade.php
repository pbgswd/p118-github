<?php
$user = $data['user'];
$user_info = $data['user_info'];
$user_address = $data['user_address'];
$user_phone = $data['user_phone'];
$user_membership = $data['user_membership'];
$currentUserPermissions = $data['currentUserPermissions'];
$roles = $data['roles'];

?>
@extends('layouts.dashboard',  ['title' => ' <i class="fas fa-edit"></i>' . $data["action"] . ' Member ' . ($data["action"] == "Edit" ? $user->name : '') ])
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

    <h3>  <a href="{{ route('users_list') }}"> <i class="far fa-arrow-alt-circle-left"></i> List of members</a>  </h3>


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
        </div>

        <div class="row" style="margin-top:30px;"> &nbsp;</div>


        <div class="row">
            <div class="col-12 border border-primary rounded-lg border-3" style="margin:1em; padding:0.5em;">

                <div class="row">
                    <div class="form-group">
                        <div class="col-lg-2"><h4>Phone</h4></div>
                        <div class="col-lg-10">
                            <input type="text" class="form-control"  placeholder="Phone" name="user_phone[phone]" value="{{ old('user_phone.phone', $user_phone['phone'])}}" size="80" required/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-12">Share phone in contact information?

                            <label>
                                <input name="user_info[share_phone]" type="hidden" value="0" />
                                <input name="user_info[share_phone]" type="checkbox" value="1" {{ checked(old('user_info.share_phone',$user_info['share_phone'])) }} />
                            </label>
                        </div>
                        <div class="col-12">
                            <button type="button" class="btn btn-outline-primary">Add another phone number?</button>
                        </div>

                        <div class="col-12">
                            <label> Set as primary number?
                                <input name="user_phone[primary]" type="hidden" value="0" />
                                <input name="user_phone[primary]" type="checkbox" value="1" {{ checked(old('user_phone.primary',$user_phone['primary'])) }} />
                            </label>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-12 border border-primary rounded-lg border-3" style="margin:1em; padding:0.5em;">
                <div class="col-12"><h4>Member Info and Preferences</h4></div>
                @if( $user_info['image'] )
                    <div class="col">
                        <h4>
                            <i class="far fa-images"></i>
                            Image preview
                        </h4>
                        <h5>Currently: {{ $user_info['image'] }}</h5>
                        <img src="{{ asset('storage/' . $user_info['image']) }}" height="100px" />
                    </div>
                    <div class="col" style="margin-top: 3em;">
                        <input type="hidden"  name="user_info[image]" value="{{$user_info['image']}}" />
                        <label>
                            <input name="user_info[delete_image]" type="checkbox" value="1" /> Check to delete image
                        </label>
                    </div>
                @else
                    <div class="form-group">
                        <label for="exampleInputFile">
                            <i class="fas fa-cloud-upload-alt fa-2x"></i>
                            File input
                        </label>
                        <input type="file" id="inputFile" name="user_info[image]" />
                        <p class="help-block">
                            Upload image for your profile if you wish.
                        </p>
                    </div>
                @endif



            <div class="form-group">
                <div class="col-10"><h5>Share email in contact information?</h5></div>
                <div class="col-2">
                    <label>
                        <input name="user_info[share_email]" type="hidden" value="0" />
                        <input name="user_info[share_email]" type="checkbox" value="1" {{ checked(old('user_info.share_email', $user_info['share_email'])) }} />
                    </label>
                </div>
            </div>


        <div class="col-lg-10"><h4>About Me</h4></div>
        <div class="col-lg-10">
            <textarea name="user_info[about]" id="about" class="form-control"> {{ old('user_info.about', $user_info['about']) }} </textarea>
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
                        Apt # <input type="text" class="form-control" placeholder="Apt #" name="user_address[unit]" value="{{ old('user_address.unit', $user_address['unit']) }}" size="40" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        Street <input type="text" class="form-control" placeholder="Street" name="user_address[street]" value="{{ old('user_address.street', $user_address['street']) }}" size="40" required/>
                    </div>
                </div>
            </div>

            <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                           City <input type="text" class="form-control" placeholder="City" name="user_address[city]" value="{{ old('user_address.city', $user_address['city'])}}" size="40" required/>
                        </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        Province {{ select_options($data['provinces'], old('user_address.province', $user_address['province']), ['name' => 'user_address[province]', 'class' => 'form-control', 'placeholder' => 'Province']) }}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        Postal Code <input type="text" class="form-control"  placeholder="Postal Code" name="user_address[postal_code]" value="{{ old('user_address.postal_code', $user_address['postal_code'])}}" size="40" required/>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                    Country {{ select_options($data['countries'], old('user_address.country', $user_address['country']), ['name' => 'user_address[country]', 'class' => 'form-control', 'placeholder' => 'Country']) }}
                    </div>
                </div>
            </div>

        </div>

        <div class="row">&nbsp;
            <span class="border border-primary rounded-lg border-3" style="margin-top:2em; padding:2em;">
                <h4>User website roles</h4>
                @foreach ($roles as $id => $role)
                    <div class="col-10">
                        <label>
                            <input name="user[role][{{$id}}]" type="checkbox" value="{{$role}}" {{ checked(old('user.role[$id]',$user['role'])) }} /> {{$role}}
                        </label>
                     </div>
                @endforeach
            </span>
        </div>

        <div class="row">
            <span class="border border-primary rounded-lg border-3" style="margin-top:2em; padding:2em;">
                <div class="col-lg-10"><h3>Membership</h3></div>
                <div class="col-lg-10">
                  Seniority Number  <input type="text" class="form-control"  placeholder="number" name="user_membership[seniority_number]" value="{{ old('user_membership.seniority_number', $user_membership['seniority_number'])}}" size="80" required/>
                </div>

                <div class="col-lg-10">
                    Member Status <input type="text" class="form-control"  placeholder="status" name="user_membership[status]" value="{{ old('user_membership.membership_status', $user_membership['status'])}}" size="80" required/>
                </div>

                <div class="col-lg-10">
                    Member Since  <input type="text" class="form-control"  placeholder="date" name="user_membership[membership_date]" value="{{ old('user_membership.membership_date', $user_membership['membership_date'])}}" size="40" required/>
                </div>

                <div class="col-lg-10">
                    Member Dues Status <input type="text" class="form-control"  placeholder="dues status, paid until..." name="user_membership[membership_expires]" value="{{ old('user_membership.membership_expires', $user_membership['membership_expires'])}}" size="40" required/>
                </div>

            <div class="col-lg-10" style="margin-top: 1em;"><h4>Admin notes (admin only)</h4></div>
            <div class="col-lg-10">
                <textarea name="user_membership[admin_notes]" id="admin_notes" placeholder="Admin notes" class="form-control">{{old('user_membership.admin_notes', $user_membership['admin_notes'])}}</textarea>
            </div>
             </span>
        </div>


        <div class="row" style="margin-top:30px;"> &nbsp;</div>
        <div class="row">
            <div class="col-sm">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
            </div>
    </form>

         <div class="col-sm"> &nbsp;</div>
    @if ($data['action'] == 'Edit')
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
    @endif
    <div class="row" style="margin-top:100px;"> &nbsp;</div>
</div>
@endsection
