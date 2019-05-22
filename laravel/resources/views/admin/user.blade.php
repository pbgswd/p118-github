<?php
$user = $data['user'];
?>
@extends('layouts.dashboard',  ['title' => ' <i class="fas fa-edit"></i>' . $data["action"] . ' Member ' . ($data["action"] == "Edit" ? $user->name : '') ])
@section('content')

    <script>
        tinymce.init({
            selector: 'textarea#admin_notes',
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
        <div class="row" style="margin-top:30px;"> &nbsp;</div>
        <div class="row">
            <div class="form-group">
                <div class="col-lg-2"><h4>Name</h4></div>
                <div class="col-lg-10">
                    <input type="text" class="form-control"  placeholder="Name" name="user[name]" value="{{ old('user.name', $user->name)}}" size="80" required/>
                </div>
            </div>
        </div>

        <div class="row" style="border-width:6px; !important;">
            @if( $user->image )
                <div class="col-md-6">
                    <div class="col">
                        <h4>
                            <i class="far fa-images"></i>
                            Image preview
                        </h4>

                        <h5>Currently: {{ $user->image }}</h5>
                        <img src="{{ asset('storage/'.$user->image) }}" />
                    </div>
                    <div class="col" style="margin-top: 3em;">
                        <input type="hidden"  name="user[image]" value="{{$user->image}}" />
                        <label>
                            <input name="user[delete_image]" type="checkbox" value="1" /> Check to delete image
                        </label>
                    </div>
                </div>
            @else
                <div class="col-md-6">
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
        <div class="row" style="margin-top:30px;"> &nbsp;</div>

        <div class="row">
            <div class="col-lg-12"><h3>Primary Contact Information</h3></div>
            <div class="form-group">
                <div class="col-lg-2"><h4>Email</h4></div>
                <div class="col-lg-10">
                    <input type="text" class="form-control"  placeholder="Email" name="user[email]" value="{{ old('user.email', $user->email)}}" size="80" required/>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <div class="col-10"><h5>Share email in contact information?</h5></div>
                <div class="col-2">
                    <label>
                        <input name="user[share_email]" type="hidden" value="0" />
                        <input name="user[share_email]" type="checkbox" value="1" {{ checked(old('user.share_email',$user->share_email)) }} />
                    </label>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <div class="col-lg-2"><h4>Phone</h4></div>
                <div class="col-lg-10">
                    <input type="text" class="form-control"  placeholder="Phone" name="user[phone]" value="{{ old('user.phone', $user->phone)}}" size="80" required/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-6"><h5>Share phone in contact information?</h5></div>
                <div class="col-3">
                    <label>
                        <input name="user[share_phone]" type="hidden" value="0" />
                        <input name="user[share_phone]" type="checkbox" value="1" {{ checked(old('user.share_phone',$user->share_phone)) }} />
                    </label>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <div class="col-lg-10"><h4>Primary Mailing Address</h4></div>
                <div class="col-lg-10">
                    Street <input type="text" class="form-control"  placeholder="Street" name="user[street]" value="{{ old('user.street', $user->street)}}" size="80" required/>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-10">
                   City <input type="text" class="form-control"  placeholder="City" name="user[city]" value="{{ old('user.city', $user->city)}}" size="80" required/>
                </div>
            </div>


            <div class="col-lg-10">
                Province
                name="user[province]" value="{{ old('user.province', $user->province)}}"
            </div>

            <div class="col-8">
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Example Province select</label>
                    <select name="province" class="form-control" id="exampleFormControlSelect1">
                        <option value="">Select</option>
                        <option value="BC">British Columbia</option>
                        <option value="AB">Alberta</option>
                        <option value="YUK">Yukon</option>
                        <option value="NWT">Northwest Territories</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-10">
                 Postal Code <input type="text" class="form-control"  placeholder="Postal Code" name="user[postal_code]" value="{{ old('user.postal_code', $user->postal_code)}}" size="80" required/>
                </div>

                    <div class="col-lg-10">
                    Country (drop down menu)
                 Country" name="user[country]" value=" {{ old('user.country', $user->country)}}
                    </div>
                <div class="col-8">
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Example Country select</label>
                        <select name="province" class="form-control" id="exampleFormControlSelect1">
                            <option value="">Select</option>
                            <option value="CA">Canada</option>
                            <option value="US">United States</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" >
            <span class="border border-primary rounded-lg border-3" style="margin-top:2em; padding:2em;">
                <div class="col-lg-10"><h4>Membership</h4></div>
                <div class="col-lg-10"><h4>Seniority Number</h4></div>
                <div class="col-lg-10">
                    <input type="text" class="form-control"  placeholder="number" name="user[membership_number]" value="{{ old('user.membership_number', $user->membership_number)}}" size="80" required/>
                </div>

                <div class="col-lg-10"><h4>Status</h4></div>
                <div class="col-lg-10">
                    Member Status <input type="text" class="form-control"  placeholder="status" name="user[membership_status]" value="{{ old('user.membership_date', $user->membership_status)}}" size="80" required/>
                </div>

                <div class="col-lg-10">
                    Member Since  <input type="text" class="form-control"  placeholder="date" name="user[membership_date]" value="{{ old('user.membership_date', $user->membership_date)}}" size="80" required/>

                <input type="text" class="datepicker"  name="user[publish_date]" value="{{ old('user.publish_date', $user->publish_date) }}" size="20" placeholder="Membership Date" />


                </div>

                <div class="col-lg-10">
                    Member Dues Status <input type="text" class="form-control"  placeholder="dues status, paid until..." name="user[member_since]" value="{{ old('user.postal_code', $user->postal_code)}}" size="80" required/>
                </div>
            </span>
        </div>

        <div class="row">
             <span class="border border-primary rounded-lg border-3" style="margin-top:2em; padding:2em;">
                 <h4>User website access privleges</h4>
             </span>
           &nbsp;
            <span class="border border-primary rounded-lg border-3" style="margin-top:2em; padding:2em;">
                 <h4>User website roles</h4>
             </span>
        </div>

        <div class="row">
             <span class="border border-primary rounded-lg border-3" style="margin-top:2em; padding:2em;">
            <div class="col-lg-10"><h4>Admin notes (admin only)</h4></div>
            <div class="col-lg-10">
                <textarea name="user[admin_notes]" id="admin_notes" placeholder="Admin notes" class="form-control">{{old('user.admin_notes', $user->admin_notes)}}</textarea>
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
