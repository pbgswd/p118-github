<?php
$page = $data['page'];
$tags = join(', ', $page->tagNames());
?>
@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.6); padding: 2em">
        <div  class="col-12">
            <h1 class="display-3">{{$page->title}}</h1>
        </div>
        <div class="col-12">
            <h2>{!! $page->description !!}</h2>
        </div>
        <div class="col-12">
            @if( $page->image )
                <div class="col-md-6">
                    <div class="col">
                        <img src="{{ asset('storage/'.$page->image) }}" />
                    </div>
                </div>
            @endif
            {!! $page->content !!}
         </div>
        @if ($tags != '')
            <div class="row">
                Tags: {{$tags}}
            </div>
        @endif
        <div class="row">Page added by {{$page->user->name}}</div>
    </div>
<div class="row" style="margin-top:6em;"></div>
</div>
@endsection




