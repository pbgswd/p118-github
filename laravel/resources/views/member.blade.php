@extends('layouts.jumbo')
@section('content')
    <div class="jumbotron mb-lg-5">
        <div class="container border border-dark rounded-lg p-2" style="background: rgba(220,220,220,0.8);">
            <h1>
                <a href="{{route('members')}}">
                    <i class="far fa-arrow-alt-circle-left"></i> Members /
                </a>
                {{$data['user']->name}}
                @if($data['user']->membership->membership_type != 'Member')
                    ({{$data['user']->membership->membership_type}})
                @endif
            </h1>
            <div class="row">
                @if ( ($data['user']->user_info->image ?? '') && $data['user']->user_info->show_picture == 1 )
                    <div class="col-1">
                        <img src="{{ asset('storage/users/' . $data['user']->user_info->image) }}" />
                    </div>
                @endif
                <div class="col-3">
                    @if ( Auth::user()->id == $data['user']->id)
                        <div class="col-12 mt-lg-4">
                            <a href="{{route('member_edit', Auth::user()->id )}}" title="Edit my profile">
                                <button type="button" class="btn btn-primary">Edit My Profile</button>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-12">
                @if (($data['user']->user_info->share_email ?? '' ) == 1)
                    <h3>
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:{{$data['user']->email}}" title="Email {{$data['user']->name}}">
                            {{$data['user']->email}}
                        </a>
                    </h3>
                @endif
                @if (($data['user']->user_info->share_phone  ?? '' )  == 1 &&
                    !empty($data['user']->phone_number->phone_number))
                    <h3>
                        <i class="fas fa-phone-square"></i>
                        <a href="tel:{{$data['user']->phone_number->phone_number ?? '' }}">
                            {{$data['user']->phone_number->phone_number ?? '' }}
                        </a>
                    </h3>
                @endif
                <p>{!! $data['user']->user_info->about  ?? '' !!}</p>
            </div>
            <div class="row p-4">
                @if( $data['user']->allExecutiveRoles->count() > 0 )
                    <div class="col-6 border border-dark rounded-lg mt-3 mr-1">
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
                @endif
                @if($data['user']->committee_memberships->count() > 0)
                    <div class="col-5 border border-dark rounded-lg mt-3">
                        <h4>Membership in committees</h4>
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
        </div>
    </div>
@endsection
