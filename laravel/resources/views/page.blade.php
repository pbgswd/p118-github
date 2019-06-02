<?php
$page = $data['page'];
$tags = join(', ', $page->tagNames());
?>
@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.6);">
        <div  class="row">
            <h1 class="display-3">{{$page->title}}</h1>
        </div>
        <div class="row">
            <h2>{!! $page->description !!}</h2>
        </div>
        <div class="row">
            @if( $page->image )
                <div class="col-md-6">
                    <div class="col">
                        <img src="{{ asset('storage/'.$page->image) }}" />
                    </div>
                </div>
            @endif
            {!! $page->content !!}
         </div>
        <div class="row">
            Tags: {{$tags}}
        </div>
    </div>



<div class="row" style="margin-top:6em;"></div>

@endsection




