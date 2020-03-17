<?php
$post = $data['post'];
$tags = join(', ', $post->tagNames());
?>
@extends('layouts.jumbo')
@section('content')
<div class="jumbotron">
    <div class="container border border-dark rounded-lg pt-lg-2" style="background: rgba(220,220,220,0.6);">
        <div class="row">
            @foreach ($post->topics as $topic)
                <a href="{{ route('hello') }}">Home /</a>
                &nbsp;<a href="{{route('topics')}}">Topics /</a>
                &nbsp;<a href="{{ route('topic_show', $topic->slug) }}">{{$topic->name}} /</a>
                &nbsp; {{$post->title}}
            @endforeach
        </div>
        <div  class="col-12">
            <h1 class="display-5">{{$post->title}}</h1>
        </div>
        <div class="col-12">
            <h3>{!! $post->description !!}</h3>
        </div>
        <div class="col-12">
            {!! $post->content !!}
         </div>
        @if ($tags != '')
            <div class="row">
                Tags: {{$tags}}
            </div>
        @endif
        <div class="row">
            <a href="{{route('posts')}}">Posts /</a> &nbsp;
                {{$post->title}}
        </div>
    </div>
    <div class="row mt-lg-5"></div>
</div>
@endsection




