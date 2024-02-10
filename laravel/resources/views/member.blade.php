@extends('layouts.jumbo')
@section('content')
    <div class="container border border-dark rounded pt-2 pb-3 my-3">
        <div class="row p-2">
            <div class="col-12 col-md-6 w-100">
                <h3>
                    <a href="{{route('members')}}">
                        <i class="far fa-arrow-alt-circle-left"></i> Members /
                    </a>
                    {{$data['user']->name}}
                    @if($data['user']->membership->membership_type != 'Member')
                        ({{$data['user']->membership->membership_type}})
                    @endif
                </h3>
            </div>
            @can(['edit users'])
                <div class="col-12 col-md-6 text-md-right">
                    <a href="{{route('user_edit', $data['user']->id)}}"
                       title="Edit {{$data['user']->name}}">
                        <i class="fas fa-edit"></i> Admin Edit
                    </a>
                </div>
            @endcan
        </div>
        @if (Auth::user()->id == $data['user']->id)
            <div class="row">
                <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">My Profile</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">
                            <i class="fas fa-user"></i>
                            Edit Profile</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="emerg-tab" data-bs-toggle="tab" data-bs-target="#emerg-tab-pane" type="button" role="tab" aria-controls="emerg-tab-pane" aria-selected="false">
                            <i class="fas fa-first-aid text-danger"></i>
                            Emergency Contact</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="address-tab" data-bs-toggle="tab" data-bs-target="#address-tab-pane" type="button" role="tab" aria-controls="address-tab-pane" aria-selected="false">
                            <i class="fas fa-address-card text-success"></i>
                            Address</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password-tab-pane" type="button" role="tab" aria-controls="password-tab-pane" aria-selected="false">
                            <i class="fas fa-unlock-alt"></i>
                            Change Password</button>
                    </li>
                </ul>
            </div>
        @endif
        @if ( Auth::user()->id == $data['user']->id)
            <div class="row mt-5 align-top">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                        @include('member_profile')
                    </div>
                    <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                        @include('member_edit')
                    </div>
                    <div class="tab-pane fade" id="emerg-tab-pane" role="tabpanel" aria-labelledby="emerg-tab" tabindex="0">
                        @include('member_emergency_edit')
                    </div>
                    <div class="tab-pane fade" id="address-tab-pane" role="tabpanel" aria-labelledby="address-tab" tabindex="0">
                        @include('member_address_edit')
                    </div>
                    <div class="tab-pane fade align-top" id="password-tab-pane" role="tabpanel" aria-labelledby="password-tab" tabindex="0">
                       @include('member_password_edit')
                    </div>
                </div>
            </div>
        @else
            @include('member_profile')
        @endif
    </div>
@endsection
