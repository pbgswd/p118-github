@extends('layouts.jumbo')
@section('content')
    <div class="container border border-dark rounded-lg pt-2 pb-2 mb-3 mt-4" style="background: rgba(220,220,220,0.8);">
        <h2>
            <a href="{{route('members')}}">
                <i class="far fa-arrow-alt-circle-left"></i> Members /
            </a>
            {{$data['user']->name}}
            @if($data['user']->membership->membership_type != 'Member')
                ({{$data['user']->membership->membership_type}})
            @endif
        </h2>

        <div class="row">

            @if ( ($data['user']->user_info->image ?? '') && $data['user']->user_info->show_picture == 1 )
                <div class="col-6 col-md-12 mb-3">
                    <img src="{{ asset('storage/users/' . $data['user']->user_info->image) }}"
                         class="member-profile-pic" />
                </div>
            @endif


            <div class="col-6 col-md-12">
                @if ( Auth::user()->id == $data['user']->id)
                    <a href="{{route('member_edit', Auth::user()->id )}}" title="Edit my profile">
                        <button type="button" class="btn btn-primary">Edit My Profile</button>
                    </a>
                @endif
            </div>

        </div>
        <div class="col-12 pt-2">
            @if (($data['user']->user_info->share_email ?? '' ) == 1)
                <div
                <h5>
                    <a href="mailto:{{$data['user']->email}}" title="Email {{$data['user']->name}}">
                        <i class="fas fa-envelope"></i> {{$data['user']->email}}
                    </a>
                </h5>
            @endif
            @if (($data['user']->user_info->share_phone  ?? '' )  == 1 &&
                !empty($data['user']->phone_number->phone_number))
                <h5>
                    <a href="tel:{{$data['user']->phone_number->phone_number ?? '' }}">
                        <i class="fas fa-phone-square"></i> {{$data['user']->phone_number->phone_number ?? '' }}
                    </a>
                </h5>
            @endif
            <p>{!! $data['user']->user_info->about  ?? '' !!}</p>
        </div>


        <div class="row d-flex justify-content-md-around">
            @if( $data['user']->allExecutiveRoles->count() > 0 )
                <div class="col-sm-12 col-lg-5 mb-2 mr-1 border border-dark rounded-lg">
                    <div class="col-12">
                        <h4>
                            Executive {{ Str::plural('Title', $data['user']->allExecutiveRoles->count()) }}
                        </h4>
                    </div>
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
                <div class="col-sm-12 col-lg-5 border border-dark rounded-lg">
                    <div class="col-12">
                        <h4>
                            Membership in Committees
                        </h4>
                    </div>
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
</div>
@endsection
