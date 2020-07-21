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
                    @auth
                        <a title="{{ $e->user[0]->name }}" href="{{ route('member', $e->user[0]->id) }}">
                    @endauth
                    {{$e->user[0]->name ?? ''}}
                    @auth
                        </a>
                    @endauth
                    <a href="mailto:{{$e->email}}">{{$e->email}}</a>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
