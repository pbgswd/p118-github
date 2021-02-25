@extends('layouts.jumbo')
@section('content')
<div class="container">
    <div class="row border border-dark rounded-lg mt-2 p-2" style="background: rgba(220,220,220,0.8);">
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
                                    <a title="{{ $exec->name }}" href="{{ route('member', $exec->id)}}">
                                        @endauth
                                            {{$exec->name ?? ''}}
                                        @auth
                                    </a>
                                @endauth
                                <a href="mailto:{{$e->email}}">
                                    <i class="fas fa-envelope"></i>
                                </a>
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

    <div class="row border border-dark rounded-lg mt-2 p-2 my-3" style="background: rgba(220,220,220,0.8);">
        <div class="col-12 text-center my-3">
            <h1>Health & Welfare Administrators</h1>
        </div>
        @forelse($data['health'] as $h         )
            <div class="col-12 col-md-4 p-1">
                <div class="border border-dark rounded-lg w-100 h-100 p-2  text-center align-self-center">
                    <h4 class="text-center">
                        {{$h->title}}
                    </h4>
                    @forelse($h->current_executive_user as $hw)
                        <div class="col mt-3">
                            <h4>
                                @auth
                                    <a title="{{ $hw->name }}" href="{{ route('member', $hw->id) }}">
                                        @endauth
                                        {{$hw->name ?? ''}}
                                        @auth
                                    </a>
                                @endauth
                                <a href="mailto:{{$hw->email}}">
                                    <i class="fas fa-envelope"></i>
                                </a>
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
            <div class="text-center"> No entry</div>
        @endforelse
    </div>

    <div class="row border border-dark rounded-lg my-3 p-2" style="background: rgba(220,220,220,0.8);">
        <div class="col-12 text-center my-3">
            <h1>Local 118 Trustees</h1>
        </div>
        @forelse($data['trustees'] as $t)
            <div class="col-12 col-md-4 p-1">
                <div class="border border-dark rounded-lg w-100 h-100 p-2 text-center align-self-center">
                    <h4>
                        {{$t->title}}
                    </h4>
                    @forelse($t->current_executive_user as $hw)
                        <div class="col mt-3">
                            <h4>
                                @auth
                                    <a title="{{ $hw->name }}" href="{{ route('member', $hw->id) }}">
                                        @endauth
                                        {{$hw->name ?? ''}}
                                        @auth
                                    </a>
                                @endauth
                                <a href="mailto:{{$t->email}}">
                                    <i class="fas fa-envelope"></i>
                                </a>
                            </h4>
                            {{\Carbon\Carbon::parse($exec->pivot->start_date)->format('M j Y')}} -
                            {{\Carbon\Carbon::parse($exec->pivot->end_date)->format('M j Y')}}
                        </div>
                    @empty
                        <div class="text-center">No entry</div>
                    @endforelse
                </div>
            </div>
        @empty
            <div class="text-center">No entry</div>
        @endforelse
    </div>
    @auth
        <div class="row border border-dark rounded-lg mt-2 p-2" style="background: rgba(220,220,220,0.8);">
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
