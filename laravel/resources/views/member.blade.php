@extends('layouts.jumbo')
@section('content')
    <div class="container border border-dark rounded-lg pt-2 pb-3 my-3" style="background: rgba(220,220,220,0.8);">
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


        <div class="row">
            @if ( ($data['user']->user_info->image ?? '') && $data['user']->user_info->show_picture == 1 )
                <div class="col-6 col-md-12 mb-3">
                    <img src="{{ asset('storage/users/' . $data['user']->user_info->image) }}"
                         class="member-profile-pic border rounded-lg" />
                </div>
            @endif
        </div>
        <div class="row d-flex justify-content-between pt-2">
            @if (($data['user']->user_info->share_email ?? '' ) == 1)
                <div class="col-12 col-md-5 text-md-left">
                    <h5>
                        <a href="mailto:{{$data['user']->email}}" title="Email {{$data['user']->name}}">
                            <i class="fas fa-envelope"></i>
                            {{$data['user']->email}}
                        </a>
                    </h5>
                </div>
            @endif
            @if (($data['user']->user_info->share_phone  ?? '' )  == 1 &&
                !empty($data['user']->phone_number->phone_number))
                <div class="col-12 col-md-5 text-md-right">
                    <h5>
                        <a href="tel:{{$data['user']->phone_number->phone_number ?? '' }}">
                            <i class="fas fa-phone-square"></i>
                            {{$data['user']->phone_number->phone_number ?? '' }}
                        </a>
                    </h5>
                </div>
            @endif
        </div>
        <div class="col-12 pt-2">
            {!! $data['user']->user_info->about  ?? '' !!}
        </div>
        <div class="row d-flex justify-content-md-around px-2 mb-2">
            @if( $data['user']->allExecutiveRoles->count() > 0 )
                <div class="col-12 col-md-5 mb-2 p-2 border border-dark rounded-lg">
                    <h5>
                        Executive {{ Str::plural('Title', $data['user']->allExecutiveRoles->count()) }}
                    </h5>
                    <ul class="list-group">
                        @foreach($data['user']->allExecutiveRoles as $exec)
                           <li class="list-group-item">{{$exec->title}}
                                {{ \Carbon\Carbon::parse($exec->pivot->end_date)->isPast() ? '':'(Currently)'}}
                                <a href="mailto:{{$exec->email}}" title="Email {{$data['user']->name}} {{$exec->title}}
                                    at {{$exec->email}}">
                                    <i class="fas fa-envelope"></i>
                                </a>
                                {{\Carbon\Carbon::parse($exec->pivot->start_date)->format('M j Y')}} -
                                {{\Carbon\Carbon::parse($exec->pivot->end_date)->format('M j Y')}}
                           </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if($data['user']->committee_memberships->count() > 0)
                <div class="col-12 col-md-5 p-2 border border-dark rounded-lg">
                    <h5>
                        Membership in Committees
                    </h5>
                    <ul class="list-group">
                        @foreach($data['user']->committee_memberships as $m)
                            @if($m->pivot->role != 'Past-Member')
                                <li class="list-group-item">
                                    <a href="{{ route('committee', $m->slug) }}" title="{{$m->name}}">
                                        {{$m->name}} -  {{$m->pivot->role}}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        @if ( Auth::user()->id == $data['user']->id)
            <div class="row d-flex justify-content-between pt-3">
                <div class="col-12 col-md-4 text-md-left">
                    <h5>
                        <a href="{{route('edit_emergency_contact', $data['user']->id)}}">
                            <i class="fas fa-first-aid text-danger"></i>
                            <span class="font-weight-bold">
                            Update emergency contact
                        </span>
                        </a>
                    </h5>
                </div>
                <div class="col-12 col-md-3 text-md-center">
                    <h5>
                        <a href="{{route('member_edit', $data['user']->id)}}">
                            <i class="fas fa-user"></i>
                            <span class="font-weight-bold">
                            Update profile
                        </span>
                        </a>
                    </h5>
                </div>
                <div class="col-12 col-md-4 text-md-right">
                    <h5>
                        <a href="{{route('member_address_edit', $data['user']->id)}}">
                            <i class="fas fa-address-card text-success"></i>
                            <span class="font-weight-bold">
                                Update address
                            </span>
                        </a>
                    </h5>
                </div>
            </div>
        @endif
    </div>
@endsection
