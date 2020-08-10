@extends('layouts.jumbo')
@section('content')
<div class="container">
    <div class="row border border-light rounded-lg p-lg-2 mb-2" style="background: #fff;">
        <div class="col-12 mb-lg-1">
            <h1>{{config('app.name')}}</h1>
        </div>
    </div>
    <div class="row border border-light rounded-lg p-lg-2" style="background: rgba(220,220,220,0.8);">
        <div class="col-12">
            <h1> Executive </h1>
        </div>
         @foreach($data as $e)
            <div class="col-12 mb-3">
                <h3>{{$e->title}}</h3>
                 @if( !empty($e->user[0]))
                    @foreach($e->current_executive_user as $exec)
                        <h5>
                            @auth
                                <a title="{{ $exec->name }}" href="{{ route('member', $exec->id) }}">
                            @endauth
                            {{$exec->name ?? ''}}
                            @auth
                                </a>
                            @endauth
                            <a href="mailto:{{$e->email}}">
                                <i class="fas fa-envelope"></i>
                            </a>
                            {{\Carbon\Carbon::parse($exec->pivot->start_date)->format('M j Y')}}
                            - {{\Carbon\Carbon::parse($exec->pivot->end_date)->format('M j Y')}}
                        </h5>
                    @endforeach
                @else
                    <i>(To be assigned)</i>
                @endif
            </div>
        @endforeach
    </div>
</div>
@endsection
