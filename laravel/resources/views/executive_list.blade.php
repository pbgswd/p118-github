@extends('layouts.jumbo')
@section('content')
<div class="container">
    <div class="row border border-dark rounded-lg mt-3 pt-2" style="background: rgba(220,220,220,0.8);">
        <div class="col-12">
            <h1>Local 118 Executive</h1>
        </div>
        @forelse($data as $e)
        <div class="col-12 col-md-4 p-2">
            <div class="border border-dark rounded-lg p-2">
                <h4>{{$e->title}}</h4>
                @forelse($e->current_executive_user as $exec)
                    <div class="col mt-3">
                    <h4>
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
                    </h4>

                    {{\Carbon\Carbon::parse($exec->pivot->start_date)->format('M j Y')}} -
                    {{\Carbon\Carbon::parse($exec->pivot->end_date)->format('M j Y')}}
                    </div>
                @empty
                   No entry
                @endforelse
            </div>
        </div>
        @empty
           No entry
        @endforelse
    </div>
</div>
@endsection
