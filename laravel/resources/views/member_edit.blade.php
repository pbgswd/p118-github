@extends('layouts.jumbo')
@section('content')
<div class="container border border-dark rounded-lg pl-lg-5 pr-lg-5 mt-3 mb-3" style="background: rgba(220,220,220,0.8);">
    <div class="row">
        <div class="col-12 pt-2">
            <h3>
                <a href="{{route('members')}}">
                    <i class="far fa-arrow-alt-circle-left"></i>
                    Members /
                </a>
                <a href="{{route('member', $data['user']->id)}}">
                    {{$data['user']->name}}
                    @if($data['user']->membership->membership_type != 'Member')
                        ({{$data['user']->membership->membership_type}})
                    @endif
                </a>
            </h3>
        </div>
    </div>
    <div class="row d-flex justify-content-md-around">
        @if( $data['user']->allExecutiveRoles->count() > 0 )
            <div class="col-12 col-lg-5 border border-dark rounded-lg m-2 pt-2">
                <h4>
                    Executive {{ Str::plural('Title', $data['user']->allExecutiveRoles->count()) }}
                </h4>
                <ul class="list-group">
                    @foreach($data['user']->allExecutiveRoles as $exec)
                        <li class="list-group-item">{{$exec->title}}
                            {{ \Carbon\Carbon::parse($exec->pivot->end_date)->isPast() ? '':'(Currently)'}}
                            <a href="mailto:{{$exec->email}}" title="Email {{$data['user']->name}} {{$exec->title}}
                                at {{$exec->email}}">
                                <i class="fas fa-envelope"></i>
                            </a> <br />
                            {{\Carbon\Carbon::parse($exec->pivot->start_date)->format('M j Y')}} -
                            {{\Carbon\Carbon::parse($exec->pivot->end_date)->format('M j Y')}}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if($data['user']->committee_memberships->count() > 0)
            <div class="col-12 col-lg-5 border border-dark rounded-lg mt-2 mb-2 p-2">
                <h4>Membership in committees</h4>
                <ul class="list-group">
                    @foreach($data['user']->committee_memberships as $m)
                        @if($m->pivot->role != 'Past-Member')
                            <li class="list-group-item">
                                <a href="{{ route('committee', $m->slug) }}" title="{{$m->name}}">
                                    {{$m->name}} - {{$m->pivot->role}}
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    <form method="post" name="user" action="{{ url()->current() }}" enctype="multipart/form-data"
          class="needs-validation" novalidate>
        {!! csrf_field() !!}
        <input type="hidden" name="update_type" value="Profile" />
        <div class="row">
            <div class="col-12">

                <h3 class="mt-3 mb-3 fw-bold">
                    <i class="fas fa-user text-primary"></i>
                    Primary Contact Information
                </h3>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Name</span>
                    </div>
                    <input type="text" class="form-control"  placeholder="Name" name="user[name]"
                           value="{{ old('user.name', $data['user']->name)}}" size="80" required/>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Email</span>
                    </div>
                    <input type="text" class="form-control"  placeholder="Email" name="user[email]"
                           value="{{ old('user.email', $data['user']->email ?? '')}}" size="80" required/>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input name="user_info[share_email]" type="hidden" value="0" />
                            <input name="user_info[share_email]" type="checkbox" value="1"
                                {{ checked(old('user_info.share_email',
                                    $data['user']->user_info->share_email ?? '')) }} />
                        </div>
                    </div>
                    <input type="text" class="form-control" aria-label="Text input with checkbox"
                           value="Share email in profile?" size="40" readonly>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Phone</span>
                    </div>
                    <input type="tel" class="form-control"  placeholder="Phone" name="user_phone[phone_number]"
                           value="{{ old('user_phone.phone_number',
                           $data['user']->phone_number->phone_number ?? '') }}"
                           size="80"
                           required />
                </div>
                <div class="input-group mb-4 mb-lg-4">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input name="user_info[share_phone]" type="hidden" value="0" />
                            <input name="user_info[share_phone]" type="checkbox"
                                   value="1"
                                {{ checked(old('user_info.share_phone',
                                    $data['user']->user_info->share_phone ?? '')) }} />
                        </div>
                    </div>
                    <input type="text" class="form-control" aria-label="Text input with checkbox"
                           value="Share phone number in profile?" size="40" readonly>
                </div>
            </div>
            <div class="col-12 mt-md-3">
               <h5>
                   <i>
                       <i class="fas fa-asterisk"></i>
                       Note: This form will email the office contacts with updates
                       to your email address & phone number.
                   </i>
               </h5>
            </div>
        </div>
        <div class="row d-flex justify-content-around mt-2 pt-2 mb-md-3">
            <div class="col-12 col-md-5 mt-md-3">
                <h4>
                    <a href="{{route('member_address_edit', $data['user']->id)}}">
                        <i class="fas fa-address-card text-success"></i>
                        <span class="font-weight-bold">
                            Update address
                        </span>
                    </a>
                </h4>
            </div>
            <div class="col-12 col-md-5 mt-md-3">
                <h4>
                    <a href="{{route('edit_emergency_contact', $data['user']->id)}}">
                        <i class="fas fa-first-aid text-danger"></i>
                        <span class="font-weight-bold">
                            Update emergency contact
                        </span>
                    </a>
                </h4>
            </div>
        <div class="col-12 pt-2">
            <h3 class="mt-3 p-lg-2 fw-bold">
                <i class="fas fa-user text-primary"></i>
                Member Info
            </h3>
            <div class="input-group mb-6">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <input name="user_info[show_profile]" type="hidden" value="0" />
                        <input name="user_info[show_profile]" type="checkbox" value="1"
                            {{ checked(old('user_info.show_profile',
                                $data['user']->user_info->show_profile ?? '')) }} />
                    </div>
                </div>
                <input type="text" class="form-control" aria-label="Text input with checkbox"
                       value="Share profile with other members?" size="40" readonly>
            </div>
            @if( isset($data['user']->user_info->image) )
                <div class="col-6 mt-2">
                    <h4>
                        <i class="far fa-images"></i>
                        Image preview - Currently: {{ $data['user']->user_info->file_name }}
                    </h4>
                    <img src="{{ asset('storage/users/'. $data['user']->user_info->image) }}"
                         class="m-1 member-profile-pic"/>
                    <input type="hidden" name="user_info[image]" value="{{$data['user']->user_info->image}}" />
                </div>
                <div class="col-6 mt-2">
                    <i class="fas fa-info-circle"></i>
                    Image help: use an image ideally no wider than 250px.
                </div>
                <div class="input-group mb-6">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input name="user_info[delete_image]" type="checkbox" value="1" />
                        </div>
                    </div>
                    <input type="text" class="form-control" aria-label="Text input with checkbox"
                           value=" Check to delete image." size="40" readonly>
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
                            {{ checked(old('user_info.show_picture', $data['user']->user_info->show_picture ?? '')) }} />
                    </div>
                </div>
                <input type="text" class="form-control" aria-label="Text input with checkbox"
                       value="Show picture in your profile?" size="40" readonly>
            </div>
            <h3 class="mt-lg-5 p-lg-2 fw-bold">
                <i class="fas fa-user text-primary"></i>
                About Me
            </h3>
            <div class="col-12 input-group mb-3">
                @if (!optional($data['user']->user_info)->about || empty(optional($data['user']->user_info)->about))
                    <p class="font-italic">
                        Add something here about you such as your experience in
                        stage and theatre, your skills. Do you have a side hustle?
                        Got creative work? Tell us about it! Share your social media
                        links if you like.
                    </p>
                @endif
                <textarea name="user_info[about]" id="about" class="form-control">
                    {{ old('user_info.about', $data['user']->user_info->about ?? '') }}
                </textarea>
            </div>
            <div class="pt-5 pl-2 m-2">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-primary btn-lg" type="submit" value="{{ $data['action'] }} My Profile" />
            </div>
        </div>
    </form>
</div>
@endsection
