@extends('layouts.jumbo')
@section('content')
<div class="container">
    <div class="row border border-dark rounded-lg mt-2 p-2">
        <div class="col-12 text-center my-3">
            <h1>Local 118 Executive</h1>
        </div>
        @forelse($data['executive'] as $e)
            <div class="col-12 col-md-3 p-1">
                <div class="border border-dark rounded-lg w-100 h-100 p-2 text-center">
                    <h4 class="text-center">
                        {{$e->title}}
                    </h4>
                    @forelse($e->current_executive_user as $exec)
                        <div class="col mt-3 text-center align-self-center">
                            <h4>
                                @auth
                                    @if(true === $exec->user_info->show_profile)
                                        <a title="{{ $exec->name }}" href="{{ route('member', $exec->id)}}">
                                    @endif
                                @endauth
                                {{$exec->name ?? ''}}
                                @auth
                                    @if(true === $exec->user_info->show_profile)
                                        </a>
                                    @endif
                                    <a href="mailto:{{$e->email}}">
                                        <i class="fas fa-envelope"></i>
                                    </a>
                                @endauth
                            </h4>
                            {{\Carbon\Carbon::parse($exec->pivot->start_date)->format('M j Y')}} -
                            {{\Carbon\Carbon::parse($exec->pivot->end_date)->format('M j Y')}}
                        </div>
                    @empty
                        <div class="text-center"> No entry</div>
                    @endforelse
                </div>
            </div>
        @empty
           No entry
        @endforelse
    </div>
    @auth
    <div class="row border border-dark rounded-lg mt-2 p-2 my-3">
        <div class="col-12 text-center my-3">
            <h1>Health & Welfare Administrators</h1>
        </div>
        @forelse($data['health'] as $h)
            @forelse($h->current_executive_user as $hw)
                <div class="col-12 col-md-4 p-1">
                    <div class="border border-dark rounded-lg w-100 h-100 p-2 text-center">
                        <h4 class="text-center">
                            {{$h->title}}
                        </h4>
                        <h4>
                            @auth
                                @if(true === $hw->user_info->show_profile)
                                    <a title="{{ $hw->name }}" href="{{ route('member', $hw->id) }}">
                                @endif
                            @endauth
                                {{$hw->name ?? ''}}
                            @auth
                                @if(true === $hw->user_info->show_profile)
                                    </a>
                                @endif
                                <a href="mailto:{{$h->email}}">
                                    <i class="fas fa-envelope"></i>
                                </a>
                            @endauth
                        </h4>
                    </div>
                </div>
            @empty
                <div class="text-center"> No entry</div>
            @endforelse
        @empty
            <div class="text-center"> No entry</div>
        @endforelse
    </div>

    <div class="row border border-dark rounded-lg my-3 p-2">
        <div class="col-12 text-center my-3">
            <h1>Local 118 Trustees</h1>
        </div>
        @forelse($data['trustees'] as $t)
            @foreach($t->current_executive_user as $trustee )
                <div class="col-12 col-md-4 p-1">
                    <div class="border border-dark rounded-lg w-100 h-100 p-2 text-center">
                        <h4>{{$t->title }}</h4>
                        <h4>
                            @auth
                                @if(true === $trustee->user_info->show_profile)
                                    <a title="{{ $trustee->name }}"
                                       href="{{ route('member', $trustee->id) }}">
                                @endif
                            @endauth
                            {{$trustee->name ?? ''}}
                            @auth
                                @if(true === $trustee->user_info->show_profile)
                                    </a>
                                @endif
                                <a href="mailto:{{$t->email}}">
                                    <i class="fas fa-envelope"></i>
                                </a>
                            @endauth
                        </h4>
                        {{\Carbon\Carbon::parse($trustee->pivot->start_date)->format('M j Y')}} -
                        {{\Carbon\Carbon::parse($trustee->pivot->end_date)->format('M j Y')}}
                    </div>
                </div>
            @endforeach
        </div>
    @empty
        <div class="text-center">No entry</div>
    @endforelse

        <div class="row border border-dark rounded-lg mt-2 p-2">
            <div class="col-12 text-center my-3">
                <h1>Local 118 Committees</h1>
            </div>
            @forelse($data['committees'] as $c)
                <div class="col-12 col-md-4 p-1">
                    <div class="border border-dark rounded-lg w-100 h-100 p-2 text-center align-self-center">
                        <h4>
                            <a href="{{route('committee', $c->slug)}}">
                            {{$c->name}}
                            </a>
                        </h4>
                    </div>
                </div>
            @empty
                <div class="text-center"> No entry</div>
            @endforelse
        </div>
    @endauth
@endsection
