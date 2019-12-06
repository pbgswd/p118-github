<?php
$post = $data;
$c = $data->committee;
?>
@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.6); padding: 2em">
        <div class="row">
               <h3>
                   <a href="{{ route('hello') }}">Home /</a>
                   <a href="{{route('committees')}}">Committees /</a>
                   <a href="{{ route('committee', $c->slug) }}">{{$c->name}} /</a>
                    {{$post->title}}
               </h3>
        </div>
        <div  class="col-12">
            <h1 class="display-4">{{$post->title}}</h1>
            <h5>By {{$post->creator->name}}, {{$post->updated_at}}</h5>
        </div>
        <div class="col-12">
            {!! $post->content !!}
        </div>
        <div class="row" style="margin-top:3em;">
            <h5>Comments for {{$post->title}}</h5>
        </div>
    </div>
</div>
@endsection




