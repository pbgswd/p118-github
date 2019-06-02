<?php
$topic = $data['topic'];
$tags = join(', ', $topic->tagNames());
?>
@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.6); padding:1em;">
        <div class="row">
            <h1 class="display-3">{{$topic->name}}</h1>
        </div>
        <div class="row">
                <h2>{!! $topic->description !!}</h2>
        </div>
        <div class="row">
            @if( $topic->image )
                <div class="col-md-6">
                    <div class="col">
                        <img src="{{ asset('storage/'.$topic->image) }}" />
                    </div>
                </div>
            @endif
            {!! $topic->description !!}
        </div>
        <div class="row">
            Tags: {{$tags}}
        </div>
    </div>
</div>



<div class="row" style="margin-top:6em;"></div>

@endsection




