<?php
$post = $data['post'];
$tags = join(', ', $post->tagNames());
?>
@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.6); padding: 2em">
        <div class="row">
            @foreach ($post->topics as $topic)
                <a href="{{ route('hello') }}">Home /</a>
                <a href="{{route('topics')}}">Topics /</a>
                <a href="{{ route('topic_show', $topic->slug) }}">{{$topic->name}} /</a>
                {{$post->title}}
            @endforeach
        </div>
        <div  class="col-12">
            <h1 class="display-3">{{$post->title}}</h1>
        </div>
        <div class="col-12">
            <h2>{!! $post->description !!}</h2>
        </div>
        <div class="col-12">
            {!! $post->content !!}
         </div>
        @if ($tags != '')
            <div class="row">
                Tags: {{$tags}}
            </div>
        @endif
        <div class="row">post added by {{$post->user->name}}</div>
        <div class="row">
            @foreach ($post->topics as $topic)
                <a href="{{ route('hello') }}">Home /</a> &nbsp;
                <a href="{{route('topics')}}">Topics /</a> &nbsp;
                <a href="{{ route('topic_show', $topic->slug) }}">{{$topic->name}} /</a> &nbsp;
                {{$post->title}}
            @endforeach
        </div>
    </div>

<div class="row" style="margin-top:6em;"></div>
</div>
@endsection




